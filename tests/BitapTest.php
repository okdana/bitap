<?php

/**
 * This file is part of \Dana\Bitap.
 */

namespace Dana\Test\Bitap;

/**
 * Provides tests for \Dana\Bitap\Bitap.
 */
class BitapTest extends \PHPUnit_Framework_TestCase {
	/**
	 * Tests bitapMatch() method with empty needles.
	 *
	 * @return void
	 */
	public function testBitapMatchWithEmptyNeedle() {
		$res1 = \Dana\Bitap\Bitap::bitapMatch('', 'abcd', 0);
		$res2 = \Dana\Bitap\Bitap::bitapMatch('', 'abcd', 1);
		$res3 = \Dana\Bitap\Bitap::bitapMatch('', 'abcd', 4);

		$this->assertTrue($res1);
		$this->assertTrue($res2);
		$this->assertTrue($res3);
	}

	/**
	 * Tests bitapMatch() method with empty hay stacks.
	 *
	 * @return void
	 */
	public function testBitapMatchWithEmptyHaystack() {
		$res1 = \Dana\Bitap\Bitap::bitapMatch('a', '', 0);
		$res2 = \Dana\Bitap\Bitap::bitapMatch('a', '', 1);

		$this->assertFalse($res1);
		$this->assertFalse($res2);
	}

	/**
	 * Tests bitapMatch() method with single-character exact matches.
	 *
	 * @return void
	 */
	public function testBitapMatchWithSingleCharExactMatch() {
		$res1 = \Dana\Bitap\Bitap::bitapMatch('a', 'a', 0);
		$res2 = \Dana\Bitap\Bitap::bitapMatch('a', 'a', 1);

		$this->assertTrue($res1);
		$this->assertTrue($res2);
	}

	/**
	 * Tests bitapMatch() method with multiple-character exact matches.
	 *
	 * @return void
	 */
	public function testBitapMatchWithMultipleCharExactMatch() {
		$res1 = \Dana\Bitap\Bitap::bitapMatch('abcd', 'abcd', 0);
		$res2 = \Dana\Bitap\Bitap::bitapMatch('abcd', 'abcd', 1);
		$res3 = \Dana\Bitap\Bitap::bitapMatch('abcd', 'abcd', 4);

		$this->assertTrue($res1);
		$this->assertTrue($res2);
		$this->assertTrue($res3);
	}

	/**
	 * Tests bitapMatch() method with single-character non-matches.
	 *
	 * @return void
	 */
	public function testBitapMatchWithSingleCharNonMatch() {
		$res1 = \Dana\Bitap\Bitap::bitapMatch('a', 'x', 0);
		$res2 = \Dana\Bitap\Bitap::bitapMatch('a', 'x', 1);

		$this->assertFalse($res1);
		$this->assertTrue($res2);
	}

	/**
	 * Tests bitapMatch() method with multiple-character non-matches.
	 *
	 * @return void
	 */
	public function testBitapMatchWithMultipleCharNonMatch() {
		$res1 = \Dana\Bitap\Bitap::bitapMatch('abc', 'xyz', 0);
		$res2 = \Dana\Bitap\Bitap::bitapMatch('abc', 'xyz', 1);
		$res3 = \Dana\Bitap\Bitap::bitapMatch('abc', 'xyz', 3);

		$this->assertFalse($res1);
		$this->assertFalse($res2);
		$this->assertTrue($res3);
	}

	/**
	 * Tests bitapMatch() method with needle longer than hay stack.
	 *
	 * @return void
	 */
	public function testBitapMatchWithNeedleLongerThanHaystack() {
		$res1 = \Dana\Bitap\Bitap::bitapMatch('abcd', 'abc', 0);
		$res2 = \Dana\Bitap\Bitap::bitapMatch('abcd', 'abc', 1);
		$res3 = \Dana\Bitap\Bitap::bitapMatch('abcd', 'xyz', 0);
		$res4 = \Dana\Bitap\Bitap::bitapMatch('abcd', 'xyz', 1);
		$res5 = \Dana\Bitap\Bitap::bitapMatch('abcd', 'xyz', 4);

		$this->assertFalse($res1);
		$this->assertTrue($res2);
		$this->assertFalse($res3);
		$this->assertFalse($res4);
		$this->assertTrue($res5);
	}

