<?php

/**
 * This file is part of \Dana\Bitap.
 *
 * @copyright © dana <https://github.com/okdana>
 * @license   MIT
 */

namespace Dana\Test\Bitap;

/**
 * Provides tests for \Dana\Bitap\Bitap.
 */
class BitapTest extends \PHPUnit_Framework_TestCase {
	/**
	 * Data provider for match() arguments and results.
	 *
	 * @return array[]
	 */
	public function provideMatchTests() {
		return [
			// Empty needle tests
			['', 'foo', 0, true],
			['', 'foo', 1, true],
			['', 'foo', 2, true],
			['', 'foo', 3, true],
			['', 'foo', 4, true],
			['', 'foo', 5, true],
			['', '',    0, true],
			['', '',    1, true],
			['', '',    2, true],

			// Empty hay-stack tests
			['foo', '', 0, false],
			['foo', '', 1, false],
			['foo', '', 2, false],
			['foo', '', 3, false],
			['foo', '', 4, false],
			['foo', '', 5, false],

			// Single-character exact-match tests
			['a', 'a', 0, true],
			['a', 'a', 1, true],
			['a', 'a', 2, true],
			['a', 'a', 3, true],

			// Multiple-character exact-match tests
			['foo', 'foo', 0, true],
			['foo', 'foo', 1, true],
			['foo', 'foo', 2, true],
			['foo', 'foo', 3, true],
			['foo', 'foo', 4, true],
			['foo', 'foo', 5, true],

			// Single-character off-by-one tests
			['a', 'b', 0, false],
			['a', 'b', 1, true],
			['a', 'b', 2, true],
			['a', 'b', 3, true],

			// Multiple-character off-by-one tests
			['bar', 'baz', 0, false],
			['bar', 'baz', 1, true],
			['bar', 'baz', 2, true],
			['bar', 'baz', 3, true],
			['bar', 'baz', 4, true],
			['bar', 'baz', 5, true],

			// Multiple-character needle-longer-than-hay-stack tests
			['barr', 'bar', 0, false],
			['barr', 'bar', 1, true],
			['barr', 'bar', 2, true],
			['barr', 'bar', 3, true],
			['barr', 'baz', 0, false],
			['barr', 'baz', 1, false],
			['barr', 'baz', 2, true],
			['barr', 'baz', 3, true],

			// Single-character sub-string match tests — match at beginning
			['f', 'foo', 0, true],
			['f', 'foo', 1, true],
			['f', 'foo', 2, true],
			['f', 'foo', 3, true],

			// Single-character sub-string match tests — match in middle
			['f', 'ofo', 0, true],
			['f', 'ofo', 1, true],
			['f', 'ofo', 2, true],
			['f', 'ofo', 3, true],

			// Single-character sub-string match tests — match at end
			['f', 'oof', 0, true],
			['f', 'oof', 1, true],
			['f', 'oof', 2, true],
			['f', 'oof', 3, true],

			// Multiple-character sub-string match tests — match at beginning
			['bar', 'barbazbaz', 0, true],
			['bar', 'barbazbaz', 1, true],
			['bar', 'barbazbaz', 2, true],
			['bar', 'barbazbaz', 3, true],

			// Multiple-character sub-string match tests — match in middle
			['bar', 'bazbarbaz', 0, true],
			['bar', 'bazbarbaz', 1, true],
			['bar', 'bazbarbaz', 2, true],
			['bar', 'bazbarbaz', 3, true],

			// Multiple-character sub-string match tests — match at end
			['bar', 'bazbazbar', 0, true],
			['bar', 'bazbazbar', 1, true],
			['bar', 'bazbazbar', 2, true],
			['bar', 'bazbazbar', 3, true],
		];
	}

	/**
	 * Data provider for grep() arguments and results.
	 *
	 * @return array[]
	 */
	public function provideGrepTests() {
		$array = ['foo', 'foobar', 'barfoo', 'barbaz', 'baz'];

		return [
			['',    $array, 0, $array],
			['',    $array, 1, $array],
			['',    $array, 2, $array],
			['',    $array, 3, $array],

			['foo', $array, 0, ['foo', 'foobar', 'barfoo']],
			['foo', $array, 1, ['foo', 'foobar', 'barfoo']],
			['foo', $array, 2, ['foo', 'foobar', 'barfoo']],
			['foo', $array, 3, $array],

			['bar', $array, 0, ['foobar', 'barfoo', 'barbaz']],
			['bar', $array, 1, ['foobar', 'barfoo', 'barbaz', 'baz']],
			['bar', $array, 2, ['foobar', 'barfoo', 'barbaz', 'baz']],
			['bar', $array, 3, $array],
		];
	}

	/**
	 * Tests match() method.
	 *
	 * @param string $needle
	 * @param string $haystack
	 * @param int    $threshold
	 * @param bool   $expected
	 *
	 * @return void
	 *
	 * @dataProvider provideMatchTests
	 */
	public function testMatch($needle, $haystack, $threshold, $expected) {
		$this->assertSame(
			$expected,
			(new \Dana\Bitap\Bitap())->match($needle, $haystack, $threshold)
		);
	}

	/**
	 * Tests grep() method.
	 *
	 * @param string $needle
	 * @param array  $haystack
	 * @param int    $threshold
	 * @param array  $expected
	 *
	 * @return void
	 *
	 * @dataProvider provideGrepTests
	 */
	public function testGrep($needle, $haystack, $threshold, $expected) {
		$actual = (new \Dana\Bitap\Bitap())->grep($needle, $haystack, $threshold);

		$this->assertSame(
			$expected,
			array_values($actual)
		);
	}
}

