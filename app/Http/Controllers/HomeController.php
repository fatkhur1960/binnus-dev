<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\ModelAgama;
use App\ModelPaket;
use App\ModelSumber;
use App\ModelPeserta;
use App\ModelKelas;
use App\ModelOrder;
use App\ModelJadwal;

use Validator;

class HomeController extends Controller
{
    protected $peserta;
    protected $order_count;
    protected $confirm;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if(Auth::user()->hasRole('user')) {
                $this->peserta = ModelPeserta::where('id_user', Auth::user()->id)->first();
                $this->order_count = ModelOrder::where('id_peserta', $this->peserta->id_peserta)->where('status', 'Pending')->get()->count();
                $this->confirm = ModelOrder::where('status', 'Processing')->get()->count();
            }
    
            return $next($request);
        });
    }

    public function index()
    {
        $agama = ModelAgama::all();
        $paket = ModelPaket::all();
        $sumber = ModelSumber::all();
        $count = $this->order_count;
        $confirm = $this->confirm;
        
        return view('home.dashboard', compact('agama','paket','sumber','count','confirm'));
    }

    public function profile()
    {
        $agama = ModelAgama::all();
        $sumber = ModelSumber::all();
        $peserta = ModelPeserta::where('id_user', Auth::user()->id)->first();
        $count = $this->order_count;

        return view('home.profile', compact('agama','sumber','count','peserta'));
    }

    public function update_profile(Request $request)
    {
        $foto = $request->file('file_foto');
        $kk = $request->file('file_kk');

        if($foto->getSize() > 512000 || $kk->getSize() > 768000) {
            return redirect()->back()->withErrors(['foto' => 'Ukuran foto terlalu besar', 'kk' => 'Ukuran file KK terlalu besar'])->withInput();
        } elseif($foto->getSize() > 512000) {
            return redirect()->back()->withErrors(['msg' => 'Ukuran foto terlalu besar'])->withInput();
        } elseif($kk->getSize() > 768000) {
            return redirect()->back()->withErrors(['msg' => 'Ukuran file KK terlalu besar'])->withInput();
        } else {
            $destinationPath = 'uploads/';
            $validator = Validator::make($request->all(), [
                'nik' => 'required|numeric',
                'nama_lengkap' => 'required',
                'jen_kel' => 'required',
                'ttl' => 'required',
                'id_agama' => 'required',
                'alamat_instansi' => 'required',
                'no_hp' => 'required',
                'alamat_rumah' => 'required',
                'nama_ayah' => 'required',
                'ttl_ayah' => 'required',
                'nama_ibu' => 'required',
                'ttl_ibu' => 'required',
                'nama_wali' => 'required',
                'telp_wali' => 'required',
                'id_sumber' => 'required',
                'file_foto' => 'required',
                'file_kk' => 'required'
            ]);

            if($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $file_foto = 'foto_' . $request->input('no_induk') . '.' . $foto->getClientOriginalExtension();
                $file_kk =  'kk_' . $request->input('no_induk') . '.' . $foto->getClientOriginalExtension();

                $foto->move($destinationPath . 'foto', $file_foto);
                $kk->move($destinationPath . 'kk', $file_kk);

                $peserta = ModelPeserta::find($request->input('id_peserta'));
                $peserta->nik = $request->input('nik');
                $peserta->nama_lengkap = $request->input('nama_lengkap');
                $peserta->jen_kel = $request->input('jen_kel');
                $peserta->ttl = $request->input('ttl');
                $peserta->id_agama = $request->input('id_agama');
                $peserta->alamat_instansi = $request->input('alamat_instansi');
                $peserta->no_hp = $request->input('no_hp');
                $peserta->alamat_rumah = $request->input('alamat_rumah');
                $peserta->nama_ayah = $request->input('nama_ayah');
                $peserta->ttl_ayah = $request->input('ttl_ayah');
                $peserta->nama_ibu = $request->input('nama_ibu');
                $peserta->ttl_ibu = $request->input('ttl_ibu');
                $peserta->nama_wali = $request->input('nama_wali');
                $peserta->telp_wali = $request->input('telp_wali');
                $peserta->id_sumber = $request->input('id_sumber');
                $peserta->file_foto = 'uploads/foto/' . $file_foto;
                $peserta->file_kk = 'uploads/kk/' . $file_kk;
                $peserta->save();
                
                return redirect()->back()->with('success','Profile berhasil disimpan.');
            }

        }
    }

    public function pembayaran(Request $req)
    {
        $count = $this->order_count;
        $num = 1;
        $status = $req->input('status') != "" ? $req->input('status') : false;
        if($status) {
            $history = ModelOrder::where('id_peserta', $this->peserta->id_peserta)
                ->where('status', $status)
                ->orderBy('created_at','DESC')
                ->paginate(20);
        } else {
            $history = ModelOrder::where('id_peserta', $this->peserta->id_peserta)
                ->orderBy('created_at','DESC')
                ->paginate(20);
        }
        
        return view('home.confirm', compact('num', 'count','history','status'));
    }

    public function cancel($id)
    {
        $order = ModelOrder::find($id);
        $order->status = 'Canceled';
        $order->updated_at = date('Y-m-d H:i:s');
        $order->save();

        return redirect('/home/pembayaran?status=' . $order->status)->with('success','Pembayaran berhasil dibatalkan');
    }

    public function confirm(Request $request)
    {
        $destinationPath = 'uploads/';
        $file = $request->file('confirm_file');
        $filename = 'confirm_' . $request->input('nik') . '_' . date('y-m-d') . '.' . $file->getClientOriginalExtension();
        $file->move($destinationPath . 'confirm', $filename);

        $order = ModelOrder::find($request->input('id'));
        $order->status = 'Processing';
        $order->updated_at = date('Y-m-d H:i:s');
        $order->confirm_file = $filename;
        $order->save();

        $peserta = ModelPeserta::where('id_user', Auth::user()->id)->first();
        $paket = ModelPaket::find($order->id_paket)->first();

        $to_email = env('TO_EMAIL', 'ivanziza3@gmail.com');
        $data = array(
            "nama" => $peserta->nama_lengkap, 
            "kelas" => $paket->nama_paket,
            "email" => Auth::user()->email,
            "tgl" => $order->updated_at,
            "jumlah" => "Rp. " . number_format($order->total_harga),
            "bukti" => url('uploads/confirm/' . $filename),
            "url" => url('home/histori-pembayaran?check=' . $order->id)
        );
    
        Mail::send('email.mail', $data, function($message) use ($to_email) {
            $message->to($to_email)
                    ->subject('Konfirmasi Pembayaran');
            $message->from('fanonym1960@gmail.com','Binnus Wonosobo Web');
        });

        return redirect('/home/pembayaran?status=' . $order->status)->with('success','Terima kasih. Permintaan Anda akan segera kami proses.');
    }

    public function paketKursus()
    {
        $completed = true;
        $paket = ModelPaket::all();
        $count = $this->order_count;
        $user = ModelPeserta::where('id_user', Auth::user()->id)->first();
        $ins_kelas = new ModelPaket();
        $kelas = $ins_kelas->list($user->id_peserta)->get();
        
        return view('home.paketkursus', compact('paket', 'kelas','user','count'));
    }

    public function ambilPaket(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'id_paket' => 'required|numeric',
            'id_peserta' => 'required|numeric',
        ]);

        if($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        } else {
            $data_kelas = [
                'id_paket'   => $req->input('id_paket'),
                'id_peserta' => $req->input('id_peserta'),
            ];

            $check_kelas = ModelKelas::where($data_kelas)->count();
            if($check_kelas > 0) {
                return redirect('/home/pilih-paket-kursus')->with('error','Anda sudah mengambil paket ini');
            }

            $data_order = [
                'id_paket'      => $req->input('id_paket'),
                'id_peserta'    => $req->input('id_peserta'),
                'total_harga'   => $req->input('harga')
            ];

            ModelKelas::create($data_kelas);
            ModelOrder::create($data_order);
            return redirect('/home/pilih-paket-kursus')->with('success','Terima kasih. Silahkan selesaikan pembayaran Anda untuk mengambil jadwal');
        }
    }

    public function getPaket(Request $req) 
    {
        $paket = ModelPaket::where('id_paket', $req->input('id_paket'))->first();
        return response()->json(['paket' => $paket], 200);
    }

    public function ambilJadwal(Request $req)
    {
        $kelas = ModelKelas::find($req->input('id_kelas'));
        $kelas->id_jadwal = $req->input('id_jadwal');
        $kelas->save();

        return response()->json(['message' => 'Jadwal berhasil disimpan'], 200);
    }

    public function getJadwal(Request $req)
    {
        $periode = date('m/Y');
        $jadwal = new ModelJadwal();
        return response()->json([
            'periode' => $periode,
            'jadwal' => $jadwal->getJadwal($req->input('id_paket'),$req->input('id_jadwal'))
        ], 200);
    }

}