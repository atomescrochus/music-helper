<?php

namespace Utvarp\MusicHelper\Exceptions;

use Exception;

class MusicException extends Exception
{
    public static function unsupportedSource()
    {
        return new static('One or all of the given sources are unsupported.');
    }

    public static function sourceNotFoundInResults()
    {
        return new static("We could not find the requested source in the results.");
    }
}
