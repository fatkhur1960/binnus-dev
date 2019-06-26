<?php

namespace App\Http\Controllers;

use RealRashid\SweetAlert\Facades\Alert;

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
        $messages = [
            'required' => 'Field :attribute tidak boleh kosong!',
        ];
        $validator = Validator::make($request->all(), [
            'nama_paket' => 'required',
            'pertemuan'  => 'required|numeric',
            'harga'      => 'required|numeric'
        ], $messages);

        if (!$validator->fails()) {
            $data = [
                'nama_paket'   => $request->input('nama_paket'),
                'pertemuan'   => $request->input('pertemuan'),
                'harga'        => $request->input('harga')
            ];
            ModelPaket::create($data);

            return redirect('/home/paket-kursus')->with('success','Paket baru telah disimpan');
        } else {
            // alert()->error('ErrorAlert','Lorem ipsum dolor sit amet.');
            return redirect('/home/paket-kursus')
                ->with('error', 'Gagal menyimpan data!')
                // ->with('error', $validator);
                ->withErrors($validator);
                // ->withInput();
        }
    }

    public function show($id)
    {
        $paket = ModelPaket::find($id);
        return response()->json($paket, 200);
    }

    public function edit($id)
    {
        $paket = ModelPaket::find($id);
        return response()->json($paket, 200);
    }

    public function update(Request $request, $id)
    {
        $messages = [
            'required' => 'Field :attribute tidak boleh kosong!',
        ];
        $validator = Validator::make($request->all(), [
            'nama_paket' => 'required',
            'pertemuan'      => 'required|numeric',
            'harga'      => 'required|numeric'
        ], $messages);

        if (!$validator->fails()) {
            $paket = ModelPaket::find($id);
            $paket->nama_paket = $request->input('nama_paket');
            $paket->pertemuan = $request->input('pertemuan');
            $paket->harga = $request->input('harga');
            $paket->save();

            return redirect('/home/paket-kursus')->with('success','Paket telah diperbarui');
        } else {
            return redirect('/home/paket-kursus/' . $id . '/edit')
                ->with('error', $validator->errors()->first())
                // ->withErrors($validator)
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
