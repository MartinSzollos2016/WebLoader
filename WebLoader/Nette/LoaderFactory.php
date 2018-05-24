<?php



namespace WebLoader\Nette;

use Nette\DI\Container;
use Nette\Http\IRequest;

class LoaderFactory
{

	/** @var \Nette\Http\IRequest */
	private $httpRequest;

	/** @var \Nette\DI\Container */
	private $serviceLocator;

	/** @var array */
	private $tempPaths;

	/** @var string */
	private $extensionName;


	public function __construct(array $tempPaths, $extensionName, IRequest $httpRequest, Container $serviceLocator)
	{
		$this->httpRequest = $httpRequest;
		$this->serviceLocator = $serviceLocator;
		$this->tempPaths = $tempPaths;
		$this->extensionName = $extensionName;
	}


	public function createCssLoader($name, $appendLastModified = false)
	{
		/** @var \WebLoader\Compiler $compiler */
		$compiler = $this->serviceLocator->getService($this->extensionName . '.css' . ucfirst($name) . 'Compiler');
		return new CssLoader($compiler, $this->formatTempPath($name, $compiler->isAbsoluteUrl()), $appendLastModified);
	}


	public function createJavaScriptLoader($name, $appendLastModified = false, $nonce = null)
	{
		/** @var \WebLoader\Compiler $compiler */
		$compiler = $this->serviceLocator->getService($this->extensionName . '.js' . ucfirst($name) . 'Compiler');
		if ($nonce) {
			$compiler->setNonce($nonce);
		}
		return new JavaScriptLoader($compiler, $this->formatTempPath($name, $compiler->isAbsoluteUrl()), $appendLastModified);
	}


	private function formatTempPath($name, $absoluteUrl = false)
	{
		$lName = strtolower($name);
		$tempPath = isset($this->tempPaths[$lName]) ? $this->tempPaths[$lName] : Extension::DEFAULT_TEMP_PATH;
		$method = $absoluteUrl ? 'getBaseUrl' : 'getBasePath';
		return rtrim($this->httpRequest->getUrl()->{$method}(), '/') . '/' . $tempPath;
	}
}
