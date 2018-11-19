<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Http\Requests\Admin\UserCreateRequest;
use App\Http\Requests\Admin\UserUpdateRequest;
use App\Http\Requests\Admin\ToggleUserRoleRequest;

use Auth;
use DB;
use Input;
use Mail;
use App\Mail\PermissionChanged;

class UserController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = collect();

        if($request->has('search')){
            $users = User::search('email', $request->search)
                ->where('id', '!=', Auth::user()->id)
                ->simplePaginate(20)
                ->appends(Input::except('page'));
        }

        if ($request->ajax() || $request->wantsJson()) {
            return $users;
        }

        return view('admin.user.index')
            ->withRoles(Role::togglableRoles()->get())
            ->withUsers($users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.create')
            ->withRoles(Role::userRoles()->pluck('name','id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserCreateRequest $request)
    {
        $user = User::create($request->all());
        $user->attachRole($request->role);

        flash()->success('User '.$user->name.' created');
        return redirect(route('admin.user.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('admin.user.show')
            ->withUser($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('admin.user.edit')
            ->withUser($user)
            ->withRoles(Role::userRoles()->pluck('name','id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        if (!$user->editable) {
            flash()->error('Can not edit this user');
            return response()->view('errors.403', [], 403);
        }

        $user->update($request->all());
        if($request->role){
            DB::table('role_user')->where('role_user.user_id',$user->id)->delete();
            $user->attachRole($request->role);
        }

        flash()->success('User updated');
        return redirect(route('admin.user.edit', $user->id));
    }


    public function toggleRole(ToggleUserRoleRequest $request)
    {
        $user = User::findOrFail($request->user_id);

        DB::table('role_user')->where('role_user.user_id',$user->id)->delete();

        $role = Role::find($request->role_id);
        $user->attachRole($role->id);

        if ($role->name != 'Business') {
            $user->update(['business_id' => null]);
        }
        flash()->success('Set user '.$user->name.' role to '.$role->name);
        Mail::to($user)->send(new PermissionChanged($user));
        return redirect()->back();
    }

    public function setBusiness(Request $request, User $user)
    {

        if (!$user->editable) {
            flash()->error('Can not toggle role for user '.$user->name);
        } else {
            $request->validate([
                'business_id' => 'required|exists:businesses,id'
            ]);

            $user->business_id = $request->business_id;
            $user->save();
            flash()->success('Business is set');
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if($user->id == Auth::user()->id){
            flash()->error('Can not delete yourself');
            return response()->view('errors.403', [], 403);
        } else if(!$user->deletable) {
            flash()->error('Can not delete this account');
            return response()->view('errors.403', [], 403);
        }

        $name = $user->name;

        $user->delete();
        flash()->success('User ' . $name . ' deleted');
        return redirect()->back();
    }
}
