<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Traits\Uploader;

class PartnerController extends Controller
{
    use Uploader;

    public function __construct()
    {
        $this->middleware('permission:partners');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $segments = request()->segments();
        $buttons = [
            [
                'name' => '<i class="fa fa-plus"></i>&nbsp' . __('Create a partner'),
                'url' => '#',
                'target' => '#addNewPartnerDrawer',
            ]
        ];
        $brands = Category::whereType('partner')->latest()->paginate(10);
        $totalBrands = Category::whereType('partner')->count();
        $activeBrands = Category::whereType('partner')->where('status', 1)->count();
        $inActiveBrands = Category::whereType('partner')->where('status', 0)->count();

        return inertia('Admin/Brand/Index', [
            'brands' => $brands,
            'totalBrands' => $totalBrands,
            'activeBrands' => $activeBrands,
            'inActiveBrands' => $inActiveBrands,
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
            'url' => ['max:100'],
            'preview' => ['required', 'image', 'max:1024'],

        ]);

        $preview = $this->saveFile($request, 'preview');

        Category::create([
            'title' => $request->url ?? '#',
            'slug' => Str::random(),
            'status' => $request->status,
            'type' => 'partner',
            'preview' => $preview,
            'lang' => $request->type,
        ]);

        return redirect()->back();
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }

        $data = $request->validate([
            'partner.title' => ['max:100'],
            'partner.preview' => ['nullable', 'image', 'max:1024'],
        ]);

        $brand = Category::where('type', 'partner')->findOrFail($id);

        if ($request->hasFile('partner.preview')) {
            $preview = $this->saveFile($request, 'partner.preview');
            if (!empty($brand->slug)) {
                $this->removeFile($brand->slug);
            }
        } else {
            $preview = $brand->slug;
        }

        $brand->update([
            'title' => $data['partner']['title'] ?? '#',
            'status' => $request['partner']['status'],
            'lang' => $request['partner']['lang'],
            'type' => $request['partner']['type'],
            'preview' => $preview,
        ]);

        return redirect()->route('admin.partner.index');
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
       
        $brand = Category::findOrFail($id);
        $this->removeFile($brand->slug);
        $brand->delete();

        return redirect()->back();
    }
}
