<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\DataTables\UserDataTable;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except'=>'setSuperAdmin']);
    }

    public function index(UserDataTable $dataTable)
    {
        // Example get permission from user => model_has_permissions
        // dd(auth()->user()->getPermissionNames()->toArray());
        if(! auth()->user()->can('user-menu')) {
            abort(403);
        }

        return $dataTable->render('user.index', [
            'users' => User::get(),
            'roles' => Role::get(),
        ]);
    }

    public function store(UserRequest $request)
    {
        // Example add permission to user
        // dd(auth()->user()->givePermissionTo('user-menu'));
        if(! auth()->user()->can('create-user')) {
            abort(403);
        }

        DB::beginTransaction();
        try {
            $valid = $request->validated();
            $valid['password'] = Hash::make($valid['password']);
        	unset($valid['roles']);
            
            $user = User::create($valid);
            $user->assignRole(request('roles'));

            DB::commit();
            return ['status' => true, 'message' => "User created"];
        } catch (\Throwable $th) {
            DB::rollBack();
            return ['status' => false, 'message' => $th->getMessage()];
        }
    }

    public function update(UserRequest $request, User $user)
    {
        if(! auth()->user()->can('edit-user')) {
            abort(403);
        }

        DB::beginTransaction();
        try {
            $valid = $request->validated();
            unset($valid['roles']);
            if (request('password')) {
                $valid['password'] = Hash::make(request('password'));
            }

            $user->update($valid);
            $user->syncRoles(request('roles'));

            DB::commit();
            return ['status' => true, 'message' => "User updated"];
        } catch (\Throwable $th) {
            DB::rollBack();
            return ['status' => false, 'message' => $th->getMessage()];
        }
    }

    public function approve($id)
    {
        if(! auth()->user()->can('approve-user')) {
            return ['status' => false, 'message' => "Permission denied !"];
        }

        DB::beginTransaction();
        try {
            $user = User::find($id);
            if(! $user){
                return ['status' => false, 'message' => "User not found !"];
            }
            $user->update(['status'=>1]);

            DB::commit();
            return ['status' => true, 'message' => "User approved"];
        } catch (\Throwable $th) {
            DB::rollBack();
            return ['status' => false, 'message' => $th->getMessage()];
        }
    }

    public function show(User $user)
    {
        if(! auth()->user()->can('edit-user')) {
            abort(403);
        }
        
        return [
            'user' => $user,
            'roles' => $user->getRoleNames(),
        ];
    }

    public function detail($id)
    {
        if(! auth()->user()->hasRole('Super Admin')) {
            abort(403);
        }
        
        $user = User::findOrFail($id);
        return view('user.profile', ['user'=>$user]);
    }

    public function destroy(User $user)
    {
        if(! auth()->user()->can('delete-user')) {
            return ['status' => false, 'message' => "Permission denied !"];
        }

        DB::beginTransaction();
        try {
            $user->syncRoles([]);
            $user->delete();

            DB::commit();
            return ['status' => true, 'message' => "User deleted"];
        } catch (\Throwable $th) {
            DB::rollBack();
            return ['status' => false, 'message' => $th->getMessage()];
        }
    }

    public function setSuperAdmin()
    {
        DB::beginTransaction();
        try {
            $permissions = \App\Models\Permission::get();
            if(!$permissions->count()) {
                $data = [
                    ['name'=>'user-menu','guard_name'=>'web'],
                    ['name'=>'role-menu','guard_name'=>'web'],
                    ['name'=>'create-user','guard_name'=>'web'],
                    ['name'=>'edit-user','guard_name'=>'web'],
                    ['name'=>'delete-user','guard_name'=>'web'],
                    ['name'=>'approve-user','guard_name'=>'web'],
                    ['name'=>'create-role','guard_name'=>'web'],
                    ['name'=>'edit-role','guard_name'=>'web'],
                    ['name'=>'delete-role','guard_name'=>'web'],
                    ['name'=>'customer-home','guard_name'=>'web'],
                ];
                foreach($data as $key => $row) {
                    if($key > 1 && strpos($row['name'], 'user') !== false) {
                        $row['parent_id'] = \App\Models\Permission::whereName('user-menu')->first()->id;
                    }elseif($key > 1 && strpos($row['name'], 'role') !== false) {
                        $row['parent_id'] = \App\Models\Permission::whereName('role-menu')->first()->id;
                    }
                    \App\Models\Permission::create($row);
                }
                $permissions = \App\Models\Permission::get();
                $customerPermissions = \App\Models\Permission::whereName('customer-home')->get();
            }

            $role = Role::whereName('Super Admin')->first();
            if(!$role) {
                $role = Role::create(['name'=>'Super Admin','guard_name'=>'web']);
                $customer = Role::create(['name'=>'Customer','guard_name'=>'web']); 
            }
            $role->givePermissionTo($permissions);
            $customer->givePermissionTo($customerPermissions);

            $user = User::first();
            if(!$user) {
                $user = User::create([
                    'name'=>'Heri Fidiawan',
                    'email'=>'heryfidiawan07@gmail.com',
                    'password'=>Hash::make('12345678'),
                    'status'=>1
                ]);
            }
            if($user->roles->count() > 0) {
                $user->syncRoles($role);
            }else {
                $user->assignRole($role);
            }

            DB::commit();
            return ['status' => true, 'message' => "The Super Admin Assigned"];
        } catch (\Throwable $th) {
            DB::rollBack();
            return ['status' => false, 'message' => $th->getMessage()];
        }
    }
}
