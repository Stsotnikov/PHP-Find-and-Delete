<?php
$folderName = '/home/u192026/vebauto.ru/www/upload/'; // путь до папки
$fileName   = ".htaccess";   // искомое имя файла
$found = search_file( $folderName, $fileName );
print_r( $found ); //вывод всех найденных файлов в массиве

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

			//chmod($file_path.'/'.$fileName, 0777); //смена прав на искомые файлы
			//unlink( $file_path.'/'.$fileName ); // непосредственно удаление найденного файла
		}
	}
	closedir($dir); // закрываем папку
	return $found;
}
?>
