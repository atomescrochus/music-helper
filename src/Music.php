<?php

namespace Utvarp\MusicHelper;

use Illuminate\Support\Collection;
use Utvarp\MusicHelper\Exceptions\MusicException;
use Utvarp\MusicHelper\Helpers;

class Music
{
    protected $possibleSources;
    private $sources;

    /**
     * Create a new Music Instance.
     */
    public function __construct()
    {
        $this->possibleSources = Helpers::collect([
            'all',
            'deezer',
        ]);

        $this->sources(); // default
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

    /**
     * Return the current value of sources
     * @return Illuminate\Support\Collection A collection of set sources
     */
    public function getSources()
    {
        return $this->sources;
    }
}
