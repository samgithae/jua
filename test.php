<?php
/**
 * Created by PhpStorm.
 * User: hudutech
 * Date: 6/28/17
 * Time: 6:01 PM
 */
echo  __DIR__;
require_once __DIR__.'/vendor/autoload.php';

use \Hudutech\Services\FileUploader;
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $uploader = new FileUploader('image');
    $target_dir = '..//';
    $form_name = 'passport';
    $success = $uploader->uploadFile($target_dir, $form_name);
    if ($success) {
        echo "File UPloaded {$uploader->getFilePath()}";
    } else {
        echo "error occured";
}
}
?>

<html>
<form action="test.php" method="POST" enctype="multipart/form-data">
    <input type="file" name="passport" >
    <input type="submit" name="submit" value="submit">

</form>
</html>
