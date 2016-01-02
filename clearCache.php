<?php

exec("/usr/local/php5.4/bin/php /home/clickandi/www/app/console cache:clear --env=prod");
// $str = __DIR__.'/app/cache/';


// function recursiveDelete($str){
// if(is_file($str)){
//     return @unlink($str);
// }
// elseif(is_dir($str)){
//     $scan = glob(rtrim($str,'/').'/*');
//     foreach($scan as $index=>$path){
//         recursiveDelete($path);
//     }
//     return @rmdir($str);
// }
// }

// recursiveDelete($str);
?>