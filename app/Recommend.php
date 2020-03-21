<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recommend extends Model
{

    protected $table = 'rekomendasi';
    protected $fillable = ['nilai_prediksi','buku_id','pengunjung_id'];
    public function visitor()
    {
        return $this->belongsTo('App\Visitor', 'pengunjung_id');
    }
    public function buku()
    {
        return $this->belongsTo('App\Book', 'buku_id');
    }
}
