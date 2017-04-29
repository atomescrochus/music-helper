<?php

namespace Utvarp\MusicHelper;

use Illuminate\Support\Collection;
use Utvarp\MusicHelper\Exceptions\MusicException;
use Utvarp\MusicHelper\Helpers;

class Music
{
    protected $possibleSources;

    public $sources;
    public $track;
    public $artist;
    public $results;
    public $limit;

    /**
     * Create a new Music Instance.
     */
    public function __construct()
    {
        $this->possibleSources = Helpers::collect([
            'all',
            'deezer'
        ]);

        // set defaults
        $this->sources();
        $this->track = null;
        $this->artist = null;
        $this->results = (object) [
            'searchedForArtist' => null,
            'searchedForTrack' => null,
            'countBySources' => Helpers::collect([]),
            'resultsBySources' => Helpers::collect([]),
        ];

        return $this;
    }

    /**
     * Searches for possible results of artist and track, on selected sources
     * @return object An object containing collections of results and count
     */
    public function search($limit = 25)
    {
        if ($this->sources->contains('all')) {
            $sources = $this->possibleSources->reject(function ($source) {
                return $source == 'all';
            });
        } else {
            $sources = $this->sources;
        }

        $this->limit = $limit;

        $sources->each(function ($source) {
            $ucFirstSource = ucfirst($source);
            $searchClassName = "Utvarp\MusicHelper\Searches\\".$ucFirstSource;
            $resultModelName = "Utvarp\MusicHelper\Models\\".$ucFirstSource."Result";

            $searchClass = new $searchClassName();
            $searchResults = $searchClass->search($this->track, $this->artist, $this->limit);

            $results = new $resultModelName($searchResults, $this->track, $this->artist);
            
            $this->results->resultsBySources->put($source, $results);
            $this->results->countBySources->put($source, $results->count);
        });

        $this->results->searchedForArtist = $this->artist;
        $this->results->searchedForTrack = $this->track;

        return $this->results;
    }

    public function getResultsCount($source = 'all')
    {
        if ($source == "all") {
            return $this->results->countBySources;
        }

        if ($this->results->countBySources->has($source)) {
            return $this->results->countBySources->get($source);
        }

        throw MusicException::sourceNotFoundInResults();
    }

    public function getResults($source = 'all')
    {
        if ($source == "all") {
            return $this->results->resultsBySources;
        }

        if ($this->results->resultsBySources->has($source)) {
            return $this->results->resultsBySources->get($source);
        }

        throw MusicException::sourceNotFoundInResults();
    }

    /**
     * Set a track name to search for
     * @param  string $track The track name
     */
    public function track(string $track)
    {
        $this->track = $track;

        return $this;
    }

    /**
     * Set an artist name to search for
     * @param  string $artist The artist name
     */
    public function artist(string $artist)
    {
        $this->artist = $artist;

        return $this;
    }

    /**
     * Set the wanted source for music information
     * @param  mixed $sources A string, array or collection of the sources we want to work with
     * @return [type]          [description]
     */
    public function sources($sources = 'all')
    {

        if (is_string($sources) && $this->possibleSources->contains($sources)) {
            $this->sources = Helpers::collect($sources);
            return $this;
        }

        if (is_array($sources) && !$this->possibleSources->intersect($sources)->isEmpty()) {
            $this->sources = Helpers::collect($sources);
            return $this;
        }

        if ($sources instanceof Collection && !$this->possibleSources->intersect($sources)->isEmpty()) {
            $this->sources = $sources;
            return $this;
        }

        throw MusicException::unsupportedSource();
    }
}
