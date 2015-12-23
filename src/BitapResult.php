<?php

/**
 * This file is part of \Dana\Bitap.
 */

namespace Dana\Bitap;

/**
 * Represents the result of a Bitap match.
 */
class BitapResult {
	/**
	 * @var string|null Original needle value.
	 */
	public $needle = null;
	/**
	 * @var int|null Length of original needle value in bytes.
	 */
	public $needleLength = null;
	/**
	 * @var string|null Original hay-stack value.
	 */
	public $haystack = null;
	/**
	 * @var int|null Length of original hay-stack value.
	 */
	public $haystackLength = null;
	/**
	 * @var array Array of hay-stack indexes associated with matches.
	 */
	public $indexes = [];
	/**
	 * @var bool Whether there was a match.
	 */
	public $match = false;

	/**
	 * Object constructor.
	 *
	 * @param string|null $needle
	 * @param string|null $haystack
	 * @param array       $indexes
	 *
	 * @return self
	 */
	public function __construct($needle = null, $haystack = null, $indexes = []) {
		$this->needle         = $needle;
		$this->needleLength   = strlen($needle);
		$this->haystack       = $haystack;
		$this->haystackLength = strlen($haystack);
		$this->indexes        = $indexes;
		$this->match          = $indexes ? true : false;
	}
}

