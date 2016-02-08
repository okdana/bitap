# \Dana\Bitap

`\Dana\Bitap` is a minimal PHP implementation of a
[Bitap](https://en.wikipedia.org/wiki/Bitap_algorithm) fuzzy string-matching
algorithm.

## Usage

Two methods are provided: `match()`, which tests an individual needle string
against an individual hay-stack string, and `grep()`, which tests an individual
needle string against an array of hay-stack strings (similar to `\preg_grep()`.

```
// Returns true
(new \Dana\Bitap\Bitap())->match('foo', 'foobar', 0);

// Returns [0 => 'foobar']
(new \Dana\Bitap\Bitap())->grep('bar', ['foobar', 'foobaz'], 0);

// Returns [0 => 'foobar', 1 => 'foobaz']
(new \Dana\Bitap\Bitap())->grep('bar', ['foobar', 'foobaz'], 1);
```

## To do

* Make Unicode-safe
* Provide methods which return the match index(es)

