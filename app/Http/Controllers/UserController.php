<?php

namespace App\Http\Controllers;

use App\Log;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Auth::user()->hasRole(['admin']);

        $users = User::where('role', 'user')->get();
        return view('pages.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Auth::user()->hasRole(['admin']);

        return view('pages.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Auth::user()->hasRole(['admin']);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = new User();
        $user['name'] = $request->name;
        $user['username'] = $request->username;
        $user['password'] = Hash::make($request->password);
        $user['role'] = 'user';

        if($user->save()) session()->flash('toast', ['success', 'Pengguna berhasil ditambahkan']);
        else session()->flash('toast', ['error', 'Pengguna gagal ditambahkan']);

        return redirect('/user');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $logs = Log::where('user_id', $user->id)->get();

        return view('pages.log.index', compact('logs'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        Auth::user()->hasRole(['admin']);

        return view('pages.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        Auth::user()->hasRole(['admin']);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', "unique:users,username,$user->id,id"],
        ]);

        $user->name = $request->name;
        $user->username = $request->username;

        if($user->save()) session()->flash('toast', ['success', 'Pengguna berhasil diubah']);
        else session()->flash('toast', ['error', 'Pengguna gagal diubah']);

        return redirect('/user');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        Auth::user()->hasRole(['admin']);

        if($user->delete()) session()->flash('toast', ['success', 'Pengguna berhasil dihapus']);
        else session()->flash('toast', ['error', 'Pengguna gagal dihapus']);

        return redirect('/user');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit_password(User $user)
    {
        return view('pages.user.password', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_password(Request $request, User $user)
    {
        $request->validate([
            'current_password' => ['required', 'string', 'min:8',
                function($attribute, $value, $fail){
                    if (!Hash::check($value, Auth::user()->password)) {
                        $fail('Your current password doesn\'t match');
                    }
                }
            ],
            'password' => ['required', 'string', 'confirmed'],
        ]);

        $user->update([
            'password' => Hash::make($request['password'])
        ]);

        if($user->save()) session()->flash('toast', ['success', 'Password berhasil diubah']);
        else session()->flash('toast', ['error', 'Password gagal diubah']);

        return redirect('/data');
    }
}
