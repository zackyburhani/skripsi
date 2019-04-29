<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TFIDF extends Model
{
    protected $table = 'tb_tdidf';
    // protected $primaryKey = 'id_twitter';
    protected $fillable = ['string'];
    public $timestamps = false;
}
