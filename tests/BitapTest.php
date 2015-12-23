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
	 * Tests bitapMatch() method with invalid thresholds.
	 *
	 * @return void
	 */
	public function testBitapMatchWithInvalidThreshold() {
		try {
			$res1 = \Dana\Bitap\Bitap::bitapMatch('a', 'abcd', -1);
			$this->assertTrue(false);
		} catch ( \InvalidArgumentException $e ) {
			$this->assertTrue(true);
		}
		try {
			$res1 = \Dana\Bitap\Bitap::bitapMatch('a', 'abcd', 2);
			$this->assertTrue(false);
		} catch ( \InvalidArgumentException $e ) {
			$this->assertTrue(true);
		}
	}

	/**
	 * Tests bitapMatch() method with empty needles.
	 *
	 * @return void
	 */
	public function testBitapMatchWithEmptyNeedle() {
		$res1 = \Dana\Bitap\Bitap::bitapMatch('', 'abcd', 0.00);
		$res2 = \Dana\Bitap\Bitap::bitapMatch('', 'abcd', 0.25);
		$res3 = \Dana\Bitap\Bitap::bitapMatch('', 'abcd', 1.00);

		$this->assertSame([0], $res1->indexes);
		$this->assertSame([0], $res2->indexes);
		$this->assertSame([0], $res3->indexes);
	}

	/**
	 * Tests bitapMatch() method with empty hay stacks.
	 *
	 * @return void
	 */
	public function testBitapMatchWithEmptyHaystack() {
		$res1 = \Dana\Bitap\Bitap::bitapMatch('a', '', 0.00);
		$res2 = \Dana\Bitap\Bitap::bitapMatch('a', '', 0.25);
		$res3 = \Dana\Bitap\Bitap::bitapMatch('a', '', 1.00);

		$this->assertSame([], $res1->indexes);
		$this->assertSame([], $res2->indexes);
		$this->assertSame([], $res3->indexes);
	}

	/**
	 * Tests bitapMatch() method with single non-equal characters for needle and
	 * hay stack.
	 *
	 * @return void
	 */
	public function testBitapMatchWithSingleDifferentCharacter() {
		$res1 = \Dana\Bitap\Bitap::bitapMatch('a', 'x', 0.00);
		$res2 = \Dana\Bitap\Bitap::bitapMatch('a', 'x', 0.25);
		$res3 = \Dana\Bitap\Bitap::bitapMatch('a', 'x', 1.00);

		$this->assertSame([],  $res1->indexes);
		$this->assertSame([],  $res2->indexes);
		$this->assertSame([0], $res3->indexes);
	}

	/**
	 * Tests bitapMatch() method with single equal characters for needle and
	 * hay stack.
	 *
	 * @return void
	 */
	public function testBitapMatchWithSingleEqualCharacter() {
		$res1 = \Dana\Bitap\Bitap::bitapMatch('a', 'a', 0.00);
		$res2 = \Dana\Bitap\Bitap::bitapMatch('a', 'a', 0.25);
		$res3 = \Dana\Bitap\Bitap::bitapMatch('a', 'a', 1.00);

		$this->assertSame([0], $res1->indexes);
		$this->assertSame([0], $res2->indexes);
		$this->assertSame([0], $res3->indexes);
	}

	/**
	 * Tests bitapMatch() method with one single-character instance of the
	 * needle in the hay stack.
	 *
	 * @return void
	 */
	public function testBitapMatchWithOneSingleCharInstance() {
		$res1 = \Dana\Bitap\Bitap::bitapMatch('a', 'abcd', 0.00);
		$res2 = \Dana\Bitap\Bitap::bitapMatch('a', 'abcd', 0.25);
		$res3 = \Dana\Bitap\Bitap::bitapMatch('a', 'abcd', 1.00);

		$this->assertSame([0],          $res1->indexes);
		$this->assertSame([0],          $res2->indexes);
		//$this->assertSame([0, 1, 2, 3], $res3->indexes);
	}

	/**
	 * Tests bitapMatch() method with two single-character instances of the
	 * needle in the hay stack.
	 *
	 * @return void
	 */
	public function testBitapMatchWithTwoSingleCharInstances() {
		$res1 = \Dana\Bitap\Bitap::bitapMatch('a', 'abca', 0.00);
		$res2 = \Dana\Bitap\Bitap::bitapMatch('a', 'abca', 0.25);
		$res3 = \Dana\Bitap\Bitap::bitapMatch('a', 'abca', 1.00);

		$this->assertSame([0, 3],       $res1->indexes);
		$this->assertSame([0, 3],       $res2->indexes);
		//$this->assertSame([0, 1, 2, 3], $res3->indexes);
	}

	/**
	 * Tests bitapMatch() method with leading text in hay stack.
	 *
	 * @return void
	 */
	public function testBitapMatchWithLeadingText() {
		$res1 = \Dana\Bitap\Bitap::bitapMatch('a', 'xxx abcd', 0.00);
		$res2 = \Dana\Bitap\Bitap::bitapMatch('a', 'xxx abcd', 0.25);
		$res3 = \Dana\Bitap\Bitap::bitapMatch('a', 'xxx abcd', 1.00);
		$res4 = \Dana\Bitap\Bitap::bitapMatch('a', 'xxx abca', 0.00);
		$res5 = \Dana\Bitap\Bitap::bitapMatch('a', 'xxx abca', 0.25);
		$res6 = \Dana\Bitap\Bitap::bitapMatch('a', 'xxx abca', 1.00);

		$this->assertSame([4],          $res1->indexes);
		$this->assertSame([4],          $res2->indexes);
		//$this->assertSame([0, 1, 2, 3], $res3->indexes);
		$this->assertSame([4, 7],       $res4->indexes);
		$this->assertSame([4, 7],       $res5->indexes);
		//$this->assertSame([4, 7],       $res6->indexes);
	}
}

