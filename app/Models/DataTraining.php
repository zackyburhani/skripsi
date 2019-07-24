<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TwitterStream;
use App\Models\Sentimen;

class DataTraining extends Model
{
    protected $table = 'data_training';
    protected $primaryKey = 'id_training';
    protected $fillable = ['id_training','tweet','id_crawling'];
    public $timestamps = false;

    public function data_crawling()
    {
        return $this->belongsTo('App\Models\TwitterStream','id_crawling','id_crawling');
    }

    public function term_frequency()
    {
        return $this->hasMany('App\Models\WordFrequency','id_training','id_training');
    }

    public function data_testing()
    {
        return $this->belongsToMany('App\Models\DataTesting','proses','id_training','id_testing');
    }

    public static function totalSentimen($id)
    {
        $id_sentimen = Sentimen::where('kategori',$id)->first();
        return TwitterStream::where([['id_sentimen',$id_sentimen->id_sentimen],['status','0']])->count();
    }
}
