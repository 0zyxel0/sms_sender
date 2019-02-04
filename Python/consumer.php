<?php  


$command = escapeshellcmd('CreateId.py');
$output = exec($command);

echo $output;


?>