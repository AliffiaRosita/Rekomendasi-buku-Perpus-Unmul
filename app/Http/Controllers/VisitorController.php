<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Visitor;
class VisitorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $visitors = Visitor::orderBy('nama_pengunjung','asc')->paginate(50);
        return view('pengunjung.index', compact('visitors'));
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
    public function store(Request $request)
    {
        dd($request->all());

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
        //
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
    public function savePict($pengunjung)
    {
        if(!empty($pengunjung))
        {
            $new_name = rand().'.'.$pengunjung->getClientOriginalExtension();
            $path_foto = storage_path().'/app/public/image/pengunjung/'.$new_name;
            Image::make($pengunjung)->save($path_foto);

            $name = $new_name;
        } else {
            $name = null;
        }
    return $name;
    }

    public function deleteImage($filename) {
        $path = storage_path('app/public/image/pengunjung/');
        // dd($path.$filename);
        return File::delete($path.$filename);
    }
}
