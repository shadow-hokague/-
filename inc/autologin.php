<?php
require 'dbh.inc.php';
require 'Auth/auth.php';
require_once  'extra/session.func.php';

$auth = new Auth();

if (isset($_GET['login'])) {
    try {
        //code...
        $token = $_COOKIE['token'];

        $id = get_user_id_from_session_token($token);
        if ($id) {
            $sql = "SELECT * FROM users WHERE idusers = '$id'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                session_start();
                $_SESSION['userId'] = $row['idusers'];
                $_SESSION['token'] = $auth->_queryUser($row['idusers']);
                $auth->_queryUser($row['idusers'], 2);
                $_SESSION['chat_token'] = $auth->user;
                $_SESSION['userUid'] = $row['uidusers'];
                $_SESSION['firstname'] = $row['usersFirstname'];
                $_SESSION['lastname'] = $row['usersSecondname'];
                $_SESSION['age'] = $row['usersAge'];
                $_SESSION['isAdmin'] = $row['isAdmin'];
                $_SESSION['profile-pic'] = $row['profile_picture'] ? $row['profile_picture'] : 'default.jpg';

                header("Location: ../home.php?login=success");
            }
        } else {
            header("Location: ./logout.inc.php");
        }
    } catch (\Throwable $th) {
        // throw $th;
        header("Location: ./logout.inc.php");
    }
} else {
    // send to login page
    header("Location: ../login.php?");
}
