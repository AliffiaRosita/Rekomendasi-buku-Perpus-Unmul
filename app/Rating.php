<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class rating extends Model
{
    protected $table = 'rating';
    protected $fillable = ['pengunjung_id','buku_id','nilai','ulasan'];

    public function visitor()
    {
        return $this->belongsTo('App\Visitor', 'pengunjung_id');
    }
    public function buku()
    {
        return $this->belongsTo('App\Book', 'buku_id');
    }

}
