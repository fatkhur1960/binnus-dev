<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\ModelPeserta;
use App\ModelOrder;
use Auth;

class AkunController extends Controller
{
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
        $count = $this->order_count;
        $confirm = $this->confirm;

        return view('auth.changepassword', compact('count','confirm'));
    }

    public function changePassword(Request $request)
    {
        if (!(Hash::check($request->input('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error", "Your current password does not matches with the password you provided. Please try again.");
        }

        if (strcmp($request->input('current-password'), $request->input('new-password')) == 0) {
            //Current password and new password are same
            return redirect()->back()->with("error", "New Password cannot be same as your current password. Please choose a different password.");
        }
        if (!(strcmp($request->input('new-password'), $request->input('new-password_confirmation'))) == 0) {
            //New password and confirm password are not same
            return redirect()->back()->with("error", "New Password should be same as your confirmed password. Please retype new password.");
        }
        
        $user = Auth::user();
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('new-password'));
        $user->save();

        return redirect()->back()->with("success", "Password changed successfully !");
    }
}
