<?php /**
* @category Fuko
* @package Fuko\Source
*
* @author Kaloyan Tsvetkov (KT) <kaloyan@kaloyan.info>
* @link https://github.com/fuko-php/source/
* @license https://opensource.org/licenses/MIT
*/

namespace Fuko\Source;

use InvalidArgumentException;
use RuntimeException;

use function ceil;
use function file_exists;
use function fclose;
use function fgets;
use function fopen;

/**
* Source Code Reader
*
* Use this class to extract source code lines using a code reference (filename + line)
*
* @package Fuko\Source
*/
class Code
{
	/**
	* @var integer default LOCs (lines of code) returned
	* @see \Fuko\Source\Code::getLinesAt()
	*/
	const LOC_DEFAULT = 7;

	/**
	* @var integer max numer of LOCs (lines of code) returned
	* @see \Fuko\Source\Code::getLinesAt()
	*/
	const LOC_MAX = 20;

	/**
	* @var string source filename
	*/
	protected $sourceFilename = '';

	/**
	* Source Code Constructor
	*
	* @param string $filename
	*/
	function __construct(string $filename)
	{
		$this->sourceFilename = $filename;

	}

	/**
	* Get Source Code Lines
	*
	* @param integer $line target line of the reference
	* @param integer $locs how many LOCs (lines of code) to return
	* @return array
	* @throws InvalidArgumentException
	* @throws RuntimeException
	*/
	function getLinesAt(int $line, int $locs = null) : array
	{
		if (!file_exists($this->sourceFilename))
		{
			throw new RuntimeException(
				"Source code file not found: {$this->sourceFilename}",
				20004
			);
		}

		if ($line < 1)
		{
			throw new InvalidArgumentException(
				"The \$line argument must be a positive integer, instead {$line} given",
				20005
			);
		}

		if (null !== $locs)
		{
			if ($locs < 1)
			{
				throw new InvalidArgumentException(
					"The \$locs argument must be a positive integer, instead {$locs} given",
					20006
				);
			}
		}

		// by default show 7 lines, but do not go beyond 20
		//
		$locs = $locs ?? static::LOC_DEFAULT;
		if (static::LOC_MAX < $locs)
		{
			$locs = static::LOC_MAX;
		}

		$before = ceil(($locs-1)/2);
		$after = $locs -1 - $before;

		$from = ($from = $line - $before) > 1 ? $from : 1;
		$to = $line + $after;

		$lines = array();
		$fp = fopen($this->sourceFilename, 'r');

		$atLine = 0;
		while (false !== ($lineCode = fgets($fp)))
		{
			if (++$atLine < $from)
			{
				continue;
			}
			if ($atLine > $to)
			{
				break;
			}

			$lines[ $atLine ] = $lineCode;
		}
		fclose($fp);

		return $lines;
	}
}
