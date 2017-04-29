# Trying to unify music sources into one handy package 🎶

[![Latest Version on Packagist](https://img.shields.io/packagist/v/utvarp/music-helper.svg?style=flat-square)](https://packagist.org/packages/utvarp/music-helper)
[![Total Downloads](https://img.shields.io/packagist/dt/utvarp/music-helper.svg?style=flat-square)](https://packagist.org/packages/utvarp/music-helper)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/utvarp/music-helper/master.svg?style=flat-square)](https://travis-ci.org/utvarp/music-helper)

There is a lot of source for music information around. Maybe you just want to search one of them. Maybe you need to have many of the at the same time. This package is here for you!

## Installation

You can install the package via composer:

```bash
composer require utvarp/music-helper
```

## Usage

At the moment, this package will only fetch _basic_ informations:

- The track name and id from requested source; 
- (If available) The artist name and id from requested source;
- (If available) The album name and id from requested source;

_For now_, you need to make extra call to the source API (with the ID) to fetch more detailed information.

In addition to the information from the source API, the package will also perform a string similarity check between a result's track and artist name against the actual searched for result. That way, you could decide not to trust the source' listing order and sort yourself by one of the smililarity score.

Here's how you could play with the package:

```php
$music = new Utvarp\MusicHelper\Music();

// If the source you want to use needs an API key, you would include it like so
// You can see in the available source list in the readme if an API needs a key
$music->setMusixmatchAPiKey($key); // method names are in this fashion: set{Sourcename}APIKey

// You're not forced to chain the methods, but search should go at the end.
// Source takes a string, an array or a collection of the possible sources, default is 'all'.
// The integer passes to search is the maximum result you want returned from an API, default is 25.
$search = $music->source('all')->artist('Lady Gaga')->track('Poker Face')->search(15);

// Now, out of all the source, if you wanted to get the Deezer results (but it could be any available source)
$deezerResults = $search->getResults('deezer');

$count = $deezerResults->count; // fetch the total results count
$results = $deezerResults->results; // get the actual result collection

// You could acccess a specific result
$result = $results->first(); // Since it's a collection, the usual methods are available
//or
$result = $results[0]; // But you can still access a collection like an array, if you prefer

// From the result, you have access to a track, artist and album object.
$trackId = $result->track->id;
$trackName = $result->track->name;
$albumName = $result->album->name;

// In those objects (except album), you also have access to a the similarity score from 3 different algorithms
$similarTextScore = $result->track->similarityScores->similar_text; // maximum score of 100.0
$smgScore = $result->track->similarityScores->smg; // Smith Waterman Gotoh score, maximum of 1.0
$levenshteinScore = $result->track->similarityScores->levenshtein; // Levenshtein score, maximum of 1
```

## Wishlist / Roadmap / Help wanted 👷🚧👷‍♀️

- Caching search so we don't hit any API rate limit too quickly
- More source
- Add more information to source (?)
- Add methods to make more precise search in sources' APIs (for ex.: searching by the ID returned by the basic search)?

## Sources

### How to create new source

This should be easy. Follow the next steps and check the corresponding files for the `deezer` source and just build from there!

1. Create a new search class in `src\Searches\{SourceName}.php`. This class should be only responsible to make the search to the source's api.
2. Create a new model class in `src\Models\{SourceName}Result.php`. This class should be only responsible to correctly _format_ the results received by the API  and set the `track`, `artist` and `album` values using the corresponding methods you can find in the base `Result` model.
3. Add `sourceName` to the `possibleSources` collection in the constructor of `src\Music.php`.
4. (If required) Add a method to set the API key of the source and add the source to the `apiKeys` collection in the constructor of `src\Music.php`.
5. Test your things, but it should now be all ok!

### Existing sources

- Deezer (API key required: *NO*)
- Musixmatch (API key required: *YES*)

## Testing

```bash
$ composer test
```

## Changelog

Changes can be found [in the release pages of the repo](https://github.com/Utvarp/music-helper/releases).

## Contributing

Contributions are welcome, [thanks to everyone who sent something out way](https://github.com/utvarp/music-helper/graphs/contributors) :)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
