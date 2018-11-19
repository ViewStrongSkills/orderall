<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\Admin\RoleCreateRequest;
use App\Http\Requests\Admin\RoleUpdateRequest;
use App\Role;
use App\Module;
use App\Permission;
use Route;
use DB;

class RoleController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.role.index')
            ->withRoles(Role::orderBy('created_at', 'desc')->paginate(20));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.role.create')
            ->withModules(Module::getModules());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleCreateRequest $request)
    {
        $role = Role::create($request->all());
        $role->attachPermissions($request->permissions);

        flash()->success('Role "'.$role->name.'" created');
        return redirect(route('admin.role.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {

        $permissions = Permission::join("permission_role","permission_role.permission_id","=","permissions.id")
            ->where("permission_role.role_id",$role->id)
            ->get();

        return view('admin.role.edit')
            ->withRole($role)
            ->withModules(Module::getModules())
            ->withModulesSelectOptions(Module::getModulesSelectOptions())
            ->withPermissions($permissions);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleUpdateRequest $request, Role $role)
    {
        $role->update($request->all());
        // 
        if($role->editable){
            $role->attachPermissions($request->permissions, $role->id);
        }

        flash()->success('Role "'.$role->name.'" updated');
        return redirect(route('admin.role.edit', $role->id));
    }

    public function updateDeveloperPermissions()
    {
        $role = Role::where('name', 'Developer')->first();
        $modules = Module::getModules();

        foreach ($modules as $key => $value) {
            foreach ($value['methods'] as $method) {
                $name = $key . '.' . $method['key'];
                if( Permission::where('name', $name)->first() ) 
                    continue;
                Permission::create([
                    'name' => $key . '.' . $method['key'],
                    'display_name' => $key . '.' . $method['key'],
                    'description' => ''
                ]);
            }
        }

        DB::table('permission_role')->where('permission_role.role_id', $role->id)->delete();
        foreach (Permission::get() as $permission) {
            $role->attachPermission($permission);
        }
        
        flash()->success('Developer Permissions Updated');
        return redirect(route('admin.role.index'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        // Do not allow to delete developer role
        if(!$role->deleteable){
            flash()->error('Can not delete developer role  "' . $role->name . '"');
            return ['result' => false];            
        }

        $title = $role->name;
        $role->delete();
        flash()->success('Role '.$title.' deleted');
        return [
            'result' => true,
            'redirect' => route('admin.role.index')
        ];        

    }
}
