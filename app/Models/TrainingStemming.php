<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingStemming extends Model
{
    protected $table = 'training_stemming';
    protected $fillable = ['id_ktdasar','id_training','tgl_proses'];
    public $timestamps = false;
}
