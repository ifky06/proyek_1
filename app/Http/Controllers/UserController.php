<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Riwayat;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected string $location = 'user';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $role = ['Owner', 'Admin', 'Kasir'];
        if (auth()->user()->role == 0) {
            $data = User::paginate(5);
        } else {
            $data = User::where('role', 2)->paginate(5);
        }
        foreach ($data as $key => $value) {
            $data [$key]->rolename = $role [$value->role];
        }

        return view ('user.user')->with([
            'data' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.create_user')
            ->with('url_form',url('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'username'=>'required|unique:users',
            'name'=>'required',
            'email'=>'required',
            'password'=>'required|max:8',
            'role'=>'required',
        ]);
        $request->merge([
            'password'=>Hash::make($request->password)
        ]);
        User::create($request->all());
        Riwayat::add('store', $this->location, $request->username);
        return redirect('user')
            ->with('success','User berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('user.create_user')
            ->with('url_form',url('user/'.$user->id))
            ->with('data',$user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'username'=>'required|unique:users,username,'.$user->id,
            'name'=>'required',
            'email'=>'required',
            'password'=>'max:8',
            'role'=>'required',
        ]);

        if ($request->password) {
            $request->merge([
                'password'=>Hash::make($request->password)
            ]);
        } else {
            $request->merge([
                'password'=>$user->password
            ]);
        }

        $user->update($request->all());
        Riwayat::add('update', $this->location, $user->username);
        return redirect('user')
            ->with('success', 'User berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        Riwayat::add('delete', $this->location, $user->username);
        return redirect('user')
            ->with('success', 'User berhasil dihapus');
    }
}
