<?php

/**
 * This file is part of \Dana\Bitap.
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
	 * @param float|int $threshold
	 *   (optional) The ratio of erroneous $needle characters to be accepted for
	 *   fuzzy matching. The default is 0.25 (25% of the length of $needle). If
	 *   0, exact matching will be used.
	 *
	 * @return \Dana\Bitap\BitapResult
	 *   An object representing the result of the match.
	 */
	public static function bitapMatch($needle, $haystack, $threshold = 0.25) {
		$needleLen    = strlen($needle);
		$haystackLen  = strlen($haystack);
		$patternMask  = [];
		$row          = [];
		$firstMatched = -1;
		$indexes      = [];

		if ( $needle === '' || $needle === $haystack ) {
			return new \Dana\Bitap\BitapResult($needle, $haystack, [0]);
		}

		if ( $haystack === '' ) {
			return new \Dana\Bitap\BitapResult($needle, $haystack);
		}

		if ( $threshold < 0.000 || $threshold > 1.000 ) {
			throw new \InvalidArgumentException('Threshold must be between 0 and 1');
		}

		$threshold = floor($needleLen * $threshold);

		for ( $i = 0; $i <= $threshold + 1; $i++ ) {
			$row[$i] = 1;
		}

		for ( $i = 0; $i < 256; $i++ ) {
			$patternMask[$i] = 0;
		}

		for ( $i = 0; $i < $needleLen; ++$i ) {
			$patternMask[ord($needle[$i])] |= 1 << $i;
		}

		for ( $i = 0; $i < $haystackLen; $i++ ) {
			$oldCol     = 0;
			$nextOldCol = 0;

			echo "${i}", "\n";

			for ( $d = 0; $d <= $threshold; ++$d ) {
				$replace = ($oldCol | ($row[$d] & $patternMask[ord($haystack[$i])])) << 1;
				$insert  = $oldCol | (($row[$d] & $patternMask[ord($haystack[$i])]) << 1);
				$delete  = ($nextOldCol | ($row[$d] & $patternMask[ord($haystack[$i])])) << 1;

				$oldCol     = $row[$d];
				$row[$d]    = $replace | $insert | $delete | 1;
				$nextOldCol = $row[$d];
			}

			if ( 0 < ($row[$threshold] & (1 << $needleLen)) ) {
				if ( $firstMatched === -1 || $i - $firstMatched > $needleLen ) {

					$startPos = max(0, $i - $needleLen + 1);
					$endPos   = min($i + 1, $haystackLen);

					echo "${startPos}:${endPos}: ";
					echo substr($haystack, $startPos, $startPos === 0 ? $endPos : $haystackLen - $endPos);
					echo "\n";

					$firstMatched = $i;
					$indexes[]    = $firstMatched - $needleLen + 1;
				}
			}
		}

		return new \Dana\Bitap\BitapResult($needle, $haystack, $indexes);
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
	 * @param float|int $threshold
	 *   (optional) The ratio of erroneous $needle characters to be accepted for
	 *   fuzzy matching.
	 *
	 * @return array
	 *   Zero or more elements from $haystack. The original keys of any matching
	 *   elements will be preserved.
	 */
	public static function bitapGrep($needle, array $haystack, $threshold = 0.25) {
		$results = [];

		foreach ( $haystack as $k => $v ) {
			if ( static::bitapMatch($needle, $v, $threshold)->match ) {
				$results[$k] = $v;
			}
		}

		return $results;
	}
}

