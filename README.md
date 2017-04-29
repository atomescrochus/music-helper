# Trying to unify music sources into one handy package 🎶

[![Latest Version on Packagist](https://img.shields.io/packagist/v/utvarp/music-helper.svg?style=flat-square)](https://packagist.org/packages/utvarp/music-helper)
[![Total Downloads](https://img.shields.io/packagist/dt/utvarp/music-helper.svg?style=flat-square)](https://packagist.org/packages/utvarp/music-helper)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/utvarp/music-helper/master.svg?style=flat-square)](https://travis-ci.org/utvarp/music-helper)

*In development.*

There is a lot of source for music information around. Maybe you just want to search one of them. Maybe you need to have many of the at the same time. This package is here for you!

## Installation

You can install the package via composer:

```bash
composer require utvarp/music-helper
```

## Usage

```php
$music = new Utvarp\Music();

// sets a source, takes string, array or collection. Defaults to 'all' if no parameters.
$music->sources('all');
$music->artist('Lady Gaga'); // sets an artist to search for
$music->track('Poker Face'); // sets a track to search for

$search = $music->search(15); // value is to set a limit to the results. Default is 25.

// It could also be chained as such
$search = $music->sources('all')->artist('Lady Gaga')->track('Poker Face')->search(15);

// You can then call the corresponding method to get the results, or use $search direcly
$search->getResults(); // no parameters = all. Returns a collection or the requested value
$search->getResultsCount('deezer'); // same comment as getResults()
```

## Examples and what to expect in the results

For now, this package will only fetch _basic_ informations:

- The track name and id from requested source; 
- (If available) The artist name and id from requested source;
- (If available) The album name and id from requested source;

_For now_, you need to make extra call to the source API (with the ID) to fetch more detailed information.

In addition to the information from the source API, the package will also perform a string similarity check between a result's track and artist name against the actual searched for result. That way, you could decide not to trust the source' listing order and sort yourself by one of the smililarity score.

Here's how you could play with the package:

```php
$music = new Utvarp\Music();
$search = $music->search->source('all')->artist('Lady Gaga')->track('Poker Face')->search(15);
$deezerResults = $search->getResults('deezer');

$count = $deezerResults->count; // fetch the total results count
$results = $deezerResults->results; // get the actual result collection

// access a result
$result = $results->first(); // Since it's a collection
//or
$result = $results[0]; // But you can still access it as an array

// from here you can play with the track, artist or album object.
$trackId = $result->track->id;
$trackName = $result->track->name;
$albumName = $result->album->name;

// the similarity score isn't available for the album, since we don't (yet?) search by album
$similarTextScore = $result->track->similarityScores->similar_text; // maximum score of 100.0
$smgScore = $result->track->similarityScores->smg; // Smith Waterman Gotoh score, maximum of 1.0
$levenshteinScore = $result->track->similarityScores->levenshtein; // Levenshtein score, maximum of 1

```

## Wishlist / Roadmap / Help wanted 👷🚧👷‍♀️

- Caching search so we don't hit any API rate limit too quickly
- More source
- Add more information to source (?)


## Testing

```bash
$ composer test
```

## Contributing

Contributions are welcome, [thanks to everyone who sent something out way](https://github.com/utvarp/music-helper/graphs/contributors) :)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
