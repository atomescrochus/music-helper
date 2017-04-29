<?php

namespace Utvarp\MusicHelper;

use Illuminate\Support\Collection;

class Helpers
{
    public static function collect($value = [])
    {
        return new Collection($value);
    }
}
