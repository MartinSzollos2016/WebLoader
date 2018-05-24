<?php



namespace WebLoader;

/**
 * FileCollection
 *
 * @author Jan Marek
 */
class FileCollection implements \WebLoader\IFileCollection
{

	/** @var string */
	private $root;

	/** @var array */
	private $files = [];

	/** @var array */
	private $watchFiles = [];

	/** @var array */
	private $remoteFiles = [];


	/**
	 * @param string|null $root files root for relative paths
	 */
	public function __construct($root = null)
	{
		$this->root = $root;
	}


	/**
	 * Get file list
	 */
	public function getFiles()
	{
		return array_values($this->files);
	}


	/**
	 * Make path absolute
	 *
	 * @param $path string
	 * @throws \WebLoader\FileNotFoundException
	 */
	public function cannonicalizePath($path)
	{
		$rel = Path::normalize($this->root . '/' . $path);
		if (file_exists($rel)) {
			return $rel;
		}

		$abs = Path::normalize($path);
		if (file_exists($abs)) {
			return $abs;
		}

		throw new \WebLoader\FileNotFoundException("File '$path' does not exist.");
	}


	/**
	 * Add file
	 * @param $file string filename
	 */
	public function addFile($file)
	{
		$file = $this->cannonicalizePath((string) $file);

		if (in_array($file, $this->files, true)) {
			return;
		}

		$this->files[] = $file;
	}


	/**
	 * Add files
	 * @param array|\Traversable $files array list of files
	 */
	public function addFiles($files)
	{
		foreach ($files as $file) {
			$this->addFile($file);
		}
	}


	/**
	 * Remove file
	 * @param $file string filename
	 */
	public function removeFile($file)
	{
		$this->removeFiles([$file]);
	}


	/**
	 * Remove files
	 * @param array $files list of files
	 */
	public function removeFiles(array $files)
	{
		$files = array_map([$this, 'cannonicalizePath'], $files);
		$this->files = array_diff($this->files, $files);
	}


	/**
	 * Add file in remote repository (for example Google CDN).
	 * @param string $file URL address
	 */
	public function addRemoteFile(string $file)
	{
		if (in_array($file, $this->remoteFiles, true)) {
			return;
		}

		$this->remoteFiles[] = $file;
	}


	/**
	 * Add multiple remote files
	 * @param array|\Traversable $files
	 */
	public function addRemoteFiles($files)
	{
		foreach ($files as $file) {
			$this->addRemoteFile($file);
		}
	}


	/**
	 * Remove all files
	 */
	public function clear()
	{
		$this->files = [];
		$this->watchFiles = [];
		$this->remoteFiles = [];
	}


	public function getRemoteFiles()
	{
		return $this->remoteFiles;
	}


	public function getRoot()
	{
		return $this->root;
	}


	/**
	 * Add watch file
	 * @param $file string filename
	 */
	public function addWatchFile($file)
	{
		$file = $this->cannonicalizePath((string) $file);

		if (in_array($file, $this->watchFiles, true)) {
			return;
		}

		$this->watchFiles[] = $file;
	}


	/**
	 * Add watch files
	 * @param array|\Traversable $files array list of files
	 */
	public function addWatchFiles($files)
	{
		foreach ($files as $file) {
			$this->addWatchFile($file);
		}
	}


	/**
	 * Get watch file list
	 */
	public function getWatchFiles()
	{
		return array_values($this->watchFiles);
	}
}
