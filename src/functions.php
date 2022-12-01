<?php
    require "db.php";
    
    function check_existing_email($email) {
        global $connection;
        $flag = false;

        $query = "SELECT `id` FROM `users` WHERE `email` = '".mysqli_escape_string($connection, $email)."'";
        $result = mysqli_query($connection, $query);

        if(mysqli_num_rows($result) > 0) {
            $flag = true;
        }

        return $flag;
    }

    function escape_string($field) {
        global $connection;
        return mysqli_escape_string($connection, $field);
    }

    function save_registration($name, $email, $password) {
        global $connection;
        $users = [];

        $query = "INSERT INTO `users` (`name`, `email`) VALUES ('".escape_string($name)."', '".escape_string($email)."')";

        if(mysqli_query($connection, $query)) {
            $id = mysqli_insert_id($connection);
            $encrypted_password = md5(md5($id . $password)); //md5(md5(2mypassword))

            $query = "UPDATE `users` SET `password` = '".$encrypted_password."' WHERE `users`.`id` = '".$id."'";
            if(mysqli_query($connection, $query)) {
                $query = "SELECT * FROM `users` WHERE `users`.`id` = '".$id."' and `users`.`password` = '".escape_string($encrypted_password)."' LIMIT 1";
                $result = mysqli_query($connection, $query);
                $row = mysqli_fetch_array($result);

                if(!empty($row)) {
                    $users = [
                        "id" => $row['id'],
                        "name" => $row['name']
                    ];
                }
            }
        }
        
        return $users;
    }
?>