<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WordFrequency extends Model
{
    protected $table = 'term_frequency';
    protected $primaryKey = 'id_term';
    protected $fillable = ['kata','kategori','jumlah','id_training'];
    public $timestamps = false;

    public function data_training()
    {
        return $this->belongsTo('App\Models\DataTraining','id_training','id_training');
    }
}
