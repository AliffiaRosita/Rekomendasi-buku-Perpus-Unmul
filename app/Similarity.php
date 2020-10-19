<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Similarity extends Model
{

    protected $table = 'similarity';
    protected $fillable = ['buku_id1','buku_id2','nilai_cosine','pengunjung_id'];
    public function visitor()
    {
        return $this->belongsTo('App\Visitor', 'pengunjung_id');
    }
    public function buku()
    {
        return $this->belongsTo('App\Book', 'buku_id');
    }
}
