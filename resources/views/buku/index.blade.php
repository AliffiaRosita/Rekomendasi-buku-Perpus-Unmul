@extends('template.master')
@section('content')
<div class="page-title-area">
        <div class="row align-items-center">
            <div class="col-sm-6 p-2">
                <div class="breadcrumbs-area clearfix">
                    <h4 class="page-title pull-left">Buku</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a href="index.html">Master</a></li>
                        <li><a href="index.html">Buku</a></li>

                        <li><span></span></li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
    <!-- page title area end -->
    <div class="main-content-inner">
<div class="col-12 mt-5">
    <div class="card">
        <div class="card-body">
            <h4 class="header-title d-inline">Data  Buku</h4> <a href="" class=" float-right mb-3 btn btn-sm btn-success"><i class="ti-plus"></i> Tambah Buku</a>
            <div class="data-tables datatable-primary">
                <table id="dataTable3" class="text-center table-hover">
                    <thead class="text-capitalize">
                        <tr>
                            <th width="10%">No</th>
                            <th width="30%">Judul</th>
                            <th>Penerbit</th>
                            <th>ISBN</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($books as $book)
                        <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$book->judul}}</td>
                        <td>{{$book->penerbit}}</td>
                        <td>{{$book->isbn}}</td>
                            <td>
                                {!! Form::open(['method'=>'delete', 'class'=>'d-inline', 'route'=>['buku.destroy',$book->id]]) !!}
                            <a href="{{route('buku.edit',['id'=>$book->id])}}" class="btn btn-sm btn-outline-success"><i class="ti-pencil"></i></a>
                            <a href="{{route('buku.show',['id'=>$book->id])}}" class="btn btn-sm btn-outline-info"><i class="ti-eye"></i></a>
                                    <button type="submit" class="btn btn-sm btn-outline-danger d-inline"> <i class="ti-close"></i></button>
                                {!! Form::close() !!}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
