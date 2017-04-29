<?php

namespace Utvarp\MusicHelper\Models;

use Atomescrochus\StringSimilarities\Compare;

class Result
{
    
    public function __construct($source)
    {
        $this->source = $source;
    }

    public function setTrack($id, $name = null)
    {
        $this->track = (object) [
            'id' => $id,
            'name' => $name,
        ];
    }

    public function setArtist($id, $name = null)
    {
        $this->artist = (object) [
            'id' => $id,
            'name' => $name,
        ];
    }

    public function setAlbum($id, $name = null)
    {
        $this->album = (object) [
            'id' => $id,
            'name' => $name,
        ];
    }

    public function calculateSimilarities($searchedStrings)
    {
        if (!is_null($searchedStrings->track)) {
            $compare = new Compare();
            $this->track->similarityScores = (object) $compare->all($this->track->name, $searchedStrings->track);
        } else {
            $this->track->similarityScores = null;
        }

        if (!is_null($searchedStrings->artist)) {
            $compare = new Compare();
            $this->artist->similarityScores = (object) $compare->all($this->artist->name, $searchedStrings->artist);
        } else {
            $this->track->similarityScores = null;
        }

        $this->album->similarityScores = null;
    }
}
