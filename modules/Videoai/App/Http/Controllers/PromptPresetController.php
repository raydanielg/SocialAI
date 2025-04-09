<?php

namespace Modules\Videoai\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Modules\Videoai\App\Models\PromptPreset;

class PromptPresetController extends Controller
{

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'prompt' => ['required', 'string', 'max:1000'],
        ]);
        PromptPreset::create(array_merge($validated, [
            'user_id' => Auth::id(),
            'status' => 'active',
            'description' => $request->title
        ]));
        return back()->with('success', 'Created Successfully');
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'prompt' => ['required', 'string','max:1000'],
        ]);
        $preset = PromptPreset::where('user_id', Auth::id())->findOrFail($id);
        $preset->update([
            'title' => $request->title,
            'prompt' => $request->prompt
        ]);
        return back()->with('success', 'Updated Successfully');
    }

    public function destroy($id)
    {
        PromptPreset::where('user_id', Auth::id())
            ->findOrFail($id)
            ->delete();
        return back()->with('success', 'Deleted Successfully');
    }
}
