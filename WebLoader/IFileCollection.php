<?php



namespace WebLoader;

/**
 * @author Jan Marek
 */
interface IFileCollection
{
	public function getRoot();

	/**
	 * @return array
	 */
	public function getFiles();

	/**
	 * @return array
	 */
	public function getRemoteFiles();

	/**
	 * @return array
	 */
	public function getWatchFiles();
}
