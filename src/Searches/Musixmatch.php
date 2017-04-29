<?php

namespace Utvarp\MusicHelper\Searches;

use Illuminate\Support\Collection;
use Akerbis\Musixmatch\Musixmatch as MusixmatchAPI;

class Musixmatch
{
    protected $apiKey;

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public static function search($track, $artist, $limit)
    {
        $musixmatch = new MusixmatchAPI($this->apiKey);
        
        $result = $musixmatch->method('track.search', array(
            'q_artist'  => $artist,
            'q_track'   => $track
        ));

        dd($result);
        
        return $deezer->search();
    }
}
