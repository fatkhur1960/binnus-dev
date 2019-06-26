<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\ModelPaket;
use App\ModelKelas;
use App\ModelPeserta;
use App\ModelAgama;
use App\ModelSumber;
use App\ModelJadwal;

class PesertaController extends Controller
{
    protected $confirm;

    function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if(Auth::user()->hasRole('user')) {
                $this->peserta = ModelPeserta::where('id_user', Auth::user()->id)->first();
                $this->confirm = ModelOrder::where('status', 'Processing')->get()->count();
            }
    
            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paket = ModelPaket::all();
        $confirm = $this->confirm;
        return view('admin.peserta', compact('paket','confirm'));
    }

    public function getPeserta(Request $request)
    {
        $data = new ModelKelas();
        $peserta = $data->getPeserta($request->input('id_paket'),$request->input('id_jadwal'));
        return response()->json(['data' => $peserta], 200);
    }

    public function pesertaByClass(Request $request, $id_paket, $id_jadwal)
    {
        $data = new ModelKelas();
        $paket = ModelPaket::find($id_paket);
        $jadwal = ModelJadwal::find($id_jadwal);
        $peserta = $data->getPeserta($id_paket, $id_jadwal);
        return response()->json([
            'paket' => $paket->nama_paket,
            'kelas' => $jadwal->hari . ' ' . $jadwal->waktu,
            'periode' => $jadwal->periode,
            'data' => $peserta
        ], 200);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $agama = ModelAgama::all();
        $sumber = ModelSumber::all();
        $peserta = ModelPeserta::find($id);
        return view('admin.detailpeserta', compact('peserta','agama','sumber'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
