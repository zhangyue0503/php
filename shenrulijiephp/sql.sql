################
# Chapter 1:
################

# Database-driven arrays

USE test; 

CREATE TABLE tasks ( 
task_id INT UNSIGNED NOT NULL AUTO_INCREMENT, 
parent_id INT UNSIGNED NOT NULL DEFAULT 0, 
task VARCHAR(100) NOT NULL, 
date_added TIMESTAMP NOT NULL, 
date_completed TIMESTAMP, 
PRIMARY KEY (task_id), 
INDEX parent (parent_id), 
INDEX added (date_added), 
INDEX completed (date_completed) 
);

################
# Chapter 3:
################

# Storing Sessions in a Database

USE test;

CREATE TABLE sessions ( 
id CHAR(32) NOT NULL, 
data TEXT, 
last_accessed TIMESTAMP NOT NULL, 
PRIMARY KEY (id) 
); 

# Working with U.S. Zip Codes

CREATE DATABASE zips; 

CREATE TABLE zip_codes (
zip_code INT(5) UNSIGNED ZEROFILL NOT NULL,
zip_code_type VARCHAR(10),
city VARCHAR(60) NOT NULL,
state VARCHAR(14) NOT NULL,
location_type VARCHAR(10),
latitude DECIMAL(4,2),
longitude DECIMAL(5,2),
location VARCHAR(30),
decommisioned  VARCHAR(30),
taxreturnsfiled INT,
population INT,
wages INT,
PRIMARY KEY (zip_code)
);

LOAD DATA INFILE '/tmp/ZIP_CODES.txt' 
INTO TABLE zip_codes 
FIELDS TERMINATED BY ',' 
ENCLOSED BY '"' 
LINES TERMINATED BY '\n';

ALTER TABLE zip_codes DROP COLUMN location_type, DROP COLUMN location, DROP COLUMN decommisioned, DROP COLUMN taxreturnsfiled, DROP COLUMN population, DROP COLUMN wages; 

UPDATE zip_codes SET latitude=NULL, longitude=NULL WHERE latitude='';

CREATE TABLE stores ( 
store_id SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT, 
name VARCHAR(60) NOT NULL, 
address1 VARCHAR(100) NOT NULL, 
address2 VARCHAR(100) default NULL, 
zip_code INT(5) UNSIGNED ZEROFILL NOT NULL, 
phone VARCHAR(15) NOT NULL, 
PRIMARY KEY (store_id), 
KEY (zip_code) 
); 

INSERT INTO stores (name, address1, address2, zip_code, phone) VALUES 
('Ray''s Shop', '49 Main Street', NULL, '63939', '(123) 456-7890'), 
('Little Lulu''s', '12904 Rockville Pike', '#310', '10580', '(123) 654- 7890'), 
('The Store Store', '8200 Leesburg Pike', NULL, '02461', '(123) 456- 8989'), 
('Smart Shop', '9 Commercial Way', NULL, '02141', '(123) 555-7890'), 
('Megastore', '34 Suburban View', NULL, '31066', '(555) 456-7890'), 
('Chain Chain Chain', '8th & Eastwood', NULL, '80726', '(123) 808-7890'), 
('Kiosk', 'St. Charles Towncenter', '3890 Crain Highway', '63384', '(123) 888-4444'), 
('Another Place', '1600 Pennsylvania Avenue', NULL, '05491', '(111) 456- 7890'), 
('Fishmonger''s Heaven', 'Pier 9', NULL, '53571', '(123) 000-7890'), 
('Hoo New', '576b Little River Turnpike', NULL, '08098', '(123) 456-0000'), 
('Vamps ''R'' Us', 'Our Location', 'Atwood Mall', '02062', '(222) 456- 7890'), 
('Five and Dime', '9 Constitution Avenue', NULL, '73503', '(123) 446- 7890'), 
('A & P', '890 North Broadway', NULL, '85329', '(123) 456-2323'), 
('Spend Money Here', '1209 Columbia Pike', NULL, '10583', '(321) 456- 7890');

# Creating Stored Functions

DELIMITER $$
CREATE FUNCTION return_distance (lat_a DOUBLE, long_a DOUBLE, lat_b DOUBLE, long_b DOUBLE) RETURNS DOUBLE 
BEGIN 
DECLARE distance DOUBLE; 
SET distance = SIN(RADIANS(lat_a)) * SIN(RADIANS(lat_b)) 
+ COS(RADIANS(lat_a)) 
* COS(RADIANS(lat_b)) 
* COS(RADIANS(long_a - long_b)); 
RETURN((DEGREES(ACOS(distance))) * 69.09); 
END $$
DELIMITER ;

################
# Chapter 9:
################

# CMS Example

CREATE TABLE users (
id INT UNSIGNED NOT NULL AUTO_INCREMENT,
userType ENUM('public','author','admin'),
username VARCHAR(30) NOT NULL,
email VARCHAR(40) NOT NULL,
pass CHAR(40) NOT NULL,
dateAdded TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (id),
UNIQUE (username),
UNIQUE (email),
INDEX login (email, pass)
);

CREATE TABLE pages (
id INT UNSIGNED NOT NULL AUTO_INCREMENT,
creatorId INT UNSIGNED NOT NULL,
title VARCHAR(100) NOT NULL,
content TEXT NOT NULL,
dateUpdated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
dateAdded TIMESTAMP NOT NULL,
PRIMARY KEY (id),
INDEX (creatorId),
INDEX (dateUpdated)
);

INSERT INTO users VALUES 
(NULL, 'public', 'publicUser', 'public@example.com', SHA1('publicPass'), NULL),
(NULL, 'author', 'authorUser', 'author@example.com', SHA1('authorPass'), NULL),
(NULL, 'admin', 'adminUser', 'admin@example.com', SHA1('adminPass'), NULL);

INSERT INTO pages VALUES
(NULL, 2, 'This is a post', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>', NULL, NOW());