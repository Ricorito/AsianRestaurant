<?php
$HOSTNAME = 'db';
$PORT = 3306;
$USERNAME = 'root';
$PASSWORD = '';
$DATABASE = 'webterv';

$connection = mysqli_connect("$HOSTNAME:$PORT", $USERNAME, $PASSWORD, $DATABASE);

if (!$connection) {
    die(mysqli_error($connection));
}
?>
