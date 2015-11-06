<?php
$str = __DIR__.'/app/cache/';


function recursiveDelete($str){
if(is_file($str)){
    return @unlink($str);
}
elseif(is_dir($str)){
    $scan = glob(rtrim($str,'/').'/*');
    foreach($scan as $index=>$path){
        recursiveDelete($path);
    }
    return @rmdir($str);
}
}

recursiveDelete($str);

//here you can redirect to any page
// echo(__DIR__.'/app/cache/*'.' -> Clear completed'); 
?>