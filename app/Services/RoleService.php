<?php

namespace App\Services;

use App\Models\User;
use App\Models\Trek;
use App\Models\Trekuser;
use App\Models\Trekker;
use App\Models\Departure;
use DateTime;
use DB;
use Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class RoleService
{
    public function getRoles()
    {
        $data = Role::with('permissions')->get()->map(function ($query) {
            return [$query->name => $query->permissions->map(function ($q){
                return $q->name;
            })];
        });

        return($data);
    }

    public function getPermissions()
    {
        $data = Permission::get()->map(function ($query) {
            return $query->name;
        });

        return($data);
    }

    public function edit($role)
    {
        $data = Role::where('name', $role)->with('permissions')->get()->map(function ($query) {
            return [$query->name => $query->permissions->map(function ($q){
                return $q->name;
            })];
        });

        return($data);
    }

    public function update($data)
    {
        $role = Role::where('name', $data['id'])->update([
            'name' => $data['name']
        ]);
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        $role = Role::findByName($data['name']);
        $role->syncPermissions($data['permissions']);

        return response(200);
    }

    public function delete($id)
    {
        $role = Role::findByName($id);
        $role->delete();
        
        return response(200);
    }

    public function create($request)
    {
        $role = Role::firstOrCreate(['name' => $request['name']])
            ->givePermissionTo($request['permissions']);
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        
        return response(200);
    }
}
