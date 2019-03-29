<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TwitterStream extends Model
{
    protected $table = 'data_crawling';
    // protected $primaryKey = 'id_twitter';
    protected $fillable = ['tweet_id','name','screen_name','full_text','created_at','id_str','followers_count'];
    public $timestamps = false;
}
