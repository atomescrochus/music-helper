<?php

namespace Utvarp\MusicHelper\Searches;

use Illuminate\Support\Collection;
use DeezerAPI\Search;

class Deezer
{
    public static function search($track, $artist, $limit)
    {
        $deezer = new Search("{$track} {$artist}", null, null, $limit, false);
        
        return $deezer->search();
    }
}
