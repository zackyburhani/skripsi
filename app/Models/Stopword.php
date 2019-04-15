<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stopword extends Model
{
    protected $table = 'stopwords';
    // protected $primaryKey = 'id_twitter';
    protected $fillable = ['stopword'];
    public $timestamps = false;
}
