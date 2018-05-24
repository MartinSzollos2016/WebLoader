<?php



namespace WebLoader\Filter;

use WebLoader\Compiler;

/**
 * Less CSS filter
 *
 * @author Jan Tvrdík
 * @license MIT
 */
class LessBinFilter
{

	/** @var string */
	private $bin;

	/** @var array */
	private $env;


	public function __construct($bin = 'lessc', array $env = [])
	{
		$this->bin = $bin;
		$this->env = $env + $_ENV;
		unset($this->env['argv'], $this->env['argc']);
	}


	/**
	 * Invoke filter
	 */
	public function __invoke($code, Compiler $loader, $file)
	{
		if (pathinfo($file, PATHINFO_EXTENSION) === 'less') {
			$code = Process::run("{$this->bin} -", $code, dirname($file), $this->env);
		}

		return $code;
	}
}
