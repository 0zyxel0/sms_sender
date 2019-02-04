<?php  


$command = escapeshellcmd('Scan_Insert.py');
$output = exec($command);

echo $output;


?>