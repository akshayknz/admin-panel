<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RoleService;
use Auth;

class RoleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(RoleService $roleService)
    {
        $this->middleware('auth');
        $this -> middleware('permission:role management')->except(['list']);
        $this->roleService = $roleService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('roles');
    }

    public function list(){
        $data = $this->roleService->getRoles();

        return $data;
    }

    public function listPermissions(){
        $data = $this->roleService->getPermissions();

        return $data;
    }

    public function edit(Request $request){
        $data = $this->roleService->edit($request->id);

        return $data;
    }

    public function update(Request $request){
        $validated = $request->validate([
            'id' => 'required',
            'name' => 'required',
            'permissions' => 'required'
        ]);

        $data = $this->roleService->update($validated);

        return $data;
    }

    public function delete(Request $request){
        $data = $this->roleService->delete($request->id);

        return $data;
    }

    public function create(Request $request){
        $validated = $request->validate([
            'name' => 'required',
            'permissions' => 'required'
        ]);

        $data = $this->roleService->create($validated);

        return $data;
    }

}
