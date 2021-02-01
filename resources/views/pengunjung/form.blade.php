<div class="row pt-3">
    <div class="col">
        <div class="form-group">
            {!! Form::label('nama_pengunjung', 'Nama Lengkap*', ['class'=> 'form-label']) !!}
            {!! Form::text('nama_pengunjung', isset($visitor->nama_pengunjung) ? $visitor->nama_pengunjung:null, ['class'=> 'form-control', 'id'=>'nama_pengunjung', 'autofocus']) !!}
            @if ($errors->has('nama_pengunjung')) <p class="text-danger">{{ $errors->first('nama_pengunjung') }} @endif
        </div>
    </div>
</div>

<div class="row pt-3">
    <div class="col">
        <div class="form-group">
            {!! Form::label('nim', 'Nomor Induk Mahasiswa (NIM)*', ['class'=> 'form-label']) !!}
            {!! Form::text('nim', isset($visitor->nim) ? $visitor->nim:null, ['class'=> 'form-control', 'id'=>'nim', 'autofocus']) !!}
            @if ($errors->has('nim')) <p class="text-danger">{{ $errors->first('nim') }} @endif
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            {!! Form::label('fakultas', 'Fakultas*', ['class'=> 'form-label']) !!}
            {!! Form::select('fakultas',
                [
                    'Ilmu Budaya' => 'Ilmu Budaya',
                    'Farmasi' => 'Farmasi',
                    'Kesehatan Masyarakat'=>'Kesehatan Masyarakat',
                    'Kedokteran'=>'Kedokteran',
                    'Teknik'=>'Teknik',
                    'Hukum'=>'Hukum',
                    'Matematika dan Ilmu Pengetahuan Alam'=>'Matematika dan Ilmu Pengetahuan Alam',
                    'Perikanan dan Ilmu Kelautan'=>'Perikanan dan Ilmu Kelautan',
                    'Keguruan dan Ilmu Pendidikan'=>'Keguruan dan Ilmu Pendidikan',
                    'Kehutanan'=>'Kehutanan',
                    'Pertanian'=>'Pertanian',
                    'Ilmu Sosial dan Ilmu Politik'=> 'Ilmu Sosial dan Ilmu Politik',
                    'Ekonomi'=> 'Ekonomi'

        ],isset($visitor->fakultas) ? $visitor->fakultas:null,['class'=> 'form-control', 'id'=>'fakultas', 'autofocus']) !!}

            @if ($errors->has('fakultas')) <p class="text-danger">{{ $errors->first('fakultas') }} @endif
        </div>
    </div>
</div>
<div class="row pt-3">
        <div class="col-3">
            <div class="form-group">
                {!! Form::label('angkatan', 'Angkatan*', ['class'=> 'form-label']) !!}
                {!! Form::number('angkatan', isset($visitor->angkatan) ? $visitor->angkatan:null, ['class'=> 'form-control', 'id'=>'angkatan', 'autofocus','min'=>'2009','max'=>'2020']) !!}
                @if ($errors->has('angkatan')) <p class="text-danger">{{ $errors->first('angkatan') }} @endif
            </div>
        </div>
    </div>
    @if (!isset($visitor->user->email))
    <div class="row pt-3">
            <div class="col">
                <div class="form-group">
                    {!! Form::label('email', 'Email*', ['class'=> 'form-label']) !!}
                    {!! Form::email('email', isset($visitor->user->email) ? $visitor->user->email:null, ['class'=> 'form-control', 'id'=>'email', 'autofocus']) !!}
                    @if ($errors->has('email')) <p class="text-danger">{{ $errors->first('email') }} @endif
                </div>
            </div>
                <div class="col">
                    <div class="form-group">
                        {!! Form::label('password', 'Password*', ['class'=> 'form-label']) !!}
                        {!! Form::password('password',['class'=> 'form-control', 'id'=>'password', 'autofocus']) !!}
                        <small >
                            Password Minimal 6 karakter
                        </small>
                        @if ($errors->has('password')) <p class="text-danger">{{ $errors->first('password') }} @endif
                    </div>
                </div>
            </div>
    @else
            <div class="row pt-3">
                    <div class="col-6">
                            <div class="form-group">
                                {!! Form::label('password', 'Password*', ['class'=> 'form-label']) !!}
                                {!! Form::password('password',['class'=> 'form-control', 'id'=>'password', 'autofocus']) !!}
                                <small >
                                    Kosongkan input bila tidak mengubah password (Password Minimal 8 karakter)
                                </small>
                                @if ($errors->has('password')) <p class="text-danger">{{ $errors->first('password') }} @endif
                            </div>
                        </div>
                    </div>
    @endif

    <div class="row mb-5">
            <div class="col-6">
                <p>Upload Foto Profil</p>
                @if (isset($visitor->foto_profil))
                <small style="color:red">
                    Kosongkan input bila tidak mengubah gambar
                </small>
                @endif
                {{-- {{dd(isset($book->foto))}} --}}
                <div class="row">
                    <div class="col">
                    <div id='img_contain'>
                    <img id="img" src="{{isset($visitor->foto_profil)? asset("image/pengunjung/".$visitor->foto_profil): "http://www.clker.com/cliparts/c/W/h/n/P/W/generic-image-file-icon-hi.png"}}" height="200px" width="100px"
                            alt="your image" title='' /></div>
                    <div class="input-group">
                        <div class="custom-file">
                            {{-- {{dd($book->foto)}} --}}
                        <input name="foto_profil" type="file" id="inputGroupFile01" value="{{isset($visistor->foto_profil)?$visitor->foto_profil:null}}" onchange="readURL(this)" class="imgInp custom-file-input"
                                aria-describedby="inputGroupFileAddon01">
                            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                        </div>


                    </div>
                    <small >
                       Foto yang diupload maximal berukuran 3mb
                    </small>
                     @if ($errors->has('foto_profil')) <p class="text-danger">{{ $errors->first('foto_profil') }} @endif
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
