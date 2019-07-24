<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataTesting extends Model
{
    protected $table = 'data_testing';
    protected $primaryKey = 'id_testing';
    protected $fillable = ['id_testing','id_crawling'];
    public $timestamps = false;

    public function data_crawling()
    {
        return $this->belongsTo('App\Models\TwitterStream','id_crawling','id_crawling');
    }

    public function klasifikasi()
    {
        return $this->hasMany('App\Models\Klasifikasi','id_testing','id_testing');
    }

    public function hasil()
    {
        return $this->hasMany('App\Models\Hasil','id_testing','id_testing');
    }

    public function term_frequency()
    {
        return $this->hasMany('App\Models\WordFrequency','id_training','id_training');
    }

    public function data_training()
    {
        return $this->belongsToMany('App\Models\DataTraining','proses','id_testing','id_training');
    }
}
