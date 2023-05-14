<?php

namespace App\Http\Controllers;

use App\Models\Pemasok;
use Illuminate\Http\Request;

class PemasokController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('search')){
            $data=Pemasok::where('nama','like',"%{$request->search}%")
                ->orWhere('alamat','like',"%{$request->search}%")
                ->orWhere('no_tlp','like',"%{$request->search}%")
                ->paginate(5);
            return view('pemasok.pemasok')
                ->with('data',$data);
        }
        $data=Pemasok::paginate(5);
        return view('pemasok.pemasok')
            ->with('data',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pemasok.create_pemasok')
            ->with('url_form',url('pemasok'));
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
            'nama'=>'required',
            'alamat'=>'required',
            'no_tlp'=>'required',
    ]);
    Pemasok::create($request->all());
    return redirect('pemasok')
        ->with('success','Data pemasok berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pemasok  $pemasok
     * @return \Illuminate\Http\Response
     */
    public function show(Pemasok $pemasok)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pemasok  $pemasok
     * @return \Illuminate\Http\Response
     */
    public function edit(Pemasok $pemasok)
    {
        return view('pemasok.create_pemasok')
            ->with('url_form', url('pemasok/' . $pemasok->id))
            ->with('data', $pemasok);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pemasok  $pemasok
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pemasok $pemasok)
    {
        $request->validate([
            'nama'=>'required',
            'alamat'=>'required',
            'no_tlp'=>'required',
        ]);
        $pemasok->update($request->all());
        return redirect('pemasok')
            ->with('success', 'Data pemasok berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pemasok  $pemasok
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pemasok $pemasok)
    {
        $pemasok->delete();
        return redirect('pemasok')
            ->with('success', 'Data pemasok berhasil dihapus');
    }
}
