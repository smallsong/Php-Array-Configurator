<?php

namespace PhpArrayConfigurator
{
	/**
	 * Active Object Implementation of a php array (config) file
	 */
	class ConfigFile
	{
		protected $configArray = null;
		protected $currentFilePath = null;

		/**
		 * @param string $filePath Specify filename to automatically try to open and read the file on object construction
		 */
		public function __construct($filePath = null)
		{
			if ($filePath !== null)
				$this->open ($filePath);
		}

		/**
		 * Read PHP Array File (non-blocking file access)
		 * @param string $filePath
		 * @return boolean True if array was successfully loaded, False if file could not be read or did not return an array
		 */
		public function open($filePath)
		{
			$this->currentFilePath = $filePath;
			if (file_exists($filePath)) {
				$this->configArray = include $filePath;
				return true;
			}

			return false;
		}

		/**
		 *
		 * @return array Content of the open file as a php array,
		 * or FALSE if file has not been successfully loaded before
		 */
		public function getArray()
		{
			if (null !== $this->configArray)
				return $this->configArray;

			return false;
		}

		/**
		 * @param array $array
		 * @return \PhpArrayConfigurator\ConfigFile
		 */
		public function setArray(array $array)
		{
			$this->configArray = $array;
			return $this;
		}

		/**
		 * @param type $saveTo If provided, a new copy will be created and then become the current working copy.
		 * Hint: Developers may want to ensure that no already existing file is overwritten, unless explicitly desired so.
		 * @return bool False, if the updates could not be written.
		 */
		public function save($saveTo = null)
		{
			if ($saveTo === null)
				$saveTo = $this->currentFilePath;

			$saveSuccess = file_put_contents( $saveTo,
					CodeCooking\PhpArrayFile::getFromArray($this->configArray)
			);

			if ($saveSuccess)
				$this->currentFilePath = $saveTo;

			return $saveSuccess;
		}
	}
}