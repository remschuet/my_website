DROP TABLE IF EXISTS user;
DROP TABLE IF EXISTS message;

CREATE TABLE user (
  id INTEGER PRIMARY KEY,
  username TEXT,
  password TEXT,
  email TEXT,
  status INTEGER DEFAULT 1
);

CREATE TABLE message (
  id INTEGER PRIMARY KEY,
  sender user,
  public INTEGER,
  content TEXT
);


INSERT INTO user (username, password, email)
	VALUES("root", "$2y$10$BpecishveAkLHTJF9rq8vuJiOGcjrWwY/Jti7g.XDddtTIZSPbp3i", "root@root"),
    	  ("admin", "$2y$10$BpecishveAkLHTJF9rq8vuJiOGcjrWwY/Jti7g.XDddtTIZSPbp3i", "admin@admin");

INSERT INTO message (sender, public, content)
	VALUES	((SELECT id FROM user WHERE username = "root"), 1, "Coucou tout le monde"),
    		((SELECT id FROM user WHERE username = "admin"), 1, "coucou a toi"),
      		((SELECT id FROM user WHERE username = "admin"), 1, "Comment tu vas ?");