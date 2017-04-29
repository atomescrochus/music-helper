<?php

namespace Utvarp\MusicHelper\Models;

use Illuminate\Support\Collection;
use Utvarp\MusicHelper\Models\Result;

class DeezerResult
{

    public $count;

    public function __construct($results, $searchedTrack = null, $searchedArtist = null)
    {
        $this->searchStrings = (object) [
            'track' => $searchedTrack,
            'artist' => $searchedArtist,
        ];

        $this->count = count($results);
        $this->formatResults($results);
    }

    public function formatResults($results)
    {
        $this->results = collect($results)->map(function ($result) {
            $model = new Result('deezer');
            $model->setTrack($result->id, $result->title);
            $model->setArtist($result->artist->id, $result->artist->name);
            $model->setAlbum($result->album->id, $result->album->title);
            $model->calculateSimilarities($this->searchStrings);

            return $model;
        });
    }
}
