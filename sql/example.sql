CREATE DATABASE mclogin;
USE mclogin;
CREATE TABLE auth (username VARCHAR(100) NOT NULL, password VARCHAR(100), PRIMARY KEY (username));
CREATE USER 'read'@'localhost' IDENTIFIED BY 'read';
CREATE USER 'write'@'localhost' IDENTIFIED BY 'write';
INSERT INTO auth VALUES('john','doe');
COMMIT;
