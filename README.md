# PHP-Filesystem-Helper
A helper class for filesystem operations

This class uses PHP Iterators in order to dynamically and stably provide filesystem operation access.

## Introduction

I tried to make this as fluid and dynamic as possible. Strangely, I couldn't seem to find any presently existing dynamic classes for file io operations, so I spent a couple hours coding this up. Please DO report possible errors.

I think the most important note is that Iterators do not take up massive amounts of memory like arrays do provided with glob and other methods. This class uses Iterators. Thus, we have speed + scalability.

Some might wonder why I did not implement glob methods. Two very good reasons led me to avoid glob:
1. Glob returns all results in an array, and has a relatively small limit(10,000 results or so).
2. Regex covers what glob provides, + more

That's all. Enjoy.

## Overview

The following methods are provided:

- ```public static function create($folder, $mode=0777, $recursive=true)```
- ```public static function read($file)```
- ```public static function write($file, $contents, $flag='w+')```
- ```public static function searchR($folder, $pattern=null, $depth=-1, $flags=RecursiveIteratorIterator::SELF_FIRST)```
- ```public static function search($folder, $pattern=null)```
- ```public static function deleteR($folder, $pattern=null, $depth=-1)```
- ```public static function delete($folder_or_file, $pattern=null)```

## Installation

The class can be used standalone, however it's recommended to install via Composer:

`composer require iautomation/filesystem-helper`

## Usage

If using Composer, just do something like:
```
use \FilesystemHelper\FilesystemHelper;

include 'path/to/vendor/autoload.php';

FilesystemHelper::deleteR('test', null); // DELETE TEST AND ALL CONTENTS!!
```

Otherwise, simply include the class:
```
use \FilesystemHelper\FilesystemHelper;

include 'path/to/FilesystemHelper.php';

FilesystemHelper::deleteR('test', null); // DELETE TEST AND ALL CONTENTS!!
```



## Examples

```
// create test folder
FilesystemHelper::create('test');

// write to test/test.php
FilesystemHelper::write('test/test.php', 'test123');

// get file contents
echo FilesystemHelper::read('test/a.php');

// get all direct folders and files under test
foreach(FilesystemHelper::search('test') as $file){
	echo $file."\n";
}

// get all folders and files under test recursively
foreach(FilesystemHelper::searchR('test') as $file){
	echo $file."\n";
}

// get all direct files under test with the php extension using regex
foreach(FilesystemHelper::search('test', '/.*.php/') as $file){
	echo $file."\n";
}

// get all recursive files under test with the php extension using regex
foreach(FilesystemHelper::searchR('test', '/.*.php/') as $file){
	echo $file."\n";
}

// get all directories under test
foreach(FilesystemHelper::searchR('test') as $file){
	if($file->isDir())
		echo $file."\n";
}

// get all files under test
foreach(FilesystemHelper::searchR('test') as $file){
	if($file->isFile())
		echo $file."\n";
}

// get all folders and files under test listed "backwards". This is particularly useful when deleting
$iter = FilesystemHelper::searchR('test', null, -1, RecursiveIteratorIterator::CHILD_FIRST);
foreach($iter as $file){
	echo $file."\n";
}

/**
DELETE FUNCTIONS ARE NOT FORGIVING. USE WITH CAUTION
*/

// delete all folders and files under test recursively
FilesystemHelper::deleteR('test', null);

// delete all direct folders and files under test
FilesystemHelper::delete('test', null);

// delete all recursive files under test with the php extension using regex
FilesystemHelper::deleteR('test', '/.*.php/', 1);

// delete the test/test.php file
FilesystemHelper::delete('test/test.php');
```
