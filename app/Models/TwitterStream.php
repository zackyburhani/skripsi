<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
\Carbon\Carbon::setLocale('id');

class TwitterStream extends Model
{
    protected $table = 'data_crawling';
    protected $primaryKey = 'id_crawling';
    protected $fillable = ['id_crawling','username','tweet_id','tweet','tgl_tweet','status','proses','id_sentimen'];
    public $timestamps = false;

    public function data_testing()
    {
        return $this->hasOne('App\Models\DataTesting','id_crawling','id_crawling');
    }

    public function data_training()
    {
        return $this->hasOne('App\Models\DataTraining','id_crawling','id_crawling');
    }

    public function sentimen()
    {
        return $this->belongsTo('App\Models\Sentimen','id_sentimen','id_sentimen');
    }
    
    public static function getTanggal() 
    {   
        $hasil = Carbon::now()->format('l, d F Y');
        return $hasil;
    }
}
