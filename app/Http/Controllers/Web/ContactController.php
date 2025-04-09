<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Mail\ContactMail;
use App\Helpers\SeoMeta;
use App\Traits\Seo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class ContactController extends Controller
{
    use Seo;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contact = get_option('contact_page', true);

        SeoMeta::init('seo_contact');
        return Inertia::render('Web/Contact', [
            'contact' => $contact,
        ]);
    }

    /**
     * Send email to the admin
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:40'],
            'email' => ['required', 'email', 'max:40'],
            'subject' => 'required|max:100',
            'message' => 'required|max:500',
        ]);


        try {
            throw_if(!env('MAIL_TO'), 'Admin Email Not Set Yet!');

            $data['name'] = $request->name;
            $data['email'] = $request->email;
            $data['subject'] = $request->subject;
            $data['message'] = $request->message;


            switch (env('QUEUE_MAIL')) {
                case true:
                    Mail::to(env('MAIL_TO'))->queue(new ContactMail($data));
                    break;
                default:
                    Mail::to(env('MAIL_TO'))->send(new ContactMail($data));
                    break;
            }

        } catch (Exception $e) {
            return back()->with('danger', $e->getMessage());
        }
        return back()->with('success', 'Message has been send successfully');

    }
}
