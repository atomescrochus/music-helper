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

    public function search($track, $artist, $limit)
    {
        $musixmatch = new MusixmatchAPI($this->apiKey);
        
        return $musixmatch->method('track.search', array(
            'q_artist'  => $artist,
            'q_track'   => $track
        ));
    }
}
