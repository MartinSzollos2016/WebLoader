<?php



namespace WebLoader\Filter;

/**
 * Variables filter for WebLoader
 *
 * @author Jan Marek
 * @license MIT
 */
class VariablesFilter
{

	/** @var string */
	private $startVariable = '{{$';

	/** @var string */
	private $endVariable = '}}';

	/** @var array */
	private $variables;


	/**
	 * Construct
	 */
	public function __construct(array $variables = [])
	{
		foreach ($variables as $key => $value) {
			$this->$key = $value;
		}
	}


	/**
	 * Set delimiter
	 *
	 * @return \WebLoader\Filter\VariablesFilter
	 */
	public function setDelimiter($start, $end)
	{
		$this->startVariable = (string) $start;
		$this->endVariable = (string) $end;
		return $this;
	}


	/**
	 * Invoke filter
	 */
	public function __invoke($code)
	{
		$start = $this->startVariable;
		$end = $this->endVariable;

		$variables = array_map(function ($key) use ($start, $end) {
			return $start . $key . $end;
		}, array_keys($this->variables));

		$values = array_values($this->variables);

		return str_replace($variables, $values, $code);
	}


	/**
	 * Magic set variable, do not call directly
	 */
	public function __set($name, $value)
	{
		$this->variables[$name] = (string) $value;
	}


	/**
	 * Magic get variable, do not call directly
	 *
	 * @throws \WebLoader\InvalidArgumentException
	 */
	public function &__get($name)
	{
		if (array_key_exists($name, $this->variables)) {
			return $this->variables[$name];
		} else {
			throw new \WebLoader\InvalidArgumentException("Variable '$name' is not set.");
		}
	}
}
