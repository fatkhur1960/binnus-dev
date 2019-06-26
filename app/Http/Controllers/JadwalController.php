<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\ModelJadwal;
use App\ModelPaket;

class JadwalController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $req)
    {
        $num = 1;
        $perPage = 20;
        $hari = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
        $jadwal = $req->input('id_paket') ? ModelJadwal::where('id_paket',$req->input('id_paket'))->orderBy('id_jadwal', 'DESC')->paginate($perPage) :
            ModelJadwal::orderBy('id_jadwal', 'DESC')->paginate($perPage);
        $paket = ModelPaket::all();
        return view('admin.jadwal', compact('jadwal', 'hari', 'paket', 'num', 'req'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $val = Validator::make($request->all(), [
            'id_paket'  => 'required|numeric',
            'periode'   => 'required',
            'hari_1'    => 'required',
            'hari_2'    => 'required',
            'kuota'     => 'required|numeric',
            'mulai'     => 'required',
            'selesai'   => 'required'
        ], [
            'required' => 'Field :attribute tidak boleh kosong!',
        ]);

        if(!$val->fails()) {
            $data = [
                'id_paket'  => $request->input('id_paket'),
                'periode'   => $request->input('periode'),
                'hari'      => $request->input('hari_1') . '-' . $request->input('hari_2'),
                'kuota'     => $request->input('kuota'),
                'waktu'     => $request->input('mulai') . '-' . $request->input('selesai'),
            ];
            ModelJadwal::create($data);

            return redirect('/home/jadwal-kursus')->with('success','Jadwal baru telah disimpan');
        } else {
            return redirect('/home/jadwal-kursus')
                ->withErrors($val)
                ->with('error', $val->errors()->first())
                ->withInput();
        }
    }

    public function show($id)
    {
        $jadwal = ModelJadwal::find($id);
        return response()->json($jadwal, 200);
    }

    public function edit($id)
    {
        $hari = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
        $jadwal = ModelJadwal::find($id);
        $paket = ModelPaket::all();
        $day = explode('-', $jadwal->hari);
        $time = explode('-', $jadwal->waktu);
        return view('admin.editjadwal', compact('jadwal', 'hari', 'paket', 'time', 'day'));
    }

    public function update(Request $request, $id)
    {
        $jadwal = ModelJadwal::find($id);
        $val = Validator::make($request->all(), [
            'hari_1'    => 'required',
            'hari_2'    => 'required',
            'kuota'     => 'required|numeric',
            'mulai'     => 'required',
            'selesai'   => 'required'
        ],[
            'required' => 'Field :attribute tidak boleh kosong!',
        ]);

        if(!$val->fails()) {
            $jadwal->hari    = $request->input('hari_1') . '-' . $request->input('hari_2');
            $jadwal->kuota   = $request->input('kuota');
            $jadwal->waktu   = $request->input('mulai') . '-' . $request->input('selesai');
            $jadwal->save();

            return redirect('/home/jadwal-kursus')->with('success','Jadwal telah diperbarui');
        } else {
            return redirect('/home/jadwal-kursus/' . $id . '/edit')
                ->withErrors($val)
                ->withInput();
        }
    }

    public function destroy($id)
    {
        $data = ModelJadwal::find($id);
        if($data->delete()) {
            $msg = ['message' => 'Jadwal telah dihapus'];
            return response()->json($msg, 200);
        } else {
            $msg = ['message' => 'Gagal menghapus jadwal'];
            return response()->json($msg, 500);
        }

        // return redirect('/home/jadwal-kursus')->with('success','Jadwal telah dihapus');
    }
}
