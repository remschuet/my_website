<?php
    class UserDAO {
        public static function createUser($sign_username, $sign_passwd, $sign_email){
            $db = new SQLite3('../private/mydata.db');

            $query = "SELECT * FROM user";
            $statement = $db->query($query);
            # for every user, verify log
            while ($row = $statement->fetchArray()) {
                if ($row["username"]  == $sign_username) {
                    return "Le user existe deja";
                }
            }
            $query = $db->prepare("INSERT INTO user (username, password, email) VALUES(:sign_username, :sign_passwd, :sign_email);");            
            // Liez les valeurs aux paramètres
            $query->bindParam(':sign_username', $sign_username, SQLITE3_TEXT);
            $query->bindParam(':sign_passwd', $sign_passwd, SQLITE3_TEXT);
            $query->bindParam(':sign_email', $sign_email, SQLITE3_TEXT);
            $query->execute();
            return null;
        }

        # Verify if user exist in the database
        public static function authenticate($username, $password) {
             $db = new SQLite3('../private/mydata.db');
 
             $query = "SELECT * FROM user";
             $statement = $db->query($query);
             $user = null;
            
            # for every user, verify log
             while ($row = $statement->fetchArray()) {
                if ($row["username"]  == $username && password_verify($password, $row["password"])) {
                    $user = [
                        "username" => $row["username"],
                        "email" => $row["email"],
                        "visibility" => $row["status"],
                    ];
                }
			}
            return $user;
        }

        # Send message to database
        public static function sendMsg($_userName, $_content){
            $db = new SQLite3('../private/mydata.db');

            $query = $db->prepare("INSERT INTO message (sender, content) VALUES ((SELECT id FROM user WHERE username = :username), :content)");
            
            // Liez les valeurs aux paramètres
            $query->bindParam(':username', $_userName, SQLITE3_TEXT);
            $query->bindParam(':content', $_content, SQLITE3_TEXT);
            $query->execute();
        }

        public static function getAjaxMessageArray() {
            $db = new SQLite3('../private/mydata.db');
            $query = "SELECT (SELECT username FROM user WHERE user.id = sender) AS sender, content FROM message";
            $result = $db->query($query);

            $data = array();
            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                $data[] = $row;
            }
            
            return $data;
        }
    }
