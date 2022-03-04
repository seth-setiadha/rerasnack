<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    private $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->userRepository->index();
        return view("users.index", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = new User();

        return view('users.create', ['data' => $data] );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();   // return array

        $validatedData['password'] = Hash::make($validatedData['password']);
        $user = User::create($validatedData);
        if(! $user) {
            $request->session()->flash('error', 'Data belum berhasil disimpan');
            return redirect( route('users.create') );
        }
        $request->session()->flash('status', 'Data sudah berhasil disimpan');
        
        if($request->input('action') == "saveplus") {
            return redirect( route('users.create') );
        }
        return redirect( route('users.show', ['user' => $user->id ]) );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        if(! $user) {
            return redirect( route('users.create') );
        }
        return view('users.edit', ['data' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if($user) {
            return view('users.edit', ['data' => $user]);
        } else {
            return redirect( route('users.index') );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $validatedData = $request->validated();

        if(! empty($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }

        if(! $user->update( $validatedData ) ) {
            $request->session()->flash('error', 'Data belum berhasil disimpan');
            return redirect( route('users.edit') );
        }
        $request->session()->flash('status', 'Data sudah berhasil disimpan');
        return redirect( route('users.show', ['user' => $user->id ]) );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    public function resetpwd(Request $request) {
        $newPwd = $request->input('password');
        $newPwdConf = $request->input('password_confirmation');

        if(!($newPwd && $newPwdConf)) {
            return view('users.reset');
        } else {
            $user = User::where('id', Auth::user()->id)->first();
            if($newPwd === $newPwdConf) {
                $user->password = Hash::make($newPwd);
                $user->save();
                $request->session()->flash('status', 'Password sudah berhasil diperbaharui!');
                return redirect( route('home') ); 
            } else {
                $request->session()->flash('error', 'New password and Confirmed password is not match!');
                return redirect()->back(); 
            }
        }
    }
}
