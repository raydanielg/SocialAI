<?php

namespace App\Http\Controllers\Admin;

use Throwable;
use App\Models\Post;
use Inertia\Inertia;
use App\Actions\Page;
use App\Helpers\PageHeader;
use Illuminate\Http\Request;
use App\Http\Requests\PageRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class PageController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:custom-page');
    }

    public function index()
    {
        PageHeader::set()
            ->title(__('Pages'))
            ->buttons([
                [
                    'name' => '<i class="fa fa-plus"></i>&nbsp' . __('Create a page'),
                    'url' => route('admin.page.create'),
                ]
            ]);

        $pages = Post::where('type', 'page')->orderBy('id', 'desc')->paginate(20);
        $totalActivePosts = Post::where('type', 'page')->where('status', 1)->count();
        $totalInActivePosts = Post::where('type', 'page')->where('status', 0)->count();
        $totalPosts = Post::where('type', 'page')->count();

        return Inertia::render('Admin/Page/Index', [
            'pages' => $pages,
            'totalActivePosts' => $totalActivePosts,
            'totalInActivePosts' => $totalInActivePosts,
            'totalPosts' => $totalPosts,
        ]);
    }


    public function create()
    {
        PageHeader::set()
            ->title(__('Create Page'))
            ->buttons([
                [
                    'name' => __('Back'),
                    'url' => route('admin.page.index'),
                ]
            ]);

        return Inertia::render('Admin/Page/Create');
    }

    public function store(PageRequest $request, Page $page)
    {

        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }
        DB::beginTransaction();
        try {
            $page = $page->create($request);
            DB::commit();
        } catch (Throwable $th) {
            DB::rollback();
            return back()->with('error', $th->getMessage());
        }

        return to_route('admin.page.index');
    }

    public function edit($id)
    {
        PageHeader::set()
            ->title(__('Edit Page'))
            ->buttons([
                [
                    'name' => __('Back'),
                    'url' => route('admin.page.index'),
                ]
            ]);
        $info = Post::with('description', 'seo')->findOrFail($id);
        $seo = json_decode($info->seo->value ?? '');


        return Inertia::render('Admin/Page/Edit', [
            'info' => $info,
            'seo' => $seo,
        ]);
    }

    public function update(Request $request, $id, Page $page)
    {

        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }
        $request->validate([
            'title' => 'required|max: 150',
            'description.value' => 'required|max:5000',
        ]);

        DB::beginTransaction();
        try {
            $page = $page->update($request, $id);
            DB::commit();
        } catch (Throwable $th) {
            DB::rollback();
            return back()->with('error', $th->getMessage());
        }

        return to_route('admin.page.index');
    }

    public function destroy($id)
    {
        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }
        $page = Post::findOrFail($id);
        $page->delete();
        Cache::forget("page_{$page->slug}");

        return back()->with('danger', 'Deleted Successfully');
    }
}
