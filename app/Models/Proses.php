<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proses extends Model
{
    protected $table = 'proses';
    protected $fillable = ['id_testing','id_training','kelas_peluang','kemunculan_kata','nilai'];
    public $timestamps = false;
}
