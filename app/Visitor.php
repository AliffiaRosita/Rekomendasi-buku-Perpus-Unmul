<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class visitor extends Model
{

    protected $table = 'pengunjung';
    protected $fillable = ['nama_pengunjung','nim','fakultas','angkatan','foto_profil','user_id'];

    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
}
