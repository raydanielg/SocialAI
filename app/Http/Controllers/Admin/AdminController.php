<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\PageHeader;
use App\Models\User;
use Inertia\Inertia;
use App\Services\Toastr;
use Illuminate\Support\Str;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:admin');
    }

    public function index()
    {
        PageHeader::set(
            title: 'Admin List',
            buttons: [
                [
                    'name' => '<i class="fa fa-plus"></i>&nbsp' . __('Create a admin'),
                    'url' => route('admin.admin.create')
                ]
            ]
        );
        $users = User::where('role', 'admin')->with('roles')->where('id', '!=', 1)->latest()->get();

        return Inertia::render('Admin/Admin/Index', [
            'users' => $users
        ]);
    }

    public function create()
    {

        $roles = Role::all();

        PageHeader::set(
            title: 'Create Admin',
            buttons: [
                [
                    'name' => __('Back'),
                    'url' => route('admin.admin.index')
                ]
            ]
        );

        return Inertia::render('Admin/Admin/Create', [
            'roles' => $roles,
        ]);
    }

    public function store(Request $request)
    {
        if(env('DEMO_MODE')){
            return back()->with('danger', __('Permission disabled for demo mode..!'));
       }
        // Validation Data
        $request->validate([
            'name' => 'required|max:50',
            'roles' => 'required',
            'email' => 'required|max:100|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        // Create New User
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = 'admin';
        $user->password = Hash::make($request->password);
        $user->save();

        if ($request->roles) {
            $user->assignRole($request->roles);
        }

        return to_route('admin.admin.index')->with('success', 'Admin created successfully!');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $user = User::with('roles')->findOrFail($id);
        $roles = Role::all();

        $segments = request()->segments();
        $buttons = [
            [
                'name' => __('Back'),
                'url' => route('admin.admin.index')
            ]
        ];

        return Inertia::render('Admin/Admin/Edit', compact('segments', 'buttons', 'user', 'roles'));
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
        // Create New User
        $user = User::find($id);

        // Validation Data
        $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|max:100|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6|confirmed',
        ]);


        $user->name = $request->name;
        $user->email = $request->email;
        $user->status = $request->status;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        $user->roles()->detach();
        if ($request->roles) {
            $user->assignRole($request->roles);
        }

        Toastr::success('Updated Successfully');


        return back()->with('success', 'Admin updated successfully!');
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

        User::destroy($id);

        Toastr::danger('Deleted Successfully');

        return back();
    }

    public function adminNotificationsRead(Notification $notification)
    {

        
        $notification->seen = 1;
        $notification->save();
        return response()->json([
            'success' => true
        ]);
    }
}
