<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WordFrequency extends Model
{
    protected $table = 'term_frequency';
    protected $primaryKey = 'id_term';
    protected $fillable = ['kata','id_sentimen','jumlah','id_training','id_testing','nilai_bobot'];
    public $timestamps = false;

    public function data_training()
    {
        return $this->belongsTo('App\Models\DataTraining','id_training','id_training');
    }

    public function sentimen()
    {
        return $this->belongsTo('App\Models\Sentimen','id_sentimen','id_sentimen');
    }

    public function data_testing()
    {
        return $this->belongsTo('App\Models\DataTesting','id_testing','id_testing');
    }
}
