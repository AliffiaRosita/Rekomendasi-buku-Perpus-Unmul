@extends('template.master')
@section('content')

<div class="main-content-inner">
    <div class="row">
        <div class="col-lg-12 mt-5">
            <div class="card p-3">
                <div class="card-body"></div>
                <h4 class="header-title">Bordered Table</h4>
                <div class="single-table">
                    <div class="table-responsive">
                        <table class="table table-bordered text-center">
                            <thead class="text-uppercase">
                                <tr>
                                    <th scope="col">User/Buku</th>
                                    @foreach ($books as $book)
                                    <th scope="col">buku id-{{$book->id}}</th>
                                    @endforeach

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($visitors as $visitor)
                                        <tr>
                                            <th scope="row">{{$visitor->id}}</th>
                                @for ($j = 1; $j < count($books); $j++) @if (isset($data[$visitor->id][$j]))
                                    <td>{{$data[$visitor->id][$j]}}</td>
                                    @else
                                    <td></td>
                                    @endif
                                    @endfor
                                    </tr>
                                    @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <form action="">
                            {{-- {{route('calc.predict')}} --}}
                        <div class="form-group">
                            <div class="row">
                                <div class="col-6">
                                    <input type="text" class="form-control" name="id" placeholder="ID Pengunjung">
                                    <small>Masukkan id pengunjung yang ingin dilihat nilai similarity dan
                                        prediksinya</small>
                                </div>
                                <div class="col-3">
                                    <button type="submit" class="btn btn-success" id="btnSubmit">Lihat !</button>
                                </div>
                            </div>
                        </div>
                    </form>


                </div>
            </div>
        </div>


    </div>
    <div class="row mt-5">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5>Similarity</h5>
                    <div class="row mt-5" id="sim-table">



                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5>Prediksi</h5>
                    <div class="row mt-5">
                        <div class="col-4" id="pred-table">
                            <table class="table table-bordered text-center">
                                <thead class="text-uppercase">
                                    <tr>
                                        <th scope="col">Id buku</th>
                                        <th scope="col">Prediksi Rating</th>
                                    </tr>
                                </thead>
                                <tbody id="tr-predict">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
$(function(e){
   $('#btnSubmit').click(function (e) {
       e.preventDefault();
       $('#sim-table').html("");
      const $visitorId= $('input[name="id"]').val();
      const url = "{{route('calc.sim')}}";

      $.ajax({
            url: url,
            method: 'GET',
            data:{
                id:$visitorId,
            },
            success: function(res){

                console.log(res);

                const countVisitor = res.visitorcount;
                const countTable = res[0].length;
                const respond = res[0];
                for (let i = 0; i < countTable; i++) {

                    // console.log(respond[i].bookid1);

                    $("#sim-table").append(`
                    <div class="col-6">
                            <table class="table table-bordered text-center">
                                <thead class="text-uppercase" >
                                        <tr>
                                            <th scope="col">User/Buku</th>
                                            <th>${respond[i].bookid1}</th>
                                            <th>${respond[i].bookid2}</th>
                                        </tr>
                                </thead>
                                <tbody id="inside-tr-${i}">


                                </tbody>
                            </table>
                            <strong>Nilai similarity = ${respond[i].similarity}</strong>
                        </div>

                    `);

                //     res.forEach(function (item) {
                //         $("#inside-table"+i).append(`


                //     `);
                // });
                const tbody = $('#inside-tr-'+i);

                    for (let j = 0; j < countVisitor; j++) {

                        if(typeof respond[i].other_visitor[j] !== "undefined"){
                        const visitId= respond[i].other_visitor[j];
                        // console.log(respond[i].other_visitor[]);

                            tbody.append(`
                            <tr>
                                <td scope="row">${j}</td>
                                <td>${visitId[0]}</td>
                                <td>${visitId[1]}</td>
                            </tr>
                            `);
                        }
                    }
            }

            },
            error:function (xhr) {
                console.log(xhr);

            },

        });
        $("#tr-predict").html("");
        const predictUrl = "{{route('calc.predict')}}";
                $.ajax({
                url: predictUrl,
                method: 'GET',
                data:{
                    id:$visitorId,
                },
                success: function(ress){
                    console.log(ress);

                    const arrLength = ress.length;
                    for (let i = 0; i < arrLength; i++) {
                        $("#tr-predict").append(`
                            <tr>
                                <td scope="row">${ress[i].buku_id}</td>
                                <td>${ress[i].nilai_prediksi}</td>
                            </tr>
                        `);



                    }
                    
                },
                error:function (xhr) {
                    console.log(xhr);
                },
            });
   })

});
</script>
@endpush
