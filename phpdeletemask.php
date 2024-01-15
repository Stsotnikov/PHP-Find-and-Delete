<?php
$folderName = '/home/u192026/vebauto.ru/www/upload/'; // в какой папке ищем
$fileName   = ".htaccess";   // какой файл интересует

$found = search_file( $folderName, $fileName );

print_r( $found ); //все найденные файлы в массиве

/* Вернет:
Array
(
	[0] => /home/example.com/xmlrpc.php
	[1] => /home/example.com/wp-includes/class-wp-xmlrpc-server.php
	[2] => /home/example.com/wp-includes/wlwmanifest.xml
)
*/

/**
 * Поиск файла по имени во всех папках и подпапках
 * @param  string  $folderName - пусть до папки
 * @param  string  $fileName   - искомый файл
 * @return array   Массив найденных файлов.
 */
function search_file( $folderName, $fileName ){
	$found = array();
	$folderName = rtrim( $folderName, '/' );

	$dir = opendir( $folderName ); // открываем текущую папку

	// перебираем папку, пока есть файлы
	while( ($file = readdir($dir)) !== false ){
		$file_path = "$folderName/$file";

		if( $file == '.' || $file == '..' ) continue;

		// это файл проверяем имя
		if( is_file($file_path) ){
			// если имя файла искомое, то вернем путь до него
			if( false !== strpos($file, $fileName) ) $found[] = $file_path;
		}
		// это папка, то рекурсивно вызываем search_file
		elseif( is_dir($file_path) ){
			$res = search_file( $file_path, $fileName );
			$found = array_merge( $found, $res );

			  chmod($file_path.'/'.$fileName, 0777);

			//unlink( $file_path.'/'.$fileName ); // непосредственно удаление найденного файла
		}

	}

	closedir($dir); // закрываем папку

	return $found;
}
?>
