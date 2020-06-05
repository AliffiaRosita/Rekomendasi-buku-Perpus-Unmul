@extends('template.master')
@section('content')

<div class="main-content-inner">
    <div class="row">
        <div class="col-lg-6 col-ml-12">
            <div class="row">
                <!-- Textual inputs start -->
                <div class="col-12 mt-5">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="header-title">Tambah Buku</h3>
                            <small class="text-muted mb-4"> Jika ada tanda <span class="text-danger">*</span> maka input
                                wajib diisi </small>
                            {!! Form::open(['url'=>route('buku.store'), 'enctype'=>'multipart/form-data']) !!}
                            @include('buku.form')
                            <div class="form-group">
                                <div class="row justify-content-center">
                                    <div class="col-2">
                                        <button class="btn btn-success">Simpan</button>
                                    </div>
                                </div>
                            </div>
                            {!! Form::close() !!}

                        </div>
                    </div>
                </div>
                <!-- Textual inputs end -->
            </div>
        </div>
    </div>
</div>


@endsection
