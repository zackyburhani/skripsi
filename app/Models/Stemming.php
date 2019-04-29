<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stemming extends Model
{
    protected $table = 'stemming';
    protected $primaryKey = 'id_ktdasar';
    protected $fillable = ['id_ktdasar','katadasar','tipe_katadasar'];
    public $timestamps = false;
}
