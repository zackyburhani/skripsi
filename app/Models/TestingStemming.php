<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestingStemming extends Model
{
    protected $table = 'testing_stemming';
    protected $fillable = ['id_ktdasar','id_testing','tgl_proses'];
    public $timestamps = false;
}
