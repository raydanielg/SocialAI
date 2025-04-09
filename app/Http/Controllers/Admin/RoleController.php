<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Inertia\Inertia;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:roles');
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
                'name' => '<i class="fa fa-plus"></i>  &nbsp' . __('Create Role'),
                'url' => route('admin.role.create')
            ],
        ];


        $roles = Role::with('permissions')->where('id','!=',1)->get();
        return Inertia::render('Admin/Role/Index', compact('roles', 'segments', 'buttons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
        $permissions_groups = User::getPermissionGroup()->map(function ($q) {
            $data['group_name'] = $q->group_name;
            $data['permissions'] = User::getpermissionsByGroupName($q->group_name);

            return $data;
        });
        $segments = request()->segments();

        $buttons = [
            [
                'name' => __('Back'),
                'url' => route('admin.role.index')
            ],
        ];


        return Inertia::render('Admin/Role/Create', compact(
            'permissions_groups',
            'segments',
            'buttons'
        ));
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
            'name' => 'required|unique:roles|max:100',
        ]);
        $role = Role::create(['name' => $request->name]);
        $permissions = $request->input('permissions');
        if (!empty($permissions)) {

            $role->syncPermissions($permissions);
        }

        return to_route('admin.role.index');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $role = Role::findById($id);
        $all_permissions = Permission::all();
        $permission_groups = User::getpermissionGroups();
        return view('admin.role.edit', compact('role', 'all_permissions', 'permission_groups'));
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
        // Validation Data
        $request->validate([
            'name' => 'required|max:100|unique:roles,name,' . $id
        ], [
            'name.requried' => 'Please give a role name'
        ]);

        $role = Role::findById($id);
        $permissions = $request->input('permissions');

        if (!empty($permissions)) {
            $role->syncPermissions($permissions);
        }

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
        Role::where('id','!=',1)->where('id',$id)->delete();
        return back();
    }
}
