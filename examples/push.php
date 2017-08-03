<?php
$data = file_get_contents('php://input');
file_put_contents('log', $data."\n", FILE_APPEND);
print_r(json_decode($data, true));
?>
