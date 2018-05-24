<?php



namespace WebLoader\Filter;

use WebLoader\Compiler;

/**
 * Coffee script filter
 *
 * @author Patrik Votoček
 * @license MIT
 */
class CoffeeScriptFilter
{

	/** @var bool */
	public $bare = false;

	/** @var \WebLoader\Filter\path to coffee bin */
	private $bin;


	public function __construct($bin = 'coffee')
	{
		$this->bin = $bin;
	}


	/**
	 * Invoke filter
	 */
	public function __invoke($code, Compiler $loader, $file = null)
	{
		if (pathinfo($file, PATHINFO_EXTENSION) === 'coffee') {
			$code = $this->compileCoffee($code);
		}

		return $code;
	}


	public function compileCoffee($source, $bare = null)
	{
		if ($bare === null) {
			$bare = $this->bare;
		}

		$cmd = $this->bin . ' -p -s' . ($bare ? ' -b' : '');

		return Process::run($cmd, $source);
	}
}
