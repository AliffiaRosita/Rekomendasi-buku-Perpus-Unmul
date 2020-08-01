<div class="row pt-3">
    <div class="col">
        <div class="form-group">
            {!! Form::label('nama_pengunjung', 'Nama Lengkap*', ['class'=> 'form-label']) !!}
            {!! Form::text('nama_pengunjung', null, ['class'=> 'form-control', 'id'=>'nama_pengunjung', 'autofocus']) !!}
            @if ($errors->has('nama_pengunjung')) <p class="text-danger">{{ $errors->first('nama_pengunjung') }} @endif
        </div>
    </div>
</div>

<div class="row pt-3">
    <div class="col">
        <div class="form-group">
            {!! Form::label('nim', 'Nomor Induk Mahasiswa (NIM)*', ['class'=> 'form-label']) !!}
            {!! Form::text('nim', null, ['class'=> 'form-control', 'id'=>'nim', 'autofocus']) !!}
            @if ($errors->has('nim')) <p class="text-danger">{{ $errors->first('nim') }} @endif
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            {!! Form::label('fakultas', 'Fakultas*', ['class'=> 'form-label']) !!}
            {!! Form::select('fakultas',
                [
                    'Fakultas Ilmu Budaya' => 'Fakultas Ilmu Budaya',
                    'Fakultas Farmasi' => 'Fakultas Farmasi',
                    'Fakultas Kesehatan Masyarakat'=>'Fakultas Kesehatan Masyarakat',
                    'Fakultas Kedokteran'=>'Fakultas Kedokteran',
                    'Fakultas Teknik'=>'Fakultas Teknik',
                    'Fakultas Hukum'=>'Fakultas Hukum',
                    'Fakultas Matematika dan Ilmu Pengetahuan Alam'=>'Fakultas Matematika dan Ilmu Pengetahuan Alam',
                    'Fakultas Perikanan dan Ilmu Kelautan'=>'Fakultas Perikanan dan Ilmu Kelautan',
                    'Fakultas Keguruan dan Ilmu Pendidikan'=>'Fakultas Keguruan dan Ilmu Pendidikan',
                    'Fakultas Kehutanan'=>'Fakultas Kehutanan',
                    'Fakultas Pertanian'=>'Fakultas Pertanian',
                    'Fakultas Ilmu Sosial dan Ilmu Politik'=> 'Fakultas Ilmu Sosial dan Ilmu Politik',
                    'Fakultas Ekonimi'=> 'Fakultas Ekonimi'

        ],null,['class'=> 'form-control', 'id'=>'fakultas', 'autofocus']) !!}

            @if ($errors->has('fakultas')) <p class="text-danger">{{ $errors->first('fakultas') }} @endif
        </div>
    </div>
</div>
<div class="row pt-3">
        <div class="col-3">
            <div class="form-group">
                {!! Form::label('angkatan', 'Angkatan*', ['class'=> 'form-label']) !!}
                {!! Form::number('angkatan', null, ['class'=> 'form-control', 'id'=>'angkatan', 'autofocus']) !!}
                @if ($errors->has('angkatan')) <p class="text-danger">{{ $errors->first('angkatan') }} @endif
            </div>
        </div>
    </div>
    <div class="row pt-3">
            <div class="col">
                <div class="form-group">
                    {!! Form::label('email', 'Email*', ['class'=> 'form-label']) !!}
                    {!! Form::email('email', null, ['class'=> 'form-control', 'id'=>'email', 'autofocus']) !!}
                    @if ($errors->has('email')) <p class="text-danger">{{ $errors->first('email') }} @endif
                </div>
            </div>
                <div class="col">
                    <div class="form-group">
                        {!! Form::label('password', 'Password*', ['class'=> 'form-label']) !!}
                        {!! Form::password('password',['class'=> 'form-control', 'id'=>'password', 'autofocus']) !!}
                        @if ($errors->has('password')) <p class="text-danger">{{ $errors->first('password') }} @endif
                    </div>
                </div>
            </div>

    <div class="row mb-5">
            <div class="col-6">
                <p>Upload Foto Profil</p>
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
                        <input name="foto_profil" type="file" id="inputGroupFile01" value="{{isset($book->foto)?$book->foto:null}}" onchange="readURL(this)" class="imgInp custom-file-input"
                                aria-describedby="inputGroupFileAddon01">
                            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                        </div>
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
