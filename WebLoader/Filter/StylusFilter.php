<?php



namespace WebLoader\Filter;

use WebLoader\Compiler;

/**
 * Stylus filter
 *
 * @author Patrik Votoček
 * @license MIT
 */
class StylusFilter
{

	/** @var bool */
	public $compress = false;

	/** @var bool */
	public $includeCss = false;

	/** @var string */
	private $bin;


	public function __construct($bin = 'stylus')
	{
		$this->bin = $bin;
	}


	/**
	 * Invoke filter
	 */
	public function __invoke($code, Compiler $loader, $file = null)
	{
		if (pathinfo($file, PATHINFO_EXTENSION) === 'styl') {
			$path =
			$cmd = $this->bin . ($this->compress ? ' -c' : '') . ($this->includeCss ? ' --include-css' : '') . ' -I ' . pathinfo($file, PATHINFO_DIRNAME);
			try {
				$code = Process::run($cmd, $code);
			} catch (\RuntimeException $e) {
				throw new \WebLoader\WebLoaderException('Stylus Filter Error', 0, $e);
			}
		}

		return $code;
	}
}
