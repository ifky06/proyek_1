<?php

namespace App\Http\Controllers;

use App\Exports\TransaksiKeluarExport;
use App\Models\Barang;
use App\Models\Detail_transaksi_keluar;
use App\Models\Transaksi_Keluar;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class TransaksiKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=Barang::all();
        return view('kasir')
            ->with('data',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->input('data' )['item'];
        $payment = $request->input('data')['payment'];


        Transaksi_Keluar::create([
            'qty' => $payment['qty'],
            'grand_total' => $payment['total'],
            'bayar' => $payment['bayar'],
            'kembalian' => $payment['kembali'],
            'id_users' => auth()->user()->id,
        ]);

        $transaksi_id = Transaksi_Keluar::latest()->first()->id;
        date_default_timezone_set('Asia/Jakarta');

        foreach ($data as $item) {
            Detail_transaksi_keluar::create([
                'tanggal' => date('Y-m-d H:i:s'),
                'id_transaksi' => $transaksi_id,
                'id_barang' => $item['id'],
                'qty' => $item['qty'],
                'grandtotal' => $item['subtotal'],
            ]);

            $barang = Barang::find($item['id']);
            $barang->stok = $barang->stok - $item['qty'];
            $barang->save();
        }

        return response()->json(['success' => true, 'message' => 'Transaksi berhasil',]);
    }

    public function exportAll()
    {
        return Excel::download(new TransaksiKeluarExport(0,0), 'Transaksi_keluar.xlsx');
    }

    public function export(Request $request){
        $start = $request->start;
        $end = $request->end;
        return Excel::download(new TransaksiKeluarExport($start,$end), 'Transaksi_keluar_'.$start.'_'.$end.'.xlsx');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaksi_Keluar  $transaksi_Keluar
     * @return \Illuminate\Http\Response
     */
    public function show(Transaksi_Keluar $transaksi_Keluar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaksi_Keluar  $transaksi_Keluar
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaksi_Keluar $transaksi_Keluar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaksi_Keluar  $transaksi_Keluar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaksi_Keluar $transaksi_Keluar)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaksi_Keluar  $transaksi_Keluar
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaksi_Keluar $transaksi_Keluar)
    {
        //
    }

    public function pdf(Request $request)
    {
        $start = $request->start;
        $end = $request->end;
        if($start != 0 && $end != 0) {
            $end = date('Y-m-d', strtotime($end . ' +1 day'));
            $tkeluar = Transaksi_Keluar::with('user')
                ->selectRaw('created_at,qty,grand_total,bayar,kembalian,id_users')
                ->whereBetween('created_at', [$start, $end])
                ->get();
        }else{
            $tkeluar = Transaksi_Keluar::with('user')
                ->selectRaw('created_at,qty,grand_total,bayar,kembalian,id_users')
                ->get();
        }

        foreach ($tkeluar as $key => $value) {
            $value->id_users = $value->user->username;
            unset($value->user);
        }
        
        $pdf = Pdf::loadview('detailkeluar.pdf',['tkeluar'=>$tkeluar]);
        return $pdf->stream();
    }
}
