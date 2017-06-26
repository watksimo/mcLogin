CREATE DATABASE mclogin;
USE mclogin;
CREATE TABLE auth (username VARCHAR NOT NULL, password VARCHAR NOT NULL);
CREATE USER 'read'@'localhost' IDENTIFIED BY 'read';
CREATE USER 'write'@'localhost' IDENTIFIED BY 'write';
INSERT INTO auth VALUES('john','doe');
COMMIT;
