<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingStopword extends Model
{
    protected $table = 'training_stopwords';
    protected $fillable = ['id_stopword','id_training','tgl_proses'];
    public $timestamps = false;
}
