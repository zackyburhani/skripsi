<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stopword extends Model
{
    protected $table = 'stopwords';
    protected $fillable = ['stopword'];
    public $timestamps = false;
}