	/**
	 * Tests bitapMatch() method with one single-character instance of the
	 * needle in the hay stack.
	 *
	 * @return void
	 */
	public function testBitapMatchWithOneSingleCharInstance() {
		// Beginning
		$res1 = \Dana\Bitap\Bitap::bitapMatch('a', 'abcd', 0);
		$res2 = \Dana\Bitap\Bitap::bitapMatch('a', 'abcd', 1);
		$res3 = \Dana\Bitap\Bitap::bitapMatch('a', 'abcd', 4);
		// Middle
		$res4 = \Dana\Bitap\Bitap::bitapMatch('a', 'bacd', 0);
		$res5 = \Dana\Bitap\Bitap::bitapMatch('a', 'bacd', 1);
		$res6 = \Dana\Bitap\Bitap::bitapMatch('a', 'bacd', 4);
		// End
		$res7 = \Dana\Bitap\Bitap::bitapMatch('a', 'dbca', 0);
		$res8 = \Dana\Bitap\Bitap::bitapMatch('a', 'dbca', 1);
		$res9 = \Dana\Bitap\Bitap::bitapMatch('a', 'dbca', 4);

		$this->assertTrue($res1);
		$this->assertTrue($res2);
		$this->assertTrue($res3);
		$this->assertTrue($res4);
		$this->assertTrue($res5);
		$this->assertTrue($res6);
		$this->assertTrue($res7);
		$this->assertTrue($res8);
		$this->assertTrue($res9);
	}

	/**
	 * Tests bitapMatch() method with two single-character instances of the
	 * needle in the hay stack.
	 *
	 * @return void
	 */
	public function testBitapMatchWithTwoSingleCharInstances() {
		// Beginning
		$res1 = \Dana\Bitap\Bitap::bitapMatch('a', 'aabc', 0);
		$res2 = \Dana\Bitap\Bitap::bitapMatch('a', 'aabc', 1);
		$res3 = \Dana\Bitap\Bitap::bitapMatch('a', 'aabc', 4);
		// Middle
		$res4 = \Dana\Bitap\Bitap::bitapMatch('a', 'baac', 0);
		$res5 = \Dana\Bitap\Bitap::bitapMatch('a', 'baac', 1);
		$res6 = \Dana\Bitap\Bitap::bitapMatch('a', 'baac', 4);
		// End
		$res7 = \Dana\Bitap\Bitap::bitapMatch('a', 'bcaa', 0);
		$res8 = \Dana\Bitap\Bitap::bitapMatch('a', 'bcaa', 1);
		$res9 = \Dana\Bitap\Bitap::bitapMatch('a', 'bcaa', 4);

		$this->assertTrue($res1);
		$this->assertTrue($res2);
		$this->assertTrue($res3);
		$this->assertTrue($res4);
		$this->assertTrue($res5);
		$this->assertTrue($res6);
		$this->assertTrue($res7);
		$this->assertTrue($res8);
		$this->assertTrue($res9);
	}

	/**
	 * Tests bitapMatch() method with one single-character instance of the
	 * needle in the hay stack.
	 *
	 * @return void
	 */
	public function testBitapMatchWithOneMultiCharInstance() {
		// Beginning
		$res1 = \Dana\Bitap\Bitap::bitapMatch('aa', 'aabcd', 0);
		$res2 = \Dana\Bitap\Bitap::bitapMatch('aa', 'aabcd', 1);
		$res3 = \Dana\Bitap\Bitap::bitapMatch('aa', 'aabcd', 4);
		// Middle
		$res4 = \Dana\Bitap\Bitap::bitapMatch('aa', 'baacd', 0);
		$res5 = \Dana\Bitap\Bitap::bitapMatch('aa', 'baacd', 1);
		$res6 = \Dana\Bitap\Bitap::bitapMatch('aa', 'baacd', 4);
		// End
		$res7 = \Dana\Bitap\Bitap::bitapMatch('aa', 'dbcaa', 0);
		$res8 = \Dana\Bitap\Bitap::bitapMatch('aa', 'dbcaa', 1);
		$res9 = \Dana\Bitap\Bitap::bitapMatch('aa', 'dbcaa', 4);

		$this->assertTrue($res1);
		$this->assertTrue($res2);
		$this->assertTrue($res3);
		$this->assertTrue($res4);
		$this->assertTrue($res5);
		$this->assertTrue($res6);
		$this->assertTrue($res7);
		$this->assertTrue($res8);
		$this->assertTrue($res9);
	}

