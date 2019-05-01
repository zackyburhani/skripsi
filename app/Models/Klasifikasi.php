<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Klasifikasi extends Model
{
    protected $table = 'klasifikasi';
    protected $primaryKey = 'id_klasifikasi';
    protected $fillable = ['id_klasifikasi','prediksi','id_testing'];
    public $timestamps = false;

    public function data_testing()
    {
        return $this->belongsTo('App\Models\DataTesting','id_testing','id_testing');
    }
}
