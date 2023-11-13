<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Http\Requests\PasswordRequest;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\stok_obat;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the profile.
     *
     * @return \Illuminate\View\View
     */

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
    public function edit()
    {
        $expired = $this::expired();
        $tanggal = $expired['tanggal'];
        $count = $expired['count'];
        return view('profile.edit',compact('tanggal','count'));
    }

    /**
     * Update the profile
     *
     * @param  \App\Http\Requests\ProfileRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileRequest $request)
    {
        // if (auth()->user()->id == 1) {
        //     return back()->withErrors(['not_allow_profile' => __('You are not allowed to change data for a default user.')]);
        // }

        auth()->user()->update($request->all());

        return back()->withStatus(__('Profile successfully updated.'));
    }

    /**
     * Change the password
     *
     * @param  \App\Http\Requests\PasswordRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function password(PasswordRequest $request)
    {
        // if (auth()->user()->id == 1) {
        //     return back()->withErrors(['not_allow_password' => __('You are not allowed to change the password for a default user.')]);
        // }

        auth()->user()->update(['password' => Hash::make($request->get('password'))]);

        return back()->withPasswordStatus(__('Password successfully updated.'));
    }
}
