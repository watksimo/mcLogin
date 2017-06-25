<?php

$link = NULL;
$curr_user = NULL;
$curr_pass = NULL;

$READ = 0;
$WRITE = 1;

/*
Connect to database as specified user with details in the variables file.

@param  access  READ or WRITE value sets access level of connecting user.
*/
function db_connect($access) {
    
    if($access == $READ) {
        $curr_user = $user_read;
        $curr_pass = $pass_read; 
    } elseif($access == $WRITE) {
        $curr_user = $user_write;
        $curr_pass = $pass_write;
    } else {
        echo 'Invalid access level. User "READ" or "WRITE".';
        return False;
    }

    $link = mysqli_connect($db_host, $curr_user, $curr_pass, $db_name);

    if (!$link) {
        echo "Errno " . mysqli_connect_errno() . "connecting to db. " . mysqli_connect_error()  . PHP_EOL;
        return False;
    }
    
    return True;
}

function db_close() {
    if (!$link) {
        echo "Db already closed.";
    } else {
        mysqli_close($link);
    }

    $curr_user = NULL;
    $curr_pass = NULL;
    $link = NULL;
}

function checkLogin($username, $password=NULL) {
    $query = "SELECT * FROM " . $table . " WHERE username='" . $curr_user . "'";

    if($password != NULL) {
        $query = $query . " AND password='" . $curr_pass . "'";
    }

    if ($result = $conn->query($query)) {

        if($result->num_rows > 0) {
            $row = $result->fetch_array();  # Guaranteed only 1 due to email as unique
            return $row["username"];
        } else {
            echo 'No users found.';
            return NULL;
        }
    } else {
        echo 'Login check query failed.';
        return NULL;
    }

}

function createUser() {

}

function deleteUser() {

}

function disableUser() {

}

function enableUser() {

}

function getHostInfo() {
    mysqli_get_host_info($link);
}
?>
