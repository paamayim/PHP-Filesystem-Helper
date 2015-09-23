# PHP-Filesystem-Helper
A helper class for filesystem operations

This class uses PHP Iterators in order to dynamically and stably provide filesystem operation access.

The following methods are provided:

- ```public static function read($file)```
- ```public static function write($file, $contents, $flag='w+')```
- ```public static function searchR($folder, $pattern=null, $depth=-1, $flags=RecursiveIteratorIterator::SELF_FIRST)```
- ```public static function search($folder, $pattern=null)```
- ```public static function deleteR($folder, $pattern=null, $depth=-1)```
- ```public static function delete($folder_or_file, $pattern=null)- ```
