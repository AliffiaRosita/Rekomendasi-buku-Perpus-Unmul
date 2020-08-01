@extends('template.master')
@section('content')
<div class="page-title-area">
        <div class="row align-items-center">
            <div class="col-sm-6 p-2">
                <div class="breadcrumbs-area clearfix">
                    <h4 class="page-title pull-left">Pengunjung</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a href="index.html">Master</a></li>
                        <li><a href="index.html">Pengunjung</a></li>

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
        <h4 class="header-title d-inline">Data  Pengunjung</h4>
<div class="col-5">
<a href="{{route('pengunjung.create')}}" class=" float-right mb-3 btn btn-sm btn-success"><i class="ti-plus"></i> Tambah Buku</a>
</div>

        <div class="single-table">

                <div class="table-responsive">
                    <table class="table table-hover text-center">
                        <thead class="text-uppercase bg-primary">
                            <tr class="text-white">
                                    <th width="5%">No</th>
                                    <th width="30%">Nama Lengkap</th>
                                    <th>nim</th>
                                    <th>Fakultas</th>
                                    <th width="20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($visitors)==0)
                            <tr>
                                <td colspan="5">Tidak Ada Data</td>
                            </tr>
                                @else
                                @foreach ($visitors as $visitor)
                                <tr>
                                <td>{{ ($visitors->currentPage()-1) * $visitors->perPage() + $loop->index + 1 }}</td>
                                <td>{{$visitor->nama_pengunjung}}</td>
                                <td>{{$visitor->nim}}</td>
                                <td>{{$visitor->fakultas}}</td>
                                    <td>
                                        {{-- {!! Form::open(['method'=>'delete', 'class'=>'d-inline', 'route'=>['buku.destroy',$visitor->id]]) !!} --}}
                                    <a href="#" class="btn btn-sm btn-outline-success"><i class="ti-pencil"></i></a>
                                    <a href="#" class="btn btn-sm btn-outline-info" data-toggle="modal" data-target=".modal-{{$visitor->id}}"><i class="ti-eye"></i></a>

                                    {{-- <a href="{{route('buku.show',['id'=>$visitor->id])}}" class="btn btn-sm btn-outline-info"><i class="ti-eye"></i></a> --}}
                                            <button type="submit" class="btn btn-sm btn-outline-danger d-inline"> <i class="ti-close"></i></button>
                                        {{-- {!! Form::close() !!} --}}
                                    </td>

                                </tr>
                                @endforeach
                                @endif
                        </tbody>
                    </table>
                </div>
                {{-- <ul class=" mt-5 float-right pagination pg-color-border">
                        <li class="page-item">
                            <a class="page-link" href="#" tabindex="-1">Previous</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item active">
                            <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Next</a>
                        </li>
                    </ul> --}}
                    <div class="float-right mt-2">
                        {{ $visitors->links() }}
                    </div>
            </div>
    </div>
</div>
@endsection
