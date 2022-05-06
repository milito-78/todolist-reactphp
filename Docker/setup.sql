-- create the databases
CREATE DATABASE IF NOT EXISTS todolist;

-- create the users for each database
CREATE USER 'todolist_user'@'%' IDENTIFIED BY 'milito';
GRANT CREATE, ALTER, INDEX, LOCK TABLES, REFERENCES, UPDATE, DELETE, DROP, SELECT, INSERT ON `todolist`.* TO 'todolist_user'@'%';

FLUSH PRIVILEGES;