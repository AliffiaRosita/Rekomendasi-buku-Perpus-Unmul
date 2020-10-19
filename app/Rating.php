<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
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
    public function rateInBook()
    {
        return $this->belongsTo('App\Book', 'buku_id')->selectRaw('avg(nilai)')->groupBy('buku_id');
    }

}
