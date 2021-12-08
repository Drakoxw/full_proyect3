<?php
    $mysqli = new mysqli("localhost", "root", "", "aveo_dev");
    $conn = mysqli_connect('localhost','root','','aveo_dev' );
    if (isset($conn)) {
        echo('conect OK');
    }
?>