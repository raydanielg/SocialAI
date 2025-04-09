<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Traits\Notifications;
use App\Models\User;
use Auth;
use Inertia\Inertia;

class NotifyController extends Controller
{

    use Notifications;

    public function __construct()
    {
        $this->middleware('permission:notification');
    }

    public function index(Request $request)
    {
        $segments = request()->segments();
        $buttons = [
            [
                'name' => '<i class="fa fa-plus"></i>&nbsp' . __('Create Notification'),
                'url' => '#',
                'target' => '#addNewNotificationDrawer'
            ]
        ];

        $notifications = Notification::query()->with('user')->where('for_admin', 0);

        if (!empty($request->search)) {
            if ($request->type == 'email') {
                $notifications = $notifications->whereHas('user', function ($q) use ($request) {
                    return $q->where('email', $request->search);
                });
            } else {
                $notifications = $notifications->where($request->type, 'LIKE', '%' . $request->search . '%');
            }
        }

        $totalNotifications = $notifications->clone()->count();
        $readNotifications = $notifications->clone()->where('seen', 1)->count();
        $unreadNotifications = $notifications->clone()->where('seen', 0)->count();

        $notifications = $notifications->latest()->paginate(30);
        $type = $request->type ?? 'email';

        return Inertia::render('Admin/Logs/Notification/Index', [
            'notifications' => $notifications,
            'request' => $request,
            'type' => $type,
            'totalNotifications' => $totalNotifications,
            'readNotifications' => $readNotifications,
            'unreadNotifications' => $unreadNotifications,
            'buttons' => $buttons,
            'segments' => $segments,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }
        $request->validate([
            'title' => 'required|max:100',
            'email' => 'required|email|exists:users,email',
            'description' => 'required',
            'url' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        $title = $request->title;
        $notification['user_id'] = $user->id;
        $notification['title'] = $title;
        $notification['comment'] = $request->description;
        $notification['url'] = $request->url;

        $this->createNotification($notification);

        return back();
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }
        $row = Notification::findOrFail($id);
        $row->delete();

        return redirect()->back();
    }
}
