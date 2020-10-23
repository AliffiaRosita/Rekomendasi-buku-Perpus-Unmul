<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Visitor;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\VisitorRequest;
class VisitorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index(Request $request)
    {
        $query = $request->all();
        $visitors =[];
        if (count($query)==0) {
            $visitors = Visitor::orderBy('nama_pengunjung','asc')->paginate(50);
        }else{
            if (isset($query['fakultas'])) {
                $visitors = Visitor::where($query['category'],'LIKE','%'.$query['keyword'].'%')->where('fakultas','LIKE','%'.$query['fakultas'].'%')->orderBy('nim','ASC')->paginate(30);
            }else{
                 $visitors = Visitor::where($query['category'],'LIKE','%'.$query['keyword'].'%')->orderBy('nim','ASC')->paginate(30);
            }

        }
        return view('pengunjung.index', [
            'visitors'=> $visitors->appends(Input::except('page')),
            'query'=> $query
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pengunjung.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VisitorRequest $request)
    {
        $pengunjung = $request->all();
        $pass = Hash::make($pengunjung['password']);
        if(isset($pengunjung['foto_profil']) == null){
            $saveFoto = null;
        }else{
            $saveFoto= $this->savePict($pengunjung['foto_profil']);
        }

        User::create([
            'email'=>$pengunjung['email'],
            'password'=>$pass,
            'role'=>'mahasiswa'
        ]);
        $getUserId = User::orderBy('id','DESC')->first();
        Visitor::create([
            'nama_pengunjung'=>$pengunjung['nama_pengunjung'],
            'nim'=>$pengunjung['nim'],
            'fakultas'=>$pengunjung['fakultas'],
            'angkatan'=>$pengunjung['angkatan'],
            'foto_profil'=>$saveFoto,
            'user_id'=>$getUserId->id
        ]);
        return redirect('pengunjung');


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $visitor = Visitor::findOrFail($id);

        return view('pengunjung.edit',compact('visitor'));
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

        $visitor = $request->all();
        $updateVisitor = Visitor::findOrFail($id);
        $request->validate([
            'nama_pengunjung' =>'required',
            'nim'=> 'sometimes|required| numeric|unique:pengunjung,nim,'.$id,
            'fakultas'=>'required',
            'angkatan' => 'required | numeric',
        ]);
        if(!empty($visitor['foto_profil'])){
            $request->validate([
                'foto_profil' =>'mimes:JPG,JPEG,PNG,jpg,jpeg,png|max:3000',
            ]);
             $this->deleteImage($updateVisitor['foto_profil']);
             $saveFoto = $this->savePict($visitor['foto_profil']);

        }else{
            $saveFoto = $updateVisitor->foto_profil;
        }
        if (isset($visitor['email']) == null ) {
            if (isset($visitor['password']) !=null) {
                $request->validate([
                    'password' => 'min:8',
                ]);
                $pass = Hash::make($visitor['password']);
                $getUserId = User::findOrFail($updateVisitor->user_id);
                $getUserId->update([
                    'password'=>$pass
                ]);
            }
            $updateVisitor->update([
                'nama_pengunjung'=> $visitor['nama_pengunjung'],
                'nim'=> $visitor['nim'],
                'fakultas'=>$visitor['fakultas'],
                'angkatan'=>$visitor['angkatan'],
                'foto_profil'=> $saveFoto
            ]);

        } else {
            $request->validate([
                'email'=>'sometimes|email|required| unique:users',
                'password'=>'required| min:8',
            ]);
            $pass = Hash::make($visitor['password']);
            User::create([
                'email'=>$visitor['email'],
                'password'=>$pass,
                'role'=>'mahasiswa'
            ]);
            $getUserId = User::orderBy('id','DESC')->first();
            Visitor::create([
                'nama_pengunjung'=>$visitor['nama_pengunjung'],
                'nim'=>$visitor['nim'],
                'fakultas'=>$visitor['fakultas'],
                'angkatan'=>$visitor['angkatan'],
                'foto_profil'=>$saveFoto,
                'user_id'=>$getUserId->id
            ]);
        }


        // $updateUser= User::findOrFail($updateVisitor->user_id);
        // if ($visitor['password']) {
        //     $updateUser->save([
        //         'password'=> $visitor['password'],
        //         'email'=> $visitor['email']
        //     ]);
        // }else{
        //     $updateUser->save([
        //         'email'=> $visitor['email']
        //     ]);
        // }

        return redirect('pengunjung');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $visitor = Visitor::findOrFail($id);
            $this->deleteImage($visitor->foto_profil);
            $response= [
                'message' => $visitor->nama_pengunjung." berhasil dihapus",
            ];
            User::where('id',$visitor->user_id)->delete();
            $visitor->delete();
        }catch(ExceptionHandler $e){
            $response=[
                'message'=> $e
            ];
        }
        return response()->json($response);
    }

    public function showProfile($id)
    {
        $visitor = Visitor::findOrFail($id);
        return view('profile.show',compact('visitor'));
    }


    public function savePict($pengunjung)
    {
        if(!empty($pengunjung))
        {
            $new_name = rand().'.'.$pengunjung->getClientOriginalExtension();
            $pengunjung->move('image/pengunjung',$new_name);

            // $path_foto = storage_path().'/app/public/image/pengunjung/'.$new_name;
            // Image::make($pengunjung)->save($path_foto);

            $name = $new_name;
        } else {
            $name = null;
        }
    return $name;
    }

    public function deleteImage($filename) {
        // $path = storage_path('app/public/image/pengunjung/');
        // dd($path.$filename);
        return File::delete('image/pengunjung/'.$filename);
    }
}
