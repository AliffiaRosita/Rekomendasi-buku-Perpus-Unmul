@extends('template.master')
@section('content')
<div class="page-title-area">
        <div class="row align-items-center">
            <div class="col-sm-6 p-2">
                <div class="breadcrumbs-area clearfix">
                    <h4 class="page-title pull-left">Buku</h4>
                    <ul class="breadcrumbs pull-left">
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
        <h4 class="header-title d-inline">Data  Buku</h4>
        <form action="{{url()->current()}}" >
        <div class="row form-group mt-3">
            <div class="col-3">
                    <select name="category" class="form-control" id="">
                        @if ((isset($query['category'])))

                        <option value="judul" {{($query['category']==="judul")?'selected':""}} >Judul</option>
                        <option value="penerbit" {{($query['category']==="penerbit")?'selected':""}}>Penerbit</option>
                        <option value="isbn" {{($query['category']==="isbn")?'selected':""}}>ISBN</option>
                        @else
                            <option value="judul"  >Judul</option>
                            <option value="penerbit">Penerbit</option>
                            <option value="isbn" >ISBN</option>
                            @endif
                        </select>
                </div>
            <div class="col-4">
                    <div class="input-group mb-3">
                    <input type="text" name="keyword" value="{{isset($query['keyword'])?$query['keyword']:""}}" class="form-control" placeholder="Kata kunci" aria-label="Recipient's username" aria-describedby="button-addon2">
                            <div class="input-group-append">
                              <button class="btn btn-outline-secondary" type="submit" id="button-addon2"><i class="ti-search"></i></button>
                            </div>
                          </div>
            </div>
        </form>
<div class="col-5">
    <a href="{{route('buku.create')}}" class=" float-right mb-3 btn btn-sm btn-success"><i class="ti-plus"></i> Tambah Buku</a>
</div>
        </div>
        <div class="single-table">

                <div class="table-responsive">
                    <table class="table table-hover text-center">
                        <thead class="text-uppercase bg-primary">
                            <tr class="text-white">
                                    <th width="5%">ID</th>
                                    <th width="30%">Judul</th>
                                    <th>Penerbit</th>
                                    <th>ISBN</th>
                                    <th width="20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($books)==0)
                            <tr>
                                <td colspan="5">Tidak Ada Data</td>
                            </tr>
                                @else
                                @foreach ($books as $book)
                                <tr>
                                <td>{{ ($books->currentPage()-1) * $books->perPage() + $loop->index + 1 }}</td>
                                <td>{{$book->judul}}</td>
                                <td>{{$book->penerbit}}</td>
                                <td>{{$book->isbn}}</td>
                                    <td>
                                    <a href="{{route('buku.edit',['id'=>$book->id])}}" class="btn btn-sm btn-outline-success"><i class="ti-pencil"></i></a>
                                    <a href class="btn btn-sm btn-outline-info" data-toggle="modal" data-target=".modal-{{$book->id}}"><i class="ti-eye"></i></a>
                                            <button type="submit" class="btn btn-sm btn-outline-danger d-inline" onclick="btnDelete({{$book->id}},'buku',event)"> <i class="ti-close"></i></button>
                                    </td>

                                    @include('buku/_modal')

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
                        {{ $books->links() }}
                    </div>
            </div>
    </div>
</div>
@endsection
