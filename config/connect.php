<?php

$conn = mysqli_connect('localhost', 'root', '', 'leopi', 4306); //hostname, username, pwd, db_name

if (!$conn) {
    die("Connection error: " . mysqli_connect_error());
}
