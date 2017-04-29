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
            $music->getSources()
        );
    }

    public function testCanSetStringAsSource()
    {
        $music = new Music();
        $music->sources('deezer');

        $this->assertFalse($music->getSources()->isEmpty());
        $this->assertNotEquals('all', $music->getSources()->first());
    }

    public function testCanSetArrayAsSource()
    {
        $music = new Music();
        $music->sources(['deezer']);

        $this->assertFalse($music->getSources()->isEmpty());
        $this->assertNotEquals('all', $music->getSources()->first());
    }

    public function testCanSetCollectionAsSource()
    {
        $sources = new Collection(['deezer']);
        $music = new Music();
        $music->sources($sources);

        $this->assertFalse($music->getSources()->isEmpty());
        $this->assertNotEquals('all', $music->getSources()->first());
    }
}
