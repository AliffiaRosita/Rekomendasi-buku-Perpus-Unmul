<?php

namespace App\Http\Controllers;

use App\Visitor;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
class ApiVisitorController extends Controller
{
    public function login(Request $request)
    {
        $visitor = Visitor::where('nim',$request->nim)->first();
        if (isset($visitor->user_id) == null || isset($visitor) == null) {
            return response()->json([
                'message'=>'User tidak ditemukan'
            ],404);
        }else{
            $check=Auth::attempt(['id' => $visitor->user_id, 'password' => $request->password]);
            if($check){

               $success = auth()->user()->createToken('App')->accessToken;
                $pict_url = url('image/pengunjung/'.$visitor->foto_profil);

               $data=[
                   'user_id' => $visitor->user_id,
                   'nama '=> $visitor->nama_pengunjung,
                   'token'=>  $success,
                   'nim' => $visitor->nim,
                   'fakultas'=> $visitor->fakultas,
                   'angkatan'=> $visitor->angkatan,
                   'foto_profil'=> $pict_url
               ];
               return response()->json([
                   'data'=> $data,
                   'message'=> 'berhasil login',
               ],200);
           }else{
            return response()->json([
                'message'=> 'nim atau password salah',
            ],404);
           }
        }
    }

    public function register(Request $request)
    {
        try {
            DB::beginTransaction();
            $pengunjung = $request->all();
            // dd($pengunjung);
            $pass = Hash::make($pengunjung['password']);
            User::create([
                'email'=>null,
                'password'=>$pass,
                'role'=>'mahasiswa'
            ]);
            $getUserId = User::orderBy('id','DESC')->first();
            Visitor::create([
                'nama_pengunjung'=>$pengunjung['nama_pengunjung'],
                'nim'=>$pengunjung['nim'],
                'fakultas'=>$pengunjung['fakultas'],
                'angkatan'=>$pengunjung['angkatan'],
                'foto_profil'=>null,
                'user_id'=>$getUserId->id
            ]);
            DB::commit();
            return response()->json([
                'message'=>'berhasil membuat user',
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function updateProfile(Request $request)
    {
        try{
            DB::beginTransaction();
            $visitor = $request->all();
            $getVisitor = Visitor::findOrFail(Auth::user()->visitor->id);

            $getVisitor->update([
                'nama_pengunjung'=>$visitor['nama_pengunjung'],
                'nim'=>$visitor['nim'],
                'fakultas'=>$visitor['fakultas'],
                'angkatan'=>$visitor['angkatan'],
                'foto_profil'=>null,
                'user_id'=>Auth::user()->id,
            ]);
            DB::commit();

            return response()->json([
                'message'=> 'berhasil update profil'
            ]);
        }catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function updatePassword(Request $request)
    {
        try{
            DB::beginTransaction();
            $user = Auth::user()->password;

            if (Hash::check($request->old_password, $user )) {
                $pass = Hash::make($request->new_password);
                 $findUser = User::where('id',Auth::user()->id);
                $findUser->update([
                    'password'=> $pass
                ]);
                DB::commit();
                return response()->json([
                    'message'=> 'berhasil ubah password'
                ],200);
            }else{
                DB::commit();
                return response()->json([
                    'message'=>'password lama salah'
                ]);
            }

        }catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
