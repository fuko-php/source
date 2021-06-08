<?php

namespace Fuko\Source\Tests;

use Fuko\Source\Code;
use PHPUnit\Framework\TestCase;

use function file;

class CodeTest extends TestCase
{
	/**
	* @covers Fuko\Source\Code::getLinesAt()
	* @expectedException RuntimeException
	*/
	function testMissingFile()
	{
		$source = new Code('/i/am/not/here');
		$source->getLinesAt(123);
	}

	/**
	* @covers Fuko\Source\Code::getLinesAt()
	* @expectedException InvalidArgumentException
	*/
	function testNegativeSourceLine()
	{
		$source = new Code(__FILE__);
		$source->getLinesAt(-2);
	}

	/**
	* @covers Fuko\Source\Code::getLinesAt()
	* @expectedException InvalidArgumentException
	*/
	function testZeroSourceLine()
	{
		$source = new Code(__FILE__);
		$source->getLinesAt(0);
	}

	/**
	* @covers Fuko\Source\Code::getLinesAt()
	* @expectedException InvalidArgumentException
	*/
	function testNegativeLOCs()
	{
		$source = new Code(__FILE__);
		$source->getLinesAt(2, -2);
	}

	/**
	* @covers Fuko\Source\Code::getLinesAt()
	* @expectedException InvalidArgumentException
	*/
	function testZeroLOCs()
	{
		$source = new Code(__FILE__);
		$source->getLinesAt(1, 0);
	}

	/**
	* @covers Fuko\Source\Code::getLinesAt()
	*/
	function testGetLinesAt()
	{
		$source = new Code($composer = __DIR__ . '/../composer.json');
		$lines = file($composer);

		$this->assertEquals(
			$source->getLinesAt(1, 1),
			[ 1 => $lines[0] ]
			);

		$this->assertEquals(
			$source->getLinesAt(4), [
			1 => $lines[0],
			2 => $lines[1],
			3 => $lines[2],
			4 => $lines[3],
			5 => $lines[4],
			6 => $lines[5],
			7 => $lines[6],
			]);

		$this->assertEquals(
			$source->getLinesAt(4, 3), [
			3 => $lines[2],
			4 => $lines[3],
			5 => $lines[4],
			]);
	}
}
