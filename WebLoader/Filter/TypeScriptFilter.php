<?php



namespace WebLoader\Filter;

use WebLoader\Compiler;

/**
 * TypeScript filter
 *
 * @author Jan Tvrdík
 * @license MIT
 */
class TypeScriptFilter
{

	/** @var string */
	private $bin;

	/** @var array */
	private $env;


	public function __construct($bin = 'tsc', array $env = [])
	{
		$this->bin = $bin;
		$this->env = $env + $_ENV;
		unset($this->env['argv'], $this->env['argc']);
	}


	/**
	 * Invoke filter
	 */
	public function __invoke($code, Compiler $compiler, $file = null)
	{
		if (pathinfo($file, PATHINFO_EXTENSION) === 'ts') {
			$out = substr_replace($file, 'js', -2);
			$cmd = sprintf('%s %s --target ES5 --out %s', $this->bin, escapeshellarg($file), escapeshellarg($out));
			Process::run($cmd, null, null, $this->env);
			$code = file_get_contents($out);
		}

		return $code;
	}
}
