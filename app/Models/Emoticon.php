<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Emoticon extends Model
{
    protected $table = 'emoticon';
    // protected $primaryKey = 'id_twitter';
    protected $fillable = ['emoticon'];
    public $timestamps = false;
}
