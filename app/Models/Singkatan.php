<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Singkatan extends Model
{
    protected $table = 'singkatan';
    // protected $primaryKey = 'id_twitter';
    protected $fillable = ['singkatan','makna'];
    public $timestamps = false;
}
