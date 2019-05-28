<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sentimen extends Model
{
    protected $table = 'sentimen';
    protected $primaryKey = 'id_sentimen';
    protected $fillable = ['id_sentimen','kategori'];
    public $timestamps = false;

    public function data_crawling()
    {
        return $this->hasMany('App\Models\TwitterStream','id_sentimen','id_sentimen');
    }

    public function hasil()
    {
        return $this->hasMany('App\Models\Hasil','id_sentimen','id_sentimen');
    }

    public function klasifikasi()
    {
        return $this->hasMany('App\Models\Klasifikasi','id_sentimen','id_sentimen');
    }

    public function WordFrequency()
    {
        return $this->hasMany('App\Models\WordFrequency','id_sentimen','id_sentimen');
    }
}
