<?php

namespace Utvarp\MusicHelper\Test;

use Illuminate\Support\Collection;
use Utvarp\MusicHelper\Music;

class MusicClassTest extends \PHPUnit_Framework_TestCase
{
    
    public function testMusicClassCanBeCreatedWithDefaultValues()
    {
        $music = new Music();

        $this->assertInstanceOf(
            Music::class,
            $music
        );

        $this->assertInstanceOf(
            Collection::class,
            $music->sources
        );

        $this->assertNull($music->artist);
        $this->assertNull($music->track);
    }

    public function testCanSetStringAsSource()
    {
        $music = new Music();
        $music->sources('deezer');

        $this->assertFalse($music->sources->isEmpty());
        $this->assertNotEquals('all', $music->sources->first());
    }

    public function testCanSetArrayAsSource()
    {
        $music = new Music();
        $music->sources(['deezer']);

        $this->assertFalse($music->sources->isEmpty());
        $this->assertNotEquals('all', $music->sources->first());
    }

    public function testCanSetCollectionAsSource()
    {
        $sources = new Collection(['deezer']);
        $music = new Music();
        $music->sources($sources);

        $this->assertFalse($music->sources->isEmpty());
        $this->assertNotEquals('all', $music->sources->first());
    }

    public function testCanSetAnArtistToSearchFor()
    {
        $artist = "Lady Gaga";
        $music = new Music();
        $music->artist($artist);

        $this->assertEquals($artist, $music->artist);
    }

    public function testCanSetATrackToSearchFor()
    {
        $track = "Poker Face";
        $music = new Music();
        $music->track($track);

        $this->assertEquals($track, $music->track);
    }

    public function testCanMakeASearchForInAllSources()
    {
        $track = "Poker Face";
        $artist = "Lady Gaga";
        $music = new Music();

        $results = $music->sources('all')->track($track)->artist($artist)->search();
    }
}
