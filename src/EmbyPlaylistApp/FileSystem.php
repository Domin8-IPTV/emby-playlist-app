<?php

namespace EmbyPlaylistApp;

class FileSystem {
	public static function getDirectoryContents($root) {
		$contents = array_diff(scandir($root), array('..', '.'));

		$files = array();
		$dirs = array();
		foreach($contents as $path){
			if(is_dir(utf8_decode($root).DIRECTORY_SEPARATOR.$path)){
				$dirs[] = $path;
				//$dirs[] = utf8_encode($path);
			}else{
				/*
				 * On Windows, non-ASCII strings are being detected as 'UTF-8'
				 * not "Windows-1252"...
				 * mb_detect_encoding($path);
				 */
				$files[] = $path;
				//$files[] = utf8_encode($path);
				//$files[] = mb_convert_encoding($path, "Windows-1252", "UTF-8");
			}
		}

		return ['files' => $files, 'directories' => $dirs];
	}	
	
	/**
	 * Gets all filenames in a directory (recursively) that match the file extension
	 * @param string $root Absolute path to begin search
	 * @param string $extension File extension to search for, do not include precedeing period
	 */
	public static function getFilesRecursive($root, $extension) {
		return array_values(
			array_filter(
				array_diff(
					self::recursiveSearch( $root, '/.*\.' . $extension . '/'),	
					['.', '..']
				),
				function($filename) {
					return strpos($filename, '.');
				}
			)
		);
	}
	
	/**
	 * Recursively searches a filesystem for files matching a 
	 * Regex pattern
	 * https://stackoverflow.com/a/17161106
	 * @param string Absolute path to begin search
	 * @param string Regex pattern to match against filenames
	 */
	public static function recursiveSearch ($folder, $pattern) {
		$dir = new \RecursiveDirectoryIterator($folder);
		$ite = new \RecursiveIteratorIterator($dir);
		$files = new \RegexIterator($ite, $pattern, \RegexIterator::GET_MATCH);
		$fileList = array();
		foreach($files as $file) {
			$fileList = array_merge($fileList, $file);
		}
		return $fileList;
	}
	
	/**
	 * 
	 * @param string $path Path to file
	 * @param string $ext New extension
	 * @return string
	 */
	public static function replaceExtension($path, $ext){
		$info = pathinfo($path);
		return ($info['dirname'] != '.' ? $info['dirname']. DIRECTORY_SEPARATOR :  '' ).$info['filename'].'.'.$ext;
	}
}
