<?php
    class UserDAO {
/*************************
    VERIFICATION DATA
**************************/
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




/*************************
        INSERT
**************************/

        // Add user 
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

        // Create groupe 
        public static function createGroupe($_userName, $_name){    /*str, str*/
            $db = new SQLite3('../private/mydata.db');

            $query = $db->prepare("INSERT INTO groupe (admin, name) VALUES ((SELECT id FROM user WHERE username = :username), :name)");
            
            // Liez les valeurs aux paramètres
            $query->bindParam(':username', $_userName, SQLITE3_TEXT);
            $query->bindParam(':name', $_name, SQLITE3_TEXT);
            $query->execute();
        } 

        # Send message to groupe
        public static function sendMsg($_userName, $_groupe_name, $_content){   /* str, str, str*/
            $db = new SQLite3('../private/mydata.db');

            $query = $db->prepare("INSERT INTO message (user, groupe, content) VALUES ((SELECT id FROM user WHERE username = :username), (SELECT id FROM groupe WHERE name = :groupe), :content)");
            
            // Liez les valeurs aux paramètres
            $query->bindParam(':username', $_userName, SQLITE3_TEXT);
            $query->bindParam(':groupe', $_groupe_name, SQLITE3_TEXT);
            $query->bindParam(':content', $_content, SQLITE3_TEXT);
            $query->execute();
        }

        // Add user to groupe 
        public static function addUserToGroupe($_userName, $_groupeName){ /* str, str */
            $db = new SQLite3('../private/mydata.db');

            $query = $db->prepare("INSERT INTO user_groupe (user, groupe, status)
                                   VALUES ((SELECT id FROM user where username = :username), 
                                           (SELECT id FROm groupe where name = :groupeName), 
                                            1);");

            // Liez les valeurs aux paramètres
            $query->bindParam(':username', $_userName, SQLITE3_TEXT);
            $query->bindParam(':groupeName', $_groupeName, SQLITE3_TEXT);
            $query->execute();
        }

        // remove user to groupe 
        public static function removeUserFromGroupe($_userName, $_groupeName){ /* str, str */
            $db = new SQLite3('../private/mydata.db');

            if ($_groupe_name == 'public'){
                return;
            }

            $query = $db->prepare("DELETE FROM user_groupe WHERE user = (SELECT id FROM user where username = :userName) AND groupe = (SELECT id from groupe where name = :groupeName);");

            // Liez les valeurs aux paramètres
            $query->bindParam(':userName', $_userName, SQLITE3_TEXT);
            $query->bindParam(':groupeName', $_groupeName, SQLITE3_TEXT);
            $query->execute();
        }

        // Get all msg for all groupes
        public static function getAjaxMessageArray() {
            $db = new SQLite3('../private/mydata.db');
            $query = "SELECT (SELECT username FROM user WHERE user.id = user) AS user, content FROM message";
            $result = $db->query($query);

            $data = array();
            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                $data[] = $row;
            }
            
            return $data;
        }

/*************************
    FOR AJAX REQUESTS
**************************/

        // Get all groupe for a user
        public static function getAjaxGroupeNameForUserArray($_userName) {  /* str */
            $db = new SQLite3('../private/mydata.db');
            $query = "SELECT name 
                        FROM groupe 
                       WHERE id IN (SELECT groupe 
                                      FROM user_groupe 
                                    WHERE user = (SELECT id from user where username = '$_userName'))";
            $result = $db->query($query);

            $data = array();
            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                $data[] = $row;
            }
            
            return $data;
        }

        // Get last 10 messages for a groupe
        public static function getAjaxMsgForGroupeArray($groupe) {
            $db = new SQLite3('../private/mydata.db');
            $query = "SELECT (SELECT username FROM user WHERE user.id = user) AS user, content
                        FROM message 
                       WHERE groupe = (SELECT id FROM groupe WHERE name = '$groupe') 
                       ORDER BY id ASC 
                       LIMIT (SELECT COUNT(*) - 10 FROM message WHERE groupe = (SELECT id FROM groupe WHERE name = '$groupe')), 10;";
            $result = $db->query($query);

            $data = array();
            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                $data[] = $row;
            }
            
            return $data;
        }

        // Get all users in a groupe
        public static function getAjaxUserForGroupeArray($_groupeName) {  /* str */
            $db = new SQLite3('../private/mydata.db');
            $query = "SELECT (SELECT username from user where id = user) AS username
                        FROM user_groupe
                       WHERE groupe = (SELECT id from groupe where name = '$_groupeName')";
            $result = $db->query($query);

            $data = array();
            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                $data[] = $row;
            }
            
            return $data;
        }


    }
