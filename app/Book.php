<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'buku';
    protected $fillable = ['judul','deskripsi','foto','penerbit','isbn','tempat_terbit'];

   public function rating()
   {
       return $this->hasMany('App\Rating','buku_id');
   }

   public function similarity()
   {
       return $this->hasMany('App\Similarity', 'buku_id');
   }
   public function recommend()
   {
       return $this->hasMany('App\Recommend', 'buku_id');
   }
}
