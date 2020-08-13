<div class="row pt-3">
    <div class="col">
        <div class="form-group">
            {!! Form::label('judul', 'Judul Buku*', ['class'=> 'form-label']) !!}
            {!! Form::text('judul', null, ['class'=> 'form-control', 'id'=>'judul', 'autofocus']) !!}
            @if ($errors->has('judul')) <p class="text-danger">{{ $errors->first('judul') }} @endif
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="form-group">
            {!! Form::label('penerbit', 'Penerbit*', ['class'=> 'form-label']) !!}
            {!! Form::text('penerbit', null, ['class'=> 'form-control','id'=>'penerbit', 'autofocus']) !!}
            @if ($errors->has('penerbit')) <p class="text-danger">{{ $errors->first('penerbit') }} @endif
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            {!! Form::label('isbn', 'International Standard Book Number (ISBN)*', ['class'=> 'form-label']) !!}
            {!! Form::text('isbn', null, ['class'=> 'form-control','id'=>'isbn', 'autofocus']) !!}
            @if ($errors->has('isbn')) <p class="text-danger">{{ $errors->first('isbn') }} @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="form-group">
            {!! Form::label('deskripsi', 'Deskripsi Buku', ['class'=> 'form-label']) !!}
            {!! Form::textarea('deskripsi', null, ['rows'=>'5','class'=> 'form-control', 'autofocus']) !!}
            @if ($errors->has('deskripsi')) <p class="text-danger">{{ $errors->first('deskripsi') }} @endif
        </div>
    </div>
</div>

<div class="row mb-5">
    <div class="col-6">
        <p>Upload Cover Buku</p>
        @if (isset($book->foto))
        <small style="color:red">
            Kosongkan input bila tidak mengubah gambar
        </small>
        @endif
        {{-- {{dd(isset($book->foto))}} --}}
        <div class="row">
            <div class="col">
            <div id='img_contain'>
            <img id="img" src="{{isset($book->foto)? asset("storage/image/buku/".$book->foto): "http://www.clker.com/cliparts/c/W/h/n/P/W/generic-image-file-icon-hi.png"}}" height="200px" width="100px"
                    alt="your image" title='' /></div>
            <div class="input-group">
                <div class="custom-file">
                    {{-- {{dd($book->foto)}} --}}
                <input name="foto" type="file" id="inputGroupFile01" value="{{isset($book->foto)?$book->foto:null}}" onchange="readURL(this)" class="imgInp custom-file-input"
                        aria-describedby="inputGroupFileAddon01">
                    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                </div>
                @if ($errors->has('foto'))  <p class="text-danger">{{ $errors->first('foto') }}</p> @endif
            </div>
        </div>
    </div>
    </div>
</div>

@push('js')
<script>
    function readURL(input) {
        // console.log(input.file);

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#img')
                        .attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }



</script>
@endpush
