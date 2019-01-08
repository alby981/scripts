<?php
$dir = "finalCss";
if (!file_exists($dir)) {
    if(!mkdir($dir, 0777, true)) {
		die("Warning! You don't have permission to create the $dir folder");
	}
}
if (!file_put_contents("$dir/test.save","saved")) {
	die("Warning! You can't save the final css to the folder {$dir}. Check folder permission");
} else {
	unlink("$dir/test.save");
}


include_once "grab.php";
$html = file_get_contents("https://ziobelo.com/");
$contents = getContents($html,"<link rel='stylesheet'",">");
if (empty($contents)) {
	$contents = getContents($html,'<link rel="stylesheet"',">");
}
$final = '';
$save = false;
foreach ($contents as $css){
	$filename = getContent($css,"href='","'");
	if (!empty($filename)) {
		if (substr($filename,0,5) == 'http:' || substr($filename,0,6) == 'https:') {
			$filename = str_replace("href='","",$filename);
			$final.= "\n/* File $filename */\n";
			$final.= file_get_contents($filename);
			$final.= "\n\n";
			$save = true;
		}
	}
}
if ($save) {
	if (!file_put_contents("$dir/final.css",$final)) {
		die("Warning! You can't save the final css to the folder {$dir}. Check folder permission");
	}
}
