<?php file_put_contents("config/app.php", str_replace("\'timezone\' => \'UTC\'", "\'timezone\' => \'Asia/Makassar\'", file_get_contents("config/app.php"))); ?>
