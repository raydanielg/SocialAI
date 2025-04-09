<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AiLanguageController extends Controller
{
    public $languages;
    public $path;

    public function __construct()
    {
        $this->middleware('permission:ai-language');
        $this->path = base_path('database/json/languages.json');
        if (file_exists($this->path)) {
            $this->languages = json_decode(file_get_contents($this->path), true);
        } else {
            $this->languages = [];
        }
    }

    public function index()
    {
        $segments = request()->segments();
        $buttons = [
            [
                'name' => '<i class="fa fa-plus"></i>&nbsp' . __('Create a Language'),
                'url' => '#',
                'target' => '#addNewCurrencyDrawer',
            ]
        ];

        return Inertia::render('Admin/AiLanguage/Index', [
            'languages' => $this->languages,
            'buttons' => $buttons,
            'segments' => $segments,
        ]);
    }

    public function store(Request $request)
    {

        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }
        $request->validate([
            'name' => 'required|string'
        ]);
        $newLanguage = [
            "id" => !empty($this->languages) ?  max(array_keys($this->languages)) + 1 : 1,
            "name" => $request->input('name')
        ];
        $this->languages[$newLanguage['id']] = $newLanguage;

        file_put_contents($this->path, json_encode($this->languages, JSON_PRETTY_PRINT));

        return to_route('admin.ai-language.index');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }

        $request->validate([
            'name' => 'required|string'
        ]);

        if (isset($this->languages[$id])) {
            $this->languages[$id]['name'] = $request->input('name');

            file_put_contents($this->path, json_encode($this->languages, JSON_PRETTY_PRINT));
        }
        return to_route('admin.ai-language.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }
       
        if (isset($this->languages[$id])) {
            unset($this->languages[$id]);
            file_put_contents($this->path, json_encode($this->languages, JSON_PRETTY_PRINT));
        }
        return to_route('admin.ai-language.index')->with('danger', 'Deleted Successfully');
    }
}
