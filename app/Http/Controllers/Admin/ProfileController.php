<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function settings()
    {
        $segments = request()->segments();
        $buttons = [
            [
                'name' => __('Back to dashboard'),
                'url' => url('admin/dashboard'),
            ]
        ];
        $user = User::findOrFail(Auth::id());
        return Inertia::render('Admin/Profile/Edit', [
            'segments' => $segments,
            'buttons' => $buttons,
            'user' => $user,
        ]);
    }

    public function update(Request $request, $type)
    {
        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }
        $user = User::findOrFail(Auth::id());

        if ($type == 'password') {
            $validatedData = $request->validate([
                'password' => ['required', 'string', 'min:8', 'max:100', 'confirmed'],
                'oldpassword' => ['required', 'string'],
            ]);

            $check = Hash::check($request->oldpassword, auth()->user()->password);
            if ($check == true) {
                $user->password = Hash::make($request->password);
            } else {
                return back()->withErrors(['password' => __('Old password is wrong')]);
            }

            $message = __('Password Updated Successfully');
        } elseif ($type == 'auth-key') {
            $user->authkey = $this->generateAuthKey();
            $user->save();
            $message = __('Auth Key ReGenerated successfully.');
            return back()->with('success', $message);
        } else {
            $validatedData = $request->validate([
                'user.email' => 'required|email|unique:users,email,' . Auth::id(),
                'user.phone' => 'required|numeric|unique:users,phone,' . Auth::id(),
                'user.name' => ['required', 'string', 'max:100'],
                'user.address' => ['required', 'string', 'max:150'],
                'user.avatar' => ['nullable', 'image', 'max:1024'],
            ]);

            $user->name = $validatedData['user']['name'];
            $user->email = $validatedData['user']['email'];
            $user->phone = $validatedData['user']['phone'];
            $user->address = $validatedData['user']['address'];


            if ($request->hasFile('user.avatar')) {
                $file = $request->file('user.avatar');
                $ext = $file->extension();
                $filename = now()->timestamp . '.' . $ext;

                $path = 'uploads/' . Auth::id() . date('/y') . '/' . date('m') . '/';
                $filePath = $path . $filename;
                Storage::put($filePath, file_get_contents($file));
                if ($user->avatar != null) {
                    $fileArr = explode('uploads', $user->avatar);
                    if (isset($fileArr[1])) {
                        $oldavatar = 'uploads' . $fileArr[1];
                        if (Storage::exists($oldavatar)) {
                            Storage::delete($oldavatar);
                        }
                    }
                }
                $user->avatar = Storage::url($filePath);
            }
        }

        $user->save();

        return redirect()->back();
    }
}
