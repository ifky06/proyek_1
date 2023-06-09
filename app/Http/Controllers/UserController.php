<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Riwayat;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

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
        return view ('user.user');
    }

    public function data()
    {
        $role = ['Owner', 'Admin', 'Kasir'];
        $data=User::all();
        foreach ($data as $key => $value) {
            $data [$key]->rolename = $role [$value->role];
        }
        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
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
            'email'=>'required|unique:users',
            'password'=>'required|min:8',
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
    public function show()
    {
        $role = ['Owner', 'Admin', 'Kasir'];
        $data = auth()->user();
        $data['rolename']= $role [$data->role];
        return view('user.user_profile')
                ->with('data',$data);
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
            'email'=>'required|unique:users,email,'.$user->id,
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

    public function self_update(Request $request)
    {
        $request->validate([
            'username'=>'required|unique:users,username,'.auth()->user()->id,
            'name'=>'required',
            'email'=>'required|unique:users,email,'.auth()->user()->id,
            'password'=>'max:8',
        ]);

        if ($request->password) {
            $request->merge([
                'password'=>Hash::make($request->password)
            ]);
        } else {
            $request->merge([
                'password'=>auth()->user()->password
            ]);
        }
        
        $data = User::find(auth()->user()->id);
        $data->update($request->all());
        Riwayat::add('update', $this->location, auth()->user()->username);
        return redirect('user/profile')
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
