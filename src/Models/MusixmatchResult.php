<?php

namespace Utvarp\MusicHelper\Models;

use Illuminate\Support\Collection;
use Utvarp\MusicHelper\Models\Result;

class MusixmatchResult
{

    public $count;

    public function __construct($results, $searchedTrack = null, $searchedArtist = null)
    {
        $this->searchStrings = (object) [
            'track' => $searchedTrack,
            'artist' => $searchedArtist,
        ];

        $this->count = count($results['track_list']);
        $this->formatResults($results);
    }

    public function formatResults($results)
    {
        $this->results = collect($results['track_list'])->map(function ($result) {
            $model = new Result('musixmatch');
            
            $model->setTrack($result['track']['track_id'], $result['track']['track_name']);
            $model->setArtist($result['track']['artist_id'], $result['track']['artist_name']);
            $model->setAlbum($result['track']['album_id'], $result['track']['album_name']);
            $model->calculateSimilarities($this->searchStrings);

            return $model;
        });
    }
}
