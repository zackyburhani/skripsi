<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataTesting extends Model
{
    protected $table = 'data_testing';
    protected $primaryKey = 'id_id_testing';
    protected $fillable = ['id_testing','kategori','id_crawling'];
    public $timestamps = false;

    public function data_crawling()
    {
        return $this->belongsTo('App\Models\TwitterStream','id_crawling','id_crawling');
    }
}
