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

class UserService
{

    public function getList()
    {
        $data = User::with(['roles' => function ($query) {
            $query->select('name');
        }])->get()->map(function ($query){
            return [
                'id' => $query->id,
                'name' => $query->name,
                'email' => $query->email,
                'roles' => $query->roles->map(function ($item, $key) {
                    return $item->name;
                })
            ];
        });

        return($data);
    }

    public function edit($id)
    {
        $data = User::where('id', $id)->with(['roles' => function ($query) {
            $query->select('name');
        }])->get()->map(function ($query){
            return [
                'id' => $query->id,
                'name' => $query->name,
                'email' => $query->email,
                'roles' => $query->roles->map(function ($item, $key) {
                    return $item->name;
                })
            ];
        });
        // $data->push(Role::get()->map(function ($query){
        //     return $query->name;
        // }));

        return($data);
    }

    public function update($request)
    {
        $user = User::find($request['userid']);
        $user->name = $request['name'];
        $user->email = $request['email'];
        if(isset($request['change-password'])){
            $user->password = Hash::make($request['password']);
        }
        $user->updated_at = Carbon::now();
        $user->syncRoles($request['roles']);
        $user->save();
        // $user->assignRole($request['roles']);
        
        return response(200);
    }

    public function create($request)
    {
        $user = new User;
        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->password = Hash::make($request['password']);
        $user->created_at = Carbon::now();
        $user->updated_at = Carbon::now();
        $user->save();
        $user->syncRoles($request['roles']);
        // $user->assignRole($request['roles']);
        
        return response(200);
    }

    public function delete($id)
    {
        $user = User::find($id);
        $user->delete();
        
        return response(200);
    }
}
