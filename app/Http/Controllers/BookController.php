<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::all();
        return view('buku.index',compact('books'));
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
    public function store(Request $request)
    {
        $buku = $request->all();
        if($buku !== null){
           $saveFoto= $this->savePict($buku['foto']);
        }

        Book::create([
            'judul'=> $buku['judul'],
            'deskripsi'=> $buku['deskripsi'],
            'isbn'=>$buku['isbn'],
            'penerbit'=>$buku['penerbit'],
            'foto'=> $saveFoto
        ]);
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
            $saveFoto = $buku['foto']; //belum selesai bagian ini
        }

        $updateBook->update([
            'judul'=> $buku['judul'],
            'deskripsi'=> $buku['deskripsi'],
            'isbn'=>$buku['isbn'],
            'penerbit'=>$buku['penerbit'],
            'foto'=> $saveFoto
        ]);
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
        //
    }

    public function savePict($buku)
    {
        if(!empty($buku))
        {
            $new_name = rand().'.'.$buku->getClientOriginalExtension();
            $path_foto = storage_path().'/app/public/image/buku/'.$new_name;
            Image::make($buku)->save($path_foto);

            $name = $new_name;
        } else {
            $name = null;
        }
    return $name;
    }

    public function deleteImage($filename) {
        $path = storage_path('app/public/image/buku/');
        // dd($path.$filename);
        return File::delete($path.$filename);
    }
}
