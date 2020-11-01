@extends('template.master')
@section('content')
<div class="page-title-area">
        <div class="row align-items-center">
            <div class="col-sm-6 p-2">
                <div class="breadcrumbs-area clearfix">
                    <h4 class="page-title pull-left">Pengunjung</h4>
                    <ul class="breadcrumbs pull-left">
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
        <form action="{{url()->current()}}" >
                <div class="row form-group mt-3">
                    <div class="col-3">
                        <label for="">Kategori</label>
                            <select name="category" class="form-control" id="">
                                    <option value="nama_pengunjung">Nama</option>
                                    <option value="nim">Nomor Induk Mahasiswa</option>
                                </select>
                        </div>
                        <div class="col-4">
                            <label for="">Fakultas</label>
                                <select name="fakultas" class="form-control" id="">
                                        <option value="" disabled selected>--Pilih Fakultas--</option>
                                        <option value="Ilmu budaya">Ilmu Budaya</option>
                                        <option value="Farmasi">Farmasi</option>
                                        <option value="Kesehatan Masyarakat">Kesehatan Masyarakat</option>
                                        <option value="Kedokteran">Kedokteran</option>
                                        <option value="Teknik">Teknik</option>
                                        <option value="Hukum">Hukum</option>
                                        <option value="Matematika dan Ilmu Pengetahuan Alam">Matematika dan Ilmu Pengetahuan Alam</option>
                                        <option value="Perikanan dan Ilmu Kelautan">Perikanan dan Ilmu Kelautan</option>
                                        <option value="Keguruan dan Ilmu Pendidikan">Keguruan dan Ilmu Pendidikan</option>
                                        <option value="Kehutanan">Kehutanan</option>
                                        <option value="Pertanian">Pertanian</option>
                                        <option value="Ilmu Sosial dan Ilmu Politik">Ilmu Sosial dan Ilmu Politik</option>
                                        <option value="Ekonomi">Ekonomi</option>
                                        </select>
                        </div>
                    <div class="col-4">
                            <div class="input-group mt-4">
                            <input type="text" name="keyword" value="{{isset($query['keyword'])?$query['keyword']:""}}" class="form-control" placeholder="Kata kunci" aria-label="Recipient's username" aria-describedby="button-addon2">
                                    <div class="input-group-append">
                                      <button class="btn btn-outline-secondary" type="submit" id="button-addon2"><i class="ti-search"></i></button>
                                    </div>
                                  </div>
                    </div>
                </form>
<div class="col-1 mt-4">
<a href="{{route('pengunjung.create')}}" data-toggle="tooltip" data-placement="top" title="Tambah Pengunjung" class=" float-right mb-3 btn btn-sm btn-success"><i class="ti-plus"></i></a>
</div>
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
                                    <a href="{{route('pengunjung.edit',['id'=>$visitor->id])}}" class="btn btn-sm btn-outline-success"><i class="ti-pencil"></i></a>
                                    <a href="#" class="btn btn-sm btn-outline-info" data-toggle="modal" data-target=".modal-{{$visitor->id}}"><i class="ti-eye"></i></a>
                                    <button type="submit" class="btn btn-sm btn-outline-danger d-inline" onclick="btnDelete({{$visitor->id}},'pengunjung',event)"> <i class="ti-close"></i></button>

                                    </td>
                                    @include('pengunjung._modal')

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
@push('js')
<script>
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>
@endpush
