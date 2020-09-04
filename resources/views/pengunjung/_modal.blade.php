<div class="modal fade modal-{{$visitor->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
              <h5>Detail Pengunjung</h5>
          </div>
          <div class="modal-body">
                <img src="{{asset("image/pengunjung/".$visitor->foto_profil)}}"  class="img-thumbnail ml-auto mr-auto d-block" alt="">

            <div class="row pt-3">
                <div class="col">
                    <div class="form-group">
                        {!! Form::label('nama_pengunjung', 'Nama Lengkap*', ['class'=> 'form-label text-left']) !!}
                        {!! Form::text('nama_pengunjung', $visitor->nama_pengunjung, ['class'=> 'form-control', 'id'=>'nama_pengunjung', 'autofocus','disabled']) !!}
                        @if ($errors->has('nama_pengunjung')) <p class="text-danger">{{ $errors->first('nama_pengunjung') }} @endif
                    </div>
                </div>
            </div>

            <div class="row pt-3">
                <div class="col">
                    <div class="form-group">
                        {!! Form::label('nim', 'Nomor Induk Mahasiswa (NIM)*', ['class'=> 'form-label text-left']) !!}
                        {!! Form::text('nim', $visitor->nim, ['class'=> 'form-control', 'id'=>'nim', 'autofocus','disabled']) !!}
                        @if ($errors->has('nim')) <p class="text-danger">{{ $errors->first('nim') }} @endif
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        {!! Form::label('fakultas', 'Fakultas*', ['class'=> 'form-label text-left']) !!}
                        {!! Form::text('fakultas',$visitor->fakultas,['class'=> 'form-control', 'id'=>'fakultas', 'autofocus','disabled']) !!}

                        @if ($errors->has('fakultas')) <p class="text-danger">{{ $errors->first('fakultas') }} @endif
                    </div>
                </div>
            </div>
            <div class="row pt-3">
                    <div class="col-3">
                        <div class="form-group">
                            {!! Form::label('angkatan', 'Angkatan*', ['class'=> 'form-label text-left']) !!}
                            {!! Form::number('angkatan', $visitor->angkatan, ['class'=> 'form-control', 'id'=>'angkatan', 'autofocus','disabled']) !!}
                            @if ($errors->has('angkatan')) <p class="text-danger">{{ $errors->first('angkatan') }} @endif
                        </div>
                    </div>
                </div>
                <div class="row pt-3">
                        <div class="col">
                            <div class="form-group">
                                {!! Form::label('email', 'Email*', ['class'=> 'form-label text-left']) !!}
                                {!! Form::email('email', empty($visitor->user->email)?'':$visitor->user->email, ['class'=> 'form-control', 'id'=>'email', 'autofocus','disabled']) !!}
                                @if ($errors->has('email')) <p class="text-danger">{{ $errors->first('email') }} @endif
                            </div>
                        </div>
                        </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
      </div>
  </div>
</div>

