<?php
include dirname(__FILE__) . '/mcLogin_vars.php';

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
    global $curr_user, $curr_pass, $user_read, $pass_read, $user_write, $pass_write;
    global $db_host, $db_name, $link, $READ, $WRITE;
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
    //$link = mysqli_connect('localhost','read','read','mclogin');
    $link = mysqli_connect($db_host, $curr_user, $curr_pass, $db_name);

    if (!$link) {
        echo "Errno " . mysqli_connect_errno() . "connecting to db. " . mysqli_connect_error()  . PHP_EOL;
        return False;
    }
    
    return True;
}

/*
Close connection to database and reset all vars to NULL if one exists, exit 
function if no connection exists.
*/
function db_close() {
    global $link, $curr_user, $curr_pass;

    if (!$link) {
        echo "Db already closed.";
    } else {
        mysqli_close($link);
    }

    $curr_user = NULL;
    $curr_pass = NULL;
    $link = NULL;
}

/*
Checks if login credentials passed exist and are valid. If no password is given,
only the username will be checked.

@param  username    Username of the user to be checked.
@param  password    [Optional] Password of the user to be checked. Defaults to
                    NULL if none given.

@return Username of user if validated, NULL if not.
*/
function checkLogin($username, $password=NULL) {
    global $link, $table, $READ;

    if(!db_connect($READ)) {
        return NULL;
    }

    $query = "SELECT * FROM " . $table . " WHERE username='" . $username . "'";

    if($password != NULL) {
        $query = $query . " AND password='" . $password . "'";
    }

    if ($result = $link->query($query)) {

        if($result->num_rows > 0) {
            $row = $result->fetch_array();  # Guaranteed only 1 due to username being unique
            db_close();
            return $row["username"];
        } else {
            echo 'No users found.';
        }
    } else {
        echo 'Login check query failed.';
    }

    db_close();
    return NULL;
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
