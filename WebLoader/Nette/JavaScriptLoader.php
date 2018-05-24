<?php



namespace WebLoader\Nette;

use Nette\Utils\Html;

/**
 * JavaScript loader
 *
 * @author Jan Marek
 * @license MIT
 */
class JavaScriptLoader extends \WebLoader\Nette\WebLoader
{

	/**
	 * Get script element
	 */
	public function getElement($source)
	{
		$el = Html::el('script');
		$this->getCompiler()->isAsync() ? $el = $el->addAttributes(['async' => true]) : null;
		$this->getCompiler()->isDefer() ? $el = $el->addAttributes(['defer' => true]) : null;
		($nonce = $this->getCompiler()->getNonce()) ? $el = $el->addAttributes(['nonce' => $nonce]) : null;

		return $el->src($source);
	}
}
