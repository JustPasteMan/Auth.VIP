<?php
session_start(array(
    'name' => 'authvip'
));

session_destroy();

header('Location: ../login.php');
