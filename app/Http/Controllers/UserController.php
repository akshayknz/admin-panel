<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use Auth;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserService $userService)
    {
        $this->middleware('auth');
        // $this -> middleware('permission:user management');
        $this->userService = $userService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('users');
    }

    public function list(){
        $data = $this->userService->getList();

        return $data;
    }

    public function edit(Request $request){
        $data = $this->userService->edit($request->id);

        return $data;
    }

    public function update(Request $request){
        $validated = $request->validate([
            'userid' => 'required|integer',
            'name' => 'required',
            'email' => 'required|unique:users,email,'.$request->userid.'|email|max:255',
            'password' => 'required_if:change-password,on|min:8|nullable',
            'change-password' => '',
            'confirm-password' => 'required_if:change-password,on|same:password|nullable',
            'roles' => 'required',
        ]);

        $data = $this->userService->update($validated);

        return $data;
    }

    public function create(Request $request){
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email|email|max:255',
            'password' => 'required|min:8',
            'confirm-password' => 'required|same:password',
            'roles' => 'required',
        ]);

        $data = $this->userService->create($validated);

        return $data;
    }

    public function delete(Request $request){
        $data = $this->userService->delete($request->id);

        return $data;
    }

}
