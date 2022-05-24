<?php
if (!isset($_SESSION))
    session_start(array(
        'name' => 'authvip'
    ));

date_default_timezone_set('UTC');

function get_connection() { //local connection
    return new mysqli_wrapper(
        'localhost', 'authfldd_user', 'jwKpLsR8M1UE', 'authfldd_auth', true
    );
}
