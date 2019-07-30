<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Klasifikasi extends Model
{
    protected $table = 'klasifikasi';
    protected $primaryKey = 'id_klasifikasi';
    protected $fillable = ['id_klasifikasi','id_sentimen','id_hasil','id_testing'];
    public $timestamps = false;

    public function data_testing()
    {
        return $this->belongsTo('App\Models\DataTesting','id_testing','id_testing');
    }

    public function hasil()
    {
        return $this->belongsTo('App\Models\Hasil','id_hasil','id_hasil');
    }

    public function Sentimen()
    {
        return $this->belongsTo('App\Models\Sentimen','id_sentimen','id_sentimen');
    }
}
