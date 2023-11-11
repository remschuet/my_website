-- drop
DROP TABLE if EXISTS user;
DROP TABLE if EXISTS message;
DROP table if EXISTS user_groupe;
DROP table if EXISTS groupe;

-- Table user
CREATE TABLE IF NOT EXISTS user (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  username TEXT NOT NULL UNIQUE,
  password TEXT NOT NULL,
  email TEXT NOT NULL,
  status INTEGER NOT NULL DEFAULT 1
);

-- Table message
CREATE TABLE IF NOT EXISTS message (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  user INTEGER NOT NULL,
  groupe INTEGER NOT NULL,
  content TEXT NOT NULL,
  
  FOREIGN KEY (user) REFERENCES user(id),
  FOREIGN KEY (groupe) REFERENCES groupe(id)
);

-- Table groupe_user
CREATE TABLE IF NOT EXISTS user_groupe (
  user INTEGER,
  groupe INTEGER,
  status INTEGER,
  
  PRIMARY KEY (groupe, user),
  FOREIGN KEY (groupe) REFERENCES groupe(id),
  FOREIGN KEY (user) REFERENCES user(id)
);

-- Table groupe
CREATE TABLE IF NOT EXISTS groupe (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  admin INTEGER,
  name TEXT NOT NULL UNIQUE,
  
  FOREIGN KEY (admin) REFERENCES user(id)
);

-- INSERT de base pour le groupe public

INSERT INTO user   	(username, password, email, status)
			VALUES 	("admin", "unknown", "admin@admin", 2);

INSERT INTO groupe  (admin, name)
			VALUES 	((SELECT id FROM user WHERE username = "admin"), "public");
                        
INSERT INTO user_groupe	(user, groupe, status)
			VALUES 		((SELECT id FROM user WHERE username = "admin"), (SELECT id FROM groupe WHERE name = "public"), 1);
            
INSERT INTO message		(user, groupe, content)
			VALUES 		((SELECT id FROM user WHERE username = "admin"), (SELECT id FROM groupe WHERE name = "public"), "Bonjour à tous !");