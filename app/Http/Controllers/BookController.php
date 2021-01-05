<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Intervention\Image\Facades\Image;
use NunoMaduro\Collision\Adapters\Laravel\ExceptionHandler;
use App\Http\Requests\BookRequest;
use Alert;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $query = $request->all();
    //    dd($query);
        if (count($query)==0) {
            $books = Book::orderBy("id","asc")->paginate(50);

        }else{
            $books = Book::where($query['category'],'LIKE','%'.$query['keyword']."%")->paginate(30);

        }
            return view('buku.index',[
                'books'=> $books->appends(Input::except('page')),
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
        return view('buku.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookRequest $request)
    {
        $buku = $request->all();
        if(!empty($buku['foto'])){
           $saveFoto= $this->savePict($buku['foto']);
        }else{
            $saveFoto = null;
        }

        Book::create([
            'judul'=> $buku['judul'],
            'isbn'=>$buku['isbn'],
            'penerbit'=>$buku['penerbit'],
            'tempat_terbit'=> $buku['tempat_terbit'],
            'foto'=> $saveFoto
        ]);
        Alert::success('Sukses tambah buku','');

        return redirect('buku');
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
        $book = Book::findOrFail($id);

        return view('buku.edit',compact('book'));
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
        $buku = $request->all();
        $updateBook = Book::findOrFail($id);
        if(!empty($buku['foto'])){
             $this->deleteImage($updateBook['foto']);
             $saveFoto = $this->savePict($buku['foto']);
        }else{
            $saveFoto = $updateBook->foto;
        }

        $updateBook->update([
            'judul'=> $buku['judul'],
            'isbn'=>$buku['isbn'],
            'tempat_terbit'=> $buku['tempat_terbit'],
            'penerbit'=>$buku['penerbit'],
            'foto'=> $saveFoto
        ]);

        Alert::success('Sukses ubah buku','');
        return redirect('buku');
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
            $buku = Book::findOrFail($id);
            $this->deleteImage($buku->foto);
            $response= [
                'message' => $buku->judul." berhasil dihapus",
            ];
            $buku->delete();
        }catch(ExceptionHandler $e){
            $response=[
                'message'=> $e
            ];
        }
        return response()->json($response);
    }

    public function savePict($buku)
    {
        if(!empty($buku))
        {
            $new_name = rand().'.'.$buku->getClientOriginalExtension();
           $buku->move('image/buku',$new_name);
            // $path_foto = storage_path().'/app/public/image/buku/'.$new_name;
            // Image::make($buku)->save($path_foto);

            $name = $new_name;
        } else {
            $name = null;
        }
    return $name;
    }

    public function deleteImage($filename) {
        // $path = storage_path('app/public/image/buku/');
        // dd($path.$filename);
        return File::delete('image/buku/'.$filename);
    }


}
