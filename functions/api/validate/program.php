<?php
namespace api\validation;

use api\general;
use responses;
use api\fetch;
use mysqli_wrapper;

function is_killswitch_enabled(mysqli_wrapper $c_con, $program_key){
    $program_query = $c_con->query('SELECT c_killswitch FROM c_programs WHERE c_program_key=?', [$program_key]); //do not handle invalid entries

    return (bool)$program_query->fetch_assoc()['c_killswitch'];
}

function validate_program(mysqli_wrapper $c_con, $program_key) {
    if (!fetch\program_exists($c_con, $program_key))
        return responses::program_doesnt_exist;

    if (is_killswitch_enabled($c_con, $program_key))
        return responses::killswitch_is_enabled;

    return responses::success;
}

function program_valid_under_name(mysqli_wrapper $c_con, $program_owner, $program_key) {
    return $c_con->query('SELECT c_owner FROM c_programs WHERE c_program_key=? AND c_owner=?', [$program_key, $program_owner])->num_rows > 0;
}
