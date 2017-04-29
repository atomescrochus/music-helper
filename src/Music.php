<?php

namespace Utvarp\MusicHelper;

use Illuminate\Support\Collection;
use Utvarp\MusicHelper\Exceptions\MusicException;
use Utvarp\MusicHelper\Helpers;

class Music
{
    protected $possibleSources;
    private $source;

    /**
     * Create a new Music Instance.
     */
    public function __construct()
    {
        $this->possibleSources = Helpers::collect([
            'all',
            'deezer',
        ]);
    }

    /**
     * Set the wanted source for music information
     * @param  mixed $sources A string, array or collection of the sources we want to work with
     * @return [type]          [description]
     */
    public function sources($sources = 'all')
    {

        if (is_string($sources) && $this->possibleSources->contains($sources)) {
            $this->source = Helpers::collect($sources);
            return $this;
        }

        if (is_array($sources) && !$this->possibleSources->intersect($sources)->isEmpty()) {
            $this->source = Helpers::collect($sources);
            return $this;
        }

        if ($sources instanceof Collection && !$this->possibleSources->intersect($sources)->isEmpty()) {
            $this->source = $sources;
            return $this;
        }

        throw MusicException::unsupportedSource();
    }
}
