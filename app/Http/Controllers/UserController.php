<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\puskesmas;
use App\Models\stok_obat;
use Carbon\Carbon;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\Models\User  $model
     * @return \Illuminate\View\View
     */
    public function index(User $model)
    {
        $expired = $this::expired();
        $tanggal = $expired['tanggal'];
        $count = $expired['count'];
        return view('users.index',compact('tanggal','count'));
    }
    public function expired(){
        $now = Carbon::now()->format('Y-m-d');
        $stok_obat = stok_obat::all();
        foreach($stok_obat as $stok){
            $exp = $stok->expired;
        }

        $tanggal = stok_obat::whereDate('expired','<=',$now)->where('sisa_stok','>',0)->get();
        $count = stok_obat::whereDate('expired','<=',$now)->where('sisa_stok','>',0)->count();
        // dd($now,$exp,$count);
        return compact('tanggal','count');
    }
    public function user(){
        $user = user::all();
        $expired = $this::expired();
        $tanggal = $expired['tanggal'];
        $count = $expired['count'];
        $puskesmas = puskesmas::all();
        return view('admin.puskesmas_user.index',compact('puskesmas','user','tanggal','count','expired'));
    }
    public function store(request $req){
        $req->validate([
            'id_puskesmas' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);
        $puskesmas = puskesmas::find($req->id_puskesmas);
        User::create([
            'name' => $puskesmas->nama_puskesmas,
            'email' => $req->email,
            'email_verified_at' => now(),
            'password' => Hash::make($req->password),
            'level' => 'user',
            'id_pus' => $puskesmas->id,
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now()
            ]);
        return redirect()->route('puskesmas-user.index');
    }

    public function update(request $req,$id){
        $req->validate([
            'id_puskesmas' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);
        $puskesmas = puskesmas::find($req->id_puskesmas);
        User::where('id', $id)->update([
            'name' => $puskesmas->nama_puskesmas,
            'email' => $req->email,
            'password' => Hash::make($req->password),
            'id_pus' => $puskesmas->id,
            'updated_at' => now()
            ]);
        return redirect()->route('puskesmas-user.index');
    }
    public function destroy($id){
        User::where('id', $id)->delete();
        return redirect()->route('puskesmas-user.index');
    }
}
