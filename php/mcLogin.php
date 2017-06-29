<?php
include dirname(__FILE__) . '/mcLogin_vars.php';

$link = NULL;
$curr_user = NULL;
$curr_pass = NULL;

$READ = 0;
$WRITE = 1;

if(isset($_POST['func']) && !empty($_POST['func'])) {
    $func = $_POST['func'];
    main($func);
}

/*
Function to be called when the script is executed by an AJAX call with the
'func' variable set, defining the function to be executed.

@param  func    Name of the function to be executed by the AJAX call.
*/
function main($func) {
    switch($action) {
        case 'checkLogin':
            echo 'Execute checkLogin not implemented!';
            break;
        case 'setSessVar':
            echo 'Execute setSessVar not implemented!';
            break;
    }
}

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

/*
This function will create a user in the database with the given username and
password. If no password if given, the user will not be assigned a password,
NULL will be used.

@param  username    Username of the user to be created.
@param  password    [Optional] Password of the user to be created. NULL will be
                    used if no value given.

@return Username of the newly created user if successful, NULL if fails.
*/
function createUser($username, $password=NULL) {
    global $link, $table, $WRITE;

    if(!db_connect($WRITE)) {
        return NULL;
    }

    $query = "INSERT INTO " . $table . "(username, password) VALUES('" . $username . "',";

    if($password != NULL) {
        $query = $query . "'" . $password . "')";
    } else {
        $query = $query . "NULL)";
    }

    if ($result = $link->query($query)) {
        db_close();
        return $username;
    } else {
        echo 'Create user query failed.';
    }

    db_close();
    return NULL;
}

/*
Delete user with the given username.

@param  username    Username of the user to be deleted.

@return Username of deleted user on success, NULL on db connect or query fail,
        0 if user does not exist.
*/
function deleteUser($username) {
    global $link, $table, $WRITE;
    
    if(checkLogin($username) == NULL) {
        return 0;
    }

    if(!db_connect($WRITE)) {
        return NULL;
    }

    $query = "DELETE FROM " . $table . " WHERE username='" . $username . "'";

    if ($result = $link->query($query)) {
        db_close();
        return $username;
    } else {
        echo 'Delete user query failed.';
    }

    db_close();
    return NULL;
}

function disableUser() {

}

function enableUser() {

}

function getHostInfo() {
    mysqli_get_host_info($link);
}
?>
