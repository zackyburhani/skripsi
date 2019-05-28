<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestingStopword extends Model
{
    protected $table = 'testing_stopwords';
    protected $fillable = ['id_stopword','id_testing','tgl_proses'];
    public $timestamps = false;
}
