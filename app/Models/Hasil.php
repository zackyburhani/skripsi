<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hasil extends Model
{
    protected $table = 'hasil';
    protected $primaryKey = 'id_hasil';
    protected $fillable = ['id_hasil','nilai','kelas','id_testing'];
    public $timestamps = false;

    public function data_testing()
    {
        return $this->belongsTo('App\Models\DataTesting','id_testing','id_testing');
    }

    public function klasifikasi()
    {
        return $this->hasMany('App\Models\Klasifikasi','id_hasil','id_hasil');
    }
}
