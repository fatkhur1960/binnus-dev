<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ModelOrder;
use App\ModelPeserta;

class OrderController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $status = $req->input('status') != "" ? $req->input('status') : false;
        $no_induk = $req->input('no_induk') != "" ? $req->input('no_induk') : false;
        if($no_induk && $status) {
            $order = new ModelOrder();
            $history = $order->getFiltered($no_induk, $status);
        } elseif($status) {
            $history = ModelOrder::where('status', $status)
                ->orderBy('created_at','DESC')
                ->paginate(20);
        } elseif($no_induk) {
            $order = new ModelOrder();
            $history = $order->getFiltered($no_induk);
        } else {
            $history = ModelOrder::orderBy('created_at','DESC')
                ->paginate(20);
        }

        return view('admin.pembayaran', compact('history'));
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
        $history = ModelOrder::where('id', $id)->first();
        return response()->json($history, 200);
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
        $order = ModelOrder::find($id);
        $order->status = 'Confirmed';
        $order->save();

        return response()->json(['message' => 'Pembayaran berhasil dikonfirmasi'], 200);
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
