CREATE DATABASE posts_comments_db;

USE posts_comments_db;

CREATE TABLE posts (
  id INT NOT NULL AUTO_INCREMENT,
  userId INT,
  title VARCHAR(100),
  body TEXT,
  PRIMARY KEY (id)
);

CREATE TABLE comments (
  id INT NOT NULL AUTO_INCREMENT,
  postId INT,
  name VARCHAR(100),
  email VARCHAR(100),
  body TEXT,
  PRIMARY KEY (id),
  FOREIGN KEY (postId) REFERENCES posts(id)
);



