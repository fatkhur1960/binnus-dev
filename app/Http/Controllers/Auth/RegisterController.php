<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\ModelPaket;
use App\ModelPeserta;
use App\ModelOrder;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    // protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = new User;
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->save();

        $this->save_profile($data, $user);

        return $user;
    }

    private function save_profile($data, $user)
    {
        $peserta = ModelPeserta::create([
            'nik' => $data['nik'],
            'id_user' => $user->id,
            'nama_lengkap' => $data['name'],
            'jen_kel' => $data['jen_kel'],
            'ttl' => $data['ttl'],
            'no_induk'  => date('Y') . rand(5,10),
            'id_agama' => $data['id_agama'],
            'alamat_instansi' => $data['alamat_instansi'],
            'no_hp' => $data['no_hp'],
            'alamat_rumah' => $data['alamat_rumah'],
            'nama_ayah' => $data['nama_ayah'],
            'ttl_ayah' => $data['ttl_ayah'],
            'nama_ibu' => $data['nama_ibu'],
            'ttl_ibu' => $data['ttl_ibu'],
            'nama_wali' => $data['nama_wali'],
            'telp_wali' => $data['telp_wali'],
            'id_sumber' => $data['id_sumber'],
            'file_foto' => '',
            'file_kk' => ''
        ]);
    }

    protected function redirectTo()
    {
        Auth::user()->assignRole('user');
        return '/home?new-member';
    }
}
