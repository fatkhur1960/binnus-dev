<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\ModelJadwal;
use App\ModelPaket;

class JadwalController extends Controller
{
    public function index()
    {
        $num = 1;
        $hari = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
        $jadwal = ModelJadwal::orderBy('id_jadwal', 'DESC')->paginate('20');
        $paket = ModelPaket::all();
        return view('admin.jadwal', compact('jadwal', 'hari', 'paket', 'num'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $val = Validator::make($request->all(), [
            'id_paket'  => 'required|numeric',
            'hari_1'     => 'required',
            'hari_2'     => 'required',
            'kuota'     => 'required|numeric',
            'mulai'     => 'required',
            'selesai'   => 'required'
        ]);

        if(!$val->fails()) {
            $data = [
                'id_paket'   => $request->input('id_paket'),
                'hari'      => $request->input('hari_1') . '-' . $request->input('hari_2'),
                'kuota'      => $request->input('kuota'),
                'waktu'      => $request->input('mulai') . '-' . $request->input('selesai'),
            ];
            ModelJadwal::create($data);

            return redirect('/home/jadwal-kursus')->with('success','Jadwal baru telah disimpan');
        } else {
            return redirect('/home/jadwal-kursus')
                ->withErrors($val)
                ->withInput();
        }
    }

    public function show($id)
    {
        //
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
            'hari_1'     => 'required',
            'hari_2'     => 'required',
            'kuota'     => 'required|numeric',
            'mulai'     => 'required',
            'selesai'   => 'required'
        ]);

        if(!$val->fails()) {
            $jadwal->hari    = $request->input('hari_1') . '-' . $request->input('hari_2');
            $jadwal->kuota    = $request->input('kuota');
            $jadwal->waktu    = $request->input('mulai') . '-' . $request->input('selesai');
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
        $data->delete();

        return redirect('/home/jadwal-kursus')->with('success','Jadwal telah dihapus');
    }
}
