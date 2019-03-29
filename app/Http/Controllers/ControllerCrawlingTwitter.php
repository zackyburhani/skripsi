<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twitter;
use App\Models\TwitterStream;

class ControllerCrawlingTwitter extends Controller
{
    public function index()
    {
        $title = "Data Stream";
        $data = TwitterStream::all();
        return view('crawling', compact(['title','data']));
    }

    public function crawling_data(Request $request)
    {
        $keywords = $request->input('keywords');
        $count = $request->input('count');
        $tweets = Twitter::getSearch(['count' => $count, 'q' => $keywords,'tweet_mode' => 'extended', 'format' => 'json']);
        $someObject = json_decode($tweets);
        $data = $someObject->statuses;
        $konvert = json_encode($data) ;
        $someObject = json_decode($konvert);
        for($i=0; $i<count($someObject) ; $i++) {
            $twitter = new TwitterStream;
            $twitter->tweet_id = $someObject[$i]->id;
            $twitter->name = $someObject[$i]->user->name;
            $twitter->screen_name = $someObject[$i]->user->screen_name;
            $twitter->full_text = $someObject[$i]->full_text;
            $twitter->created_at =$someObject[$i]->created_at;
            $twitter->id_str = $someObject[$i]->id_str;
            $twitter->followers_count = $someObject[$i]->user->followers_count;
            $twitter->save();
        }
        return redirect('/crawling');
    }
}