	/**
	 * Tests bitapMatch() method with two single-character instances of the
	 * needle in the hay stack.
	 *
	 * @return void
	 */
	public function testBitapMatchWithTwoMultiCharInstances() {
		// Beginning
		$res1 = \Dana\Bitap\Bitap::bitapMatch('aa', 'aaaabc', 0);
		$res2 = \Dana\Bitap\Bitap::bitapMatch('aa', 'aaaabc', 1);
		$res3 = \Dana\Bitap\Bitap::bitapMatch('aa', 'aaaabc', 4);
		// Middle
		$res4 = \Dana\Bitap\Bitap::bitapMatch('aa', 'baacaad', 0);
		$res5 = \Dana\Bitap\Bitap::bitapMatch('aa', 'baacaad', 1);
		$res6 = \Dana\Bitap\Bitap::bitapMatch('aa', 'baacaad', 4);
		// End
		$res7 = \Dana\Bitap\Bitap::bitapMatch('aa', 'baacaa', 0);
		$res8 = \Dana\Bitap\Bitap::bitapMatch('aa', 'baacaa', 1);
		$res9 = \Dana\Bitap\Bitap::bitapMatch('aa', 'baacaa', 4);

		$this->assertTrue($res1);
		$this->assertTrue($res2);
		$this->assertTrue($res3);
		$this->assertTrue($res4);
		$this->assertTrue($res5);
		$this->assertTrue($res6);
		$this->assertTrue($res7);
		$this->assertTrue($res8);
		$this->assertTrue($res9);
	}

	/**
	 * Tests bitapMatch() method with two single-character instances of the
	 * needle in the hay stack.
	 *
	 * @return void
	 */
	public function testBitapMatchWithApproximation() {
		$res1 = \Dana\Bitap\Bitap::bitapMatch('axc', 'abcd', 0);
		$res2 = \Dana\Bitap\Bitap::bitapMatch('axc', 'abcd', 1);
		$res3 = \Dana\Bitap\Bitap::bitapMatch('axc', 'abcd', 3);

		$res4 = \Dana\Bitap\Bitap::bitapMatch('axc', 'dabce', 0);
		$res5 = \Dana\Bitap\Bitap::bitapMatch('axc', 'dabce', 1);
		$res6 = \Dana\Bitap\Bitap::bitapMatch('axc', 'dabce', 3);

		$res7 = \Dana\Bitap\Bitap::bitapMatch('axc', 'dabc', 0);
		$res8 = \Dana\Bitap\Bitap::bitapMatch('axc', 'dabc', 1);
		$res9 = \Dana\Bitap\Bitap::bitapMatch('axc', 'dabc', 3);

		$this->assertFalse($res1);
		$this->assertTrue($res2);
		$this->assertTrue($res3);

		$this->assertFalse($res4);
		$this->assertTrue($res5);
		$this->assertTrue($res6);

		$this->assertFalse($res7);
		$this->assertTrue($res8);
		$this->assertTrue($res9);
	}

	/**
	 * Tests bitapGrep() method.
	 *
	 * @return void
	 */
	public function testBitapGrep() {
		$array = [
			'xyz',
			'abcd',
			'xyz a xyz',
			'zyx',
		];
		$res1 = \Dana\Bitap\Bitap::bitapGrep('a', $array);
		$res2 = \Dana\Bitap\Bitap::bitapGrep('x', $array);

		$this->assertSame(preg_grep('/a/', $array), $res1);
		$this->assertSame(preg_grep('/x/', $array), $res2);
	}
}

