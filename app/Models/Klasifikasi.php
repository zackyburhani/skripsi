<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Hasil;

class Klasifikasi extends Model
{
    protected $table = 'klasifikasi';
    protected $primaryKey = 'id_klasifikasi';
    protected $fillable = ['id_klasifikasi','prediksi','id_hasil','id_testing'];
    public $timestamps = false;

    public function data_testing()
    {
        return $this->belongsTo('App\Models\DataTesting','id_testing','id_testing');
    }

    public function hasil()
    {
        return $this->belongsTo('App\Models\Hasil','id_hasil','id_hasil');
    }

    public static function getHasil($id_testing) 
    {
        $hasil = Hasil::where('id_testing',$id_testing)->get();
        return $hasil;
    }
}
