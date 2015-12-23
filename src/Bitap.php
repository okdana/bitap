<?php

/**
 * This file is part of \Dana\Bitap.
 *
 * @copyright © dana <https://github.com/okdana>
 * @license   MIT
 */

namespace Dana\Bitap;

/**
 * Provides static methods for fuzzy string matching using the Bitap algorithm.
 */
class Bitap {
	/**
	 * Returns whether the supplied needle is found (potentially approximately)
	 * in the supplied haystack.
	 *
	 * Note: This method is not Unicode-safe.
	 *
	 * @param string $needle
	 *   The string to search for.
	 *
	 * @param string $haystack
	 *   The string to search within.
	 *
	 * @param int|null $threshold
	 *   (optional) The maximum number of errors to be accepted for fuzzy
	 *   matching. The default is the floor of 25% of the length of $needle. If
	 *   0, an exact match will be performed.
	 *
	 * @return bool
	 *   True if a match was found, false if not.
	 */
	public static function bitapMatch($needle, $haystack, $threshold = null) {
		$needleLen    = strlen($needle);
		$haystackLen  = strlen($haystack);
		$patternMask  = [];
		$row          = [];
		$threshold    = $threshold === null ? floor($needleLen * 0.25) : (int) abs($threshold);

		// Empty needle or exact match
		if ( $needle === '' || $needle === $haystack ) {
			return true;
		}

		// Empty hay stack
		if ( $haystack === '' ) {
			return false;
		}

		// Initialise table
		for ( $i = 0; $i <= $threshold + 1; $i++ ) {
			$row[$i] = 1;
		}

		// Initialise pattern mask (255 gives us the full extended ASCII range)
		for ( $i = 0; $i < 256; $i++ ) {
			$patternMask[$i] = 0;
		}

		// Initialise needle bit masks. e.g., the mask for 'o' in 'foo' is 110:
		// 1. foo -> original text
		// 2. 011 -> 1 where letter appears, 0 where it doesn't
		// 3. 110 -> swap bit order
		for ( $i = 0; $i < $needleLen; ++$i ) {
			$patternMask[ord($needle[$i])] |= 1 << $i;
			printf("%s: %b\n", $needle[$i], $patternMask[ord($needle[$i])]);
		}

		// Loop through hay-stack chars
		for ( $i = 0; $i < $haystackLen; $i++ ) {
			$oldCol     = 0;
			$nextOldCol = 0;

			// Test for each level of errors
			for ( $d = 0; $d <= $threshold; ++$d ) {
				$replace = ($oldCol | ($row[$d] & $patternMask[ord($haystack[$i])])) << 1;
				$insert  = $oldCol | (($row[$d] & $patternMask[ord($haystack[$i])]) << 1);
				$delete  = ($nextOldCol | ($row[$d] & $patternMask[ord($haystack[$i])])) << 1;

				$oldCol     = $row[$d];
				$row[$d]    = $replace | $insert | $delete | 1;
				$nextOldCol = $row[$d];
			}

			// If we've got a match, we're done
			if ( 0 < ($row[$threshold] & (1 << $needleLen)) ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Returns any array elements matching the supplied needle.
	 *
	 * @see \Dana\Bitap\Bitap::bitapMatch()
	 * @see \preg_grep()
	 *
	 * @param string $needle
	 *   The string to search for.
	 *
	 * @param array $haystack
	 *   An array of strings to search within.
	 *
	 * @param int|null $threshold
	 *   (optional) The number of errors to be accepted for fuzzy matching.
	 *
	 * @return array
	 *   Zero or more elements from $haystack. The original keys of any matching
	 *   elements will be preserved.
	 */
	public static function bitapGrep($needle, array $haystack, $threshold = null) {
		$results = [];

		foreach ( $haystack as $k => $v ) {
			if ( static::bitapMatch($needle, $v, $threshold) ) {
				$results[$k] = $v;
			}
		}

		return $results;
	}
}

