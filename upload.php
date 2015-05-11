<?php
$ds = DIRECTORY_SEPARATOR; 
$storeFolder = 'uploads';
if (!empty($_FILES)) {
    $tempFile = $_FILES['file']['tmp_name'];
    $targetPath = dirname( __FILE__ ) . $ds. $storeFolder . $ds; 
    $targetFile =  $targetPath. $_FILES['file']['name'];
    move_uploaded_file($tempFile,$targetFile);
	//$targetFile =  "/home/ubuntosh/public_html/bran2pdf/uploads/test.pdf";
	$sThumbPath = substr($targetFile, 0, -3)."jpg";
	exec("convert -density 100 -thumbnail 600  -trim \"{$targetFile}\"[0] -background \"#FFFFFF\" quality 85 -sharpen 0x1.0 \"{$sThumbPath}\"");
}

?>
