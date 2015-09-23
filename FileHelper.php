<?php

class FileHelper {
	public static function create($folder, $mode=0777, $recursive=true){
		mkdir($folder, $mode, $recursive);
	}
	public static function read($file){
		if(($handle = fopen($file, 'r')) == false)return false;
		if(($contents = fread($handle, filesize($file))) == false)return false;
		fclose($handle);
		return $contents;
	}
	public static function write($file, $contents, $flag='w+'){
		if(($handle = fopen($file, $flag)) == false)return false;
		if(fwrite($handle, $contents) == false)return false;
		return true;
	}
	public static function searchR($folder, $pattern=null, $depth=-1, $flags=RecursiveIteratorIterator::SELF_FIRST){
		$dir_iter = new RecursiveDirectoryIterator($folder, FilesystemIterator::SKIP_DOTS);
		$flat_iter = new RecursiveIteratorIterator($dir_iter, $flags);
		$flat_iter->setMaxDepth($depth);
		if(is_null($pattern))return $flat_iter;
		else return new RegexIterator($flat_iter, $pattern);
	}
	public static function search($folder, $pattern=null){
		return self::searchR($folder, $pattern, 0);
	}
	public static function deleteR($folder, $pattern=null, $depth=-1){
		foreach(self::searchR($folder, $pattern, $depth, RecursiveIteratorIterator::CHILD_FIRST) as $file){
			if($file->isFile())unlink($file);
			elseif($file->isDir())@rmdir($file);
		}
	}
	public static function delete($folder_or_file, $pattern=null){
		if(is_file($folder_or_file))unlink($folder_or_file);
		else self::deleteR($folder_or_file, $pattern, 0);
	}
}

?>
