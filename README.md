# \Dana\Bitap

`\Dana\Bitap` is a minimal PHP implementation of a
[Bitap](https://en.wikipedia.org/wiki/Bitap_algorithm) fuzzy string-matching
algorithm.

## Usage

Two methods are provided: `bitapMatch()`, which tests an individual needle
string against an individual hay-stack string, and `bitapGrep()`, which tests an
individual needle string against an array of hay-stack strings (similar to
`\preg_grep()`.

```
// Returns true
\Dana\Bitap\Bitap::bitapMatch('foo', 'foobar', 0);

// Returns [0 => 'foobar']
\Dana\Bitap\Bitap::bitapGrep('bar', ['foobar', 'foobaz'], 0);

// Returns [0 => 'foobar', 1 => 'foobaz']
\Dana\Bitap\Bitap::bitapGrep('bar', ['foobar', 'foobaz'], 1);
```

