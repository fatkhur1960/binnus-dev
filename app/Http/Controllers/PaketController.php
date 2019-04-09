<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\ModelPaket;

class PaketController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $num = 1;
        $paket = ModelPaket::orderBy('id_paket', 'DESC')->paginate('20');
        return view('admin.paket', compact('paket', 'num'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_paket' => 'required',
            'pertemuan'      => 'required|numeric',
            'harga'      => 'required|numeric'
        ]);

        if (!$validator->fails()) {
            $data = [
                'nama_paket'   => $request->input('nama_paket'),
                'pertemuan'   => $request->input('pertemuan'),
                'harga'        => $request->input('harga')
            ];
            ModelPaket::create($data);

            return redirect('/home/paket-kursus')->with('success','Paket baru telah disimpan');
        } else {
            return redirect('/home/paket-kursus')
                ->withErrors($validator)
                ->withInput();
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $paket = ModelPaket::find($id);
        return view('admin.editpaket', compact('paket'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_paket' => 'required',
            'pertemuan'      => 'required|numeric',
            'harga'      => 'required|numeric'
        ]);

        if (!$validator->fails()) {
            $paket = ModelPaket::find($id);
            $paket->nama_paket = $request->input('nama_paket');
            $paket->pertemuan = $request->input('pertemuan');
            $paket->harga = $request->input('harga');
            $paket->save();

            return redirect('/home/paket-kursus')->with('success','Paket telah diperbarui');
        } else {
            return redirect('/home/paket-kursus/' . $id . '/edit')
                ->withErrors($validator)
                ->withInput();
        }
    }

    public function destroy($id)
    {
        $data = ModelPaket::find($id);
        $data->delete();

        return redirect('/home/paket-kursus')->with('success','Paket telah dihapus');
    }
}
