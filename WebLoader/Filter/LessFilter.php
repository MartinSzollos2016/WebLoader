<?php



namespace WebLoader\Filter;

use lessc;
use WebLoader\Compiler;

/**
 * Less CSS filter
 *
 * @author Jan Marek
 * @license MIT
 */
class LessFilter
{
	private $lc;


	public function __construct($lc = null)
	{
		$this->lc = $lc;
	}


	private function getLessC()
	{
		// lazy loading
		if (empty($this->lc)) {
			$this->lc = new lessc();
		}

		return clone $this->lc;
	}


	/**
	 * Invoke filter
	 */
	public function __invoke($code, Compiler $loader, $file)
	{
		if (pathinfo($file, PATHINFO_EXTENSION) === 'less') {
			$lessc = $this->getLessC();
			$lessc->importDir = pathinfo($file, PATHINFO_DIRNAME) . '/';
			return $lessc->compile($code);
		}

		return $code;
	}
}
