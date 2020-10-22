@extends('template.master')
@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7 col-md-6 mt-5">
        <div class="card card-bordered">
            {{-- <img class="card-img-top img-fluid" src="assets/images/card/card-img2.jpg" alt="image"> --}}
            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                    <img src="{{$visitor->foto_profil?asset('image/pengunjung/'.$visitor->foto_profil):"https://cdn.jpegmini.com/user/images/slider_puffin_before_mobile.jpg"}}" class="rounded" height="200px" alt="foto profile">
                    </div>
                    <div class="col-8">
                        <h5>{{$visitor->nama_pengunjung}}</h5>
                        {{$visitor->user->email}}
                        <div class="card bg-light mt-3 mb-3">
                          <div class="card-body">
                              <div class="row">
                                <div class="col-6">
                                    <strong>Nim</strong>  <br>{{$visitor->nim}}
                                </div>
                                <div class="col-6">
                                        <strong>Fakultas</strong>  <br>{{$visitor->fakultas}}
                                    </div>
                              </div>

                          </div>
                        </div>


                    <a href="{{route('pengunjung.edit',['id'=>$visitor->id])}}" class="btn btn-success">Edit Profile</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
