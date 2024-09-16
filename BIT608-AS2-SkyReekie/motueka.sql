--Sky Reekie SN#3809237 BIT608 Assesment 2--
CREATE DATABASE IF NOT EXISTS motueka;
USE motueka;

-- The rooms for the bed and breakfast
DROP TABLE IF EXISTS room;
CREATE TABLE IF NOT EXISTS room (
  roomID int unsigned NOT NULL auto_increment,
  roomname varchar(100) NOT NULL,
  description text default NULL,
  roomtype char(1) default 'D',  
  beds int,
  PRIMARY KEY (roomID)
) AUTO_INCREMENT=1;

INSERT INTO room (roomID, roomname, description, roomtype, beds) VALUES 
(1, "Kellie", "Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed tortor. Integer aliquam adipiscing", "S", 5),
(2, "Herman", "Lorem ipsum dolor sit amet, consectetuer", "D", 5),
(3, "Scarlett", "Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur", "D", 2),
(4, "Jelani", "Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed tortor. Integer aliquam", "S", 2),
(5, "Sonya", "Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed tortor. Integer aliquam adipiscing lacus.", "S", 5),
(6, "Miranda", "Lorem ipsum dolor sit amet, consectetuer adipiscing", "S", 4),
(7, "Helen", "Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed tortor. Integer aliquam adipiscing lacus.", "S", 2),
(8, "Octavia", "Lorem ipsum dolor sit amet,", "D", 3),
(9, "Gretchen", "Lorem ipsum dolor sit", "D", 3),
(10, "Bernard", "Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed tortor. Integer", "S", 5),
(11, "Dacey", "Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur", "D", 2),
(12, "Preston", "Lorem", "D", 2),
(13, "Dane", "Lorem ipsum dolor", "S", 4),
(14, "Cole", "Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed tortor. Integer aliquam", "S", 1);


-- Customers
DROP TABLE IF EXISTS customer;
CREATE TABLE IF NOT EXISTS customer (
  customerID int unsigned NOT NULL auto_increment,
  firstname varchar(50) NOT NULL,
  lastname varchar(50) NOT NULL,
  email varchar(100) NOT NULL,
  phone varchar(15) NULL,
  password varchar(40) NOT NULL default '.',
  PRIMARY KEY (customerID)
) AUTO_INCREMENT=1;

INSERT INTO customer (customerID, firstname, lastname, email, phone) VALUES 
(2, "Desiree", "Collier", "Maecenas@non.co.uk", NULL),
(3, "Irene", "Walker", "id.erat.Etiam@id.org", NULL),
(4, "Forrest", "Baldwin", "eget.nisi.dictum@a.com", NULL),
(5, "Beverly", "Sellers", "ultricies.sem@pharetraQuisqueac.co.uk", NULL),
(6, "Glenna", "Kinney", "dolor@orcilobortisaugue.org", NULL),
(7, "Montana", "Gallagher", "sapien.cursus@ultriciesdignissimlacus.edu", NULL),
(8, "Harlan", "Lara", "Duis@aliquetodioEtiam.edu", NULL),
(9, "Benjamin", "King", "mollis@Nullainterdum.org", NULL),
(10, "Rajah", "Olsen", "Vestibulum.ut.eros@nequevenenatislacus.ca", NULL),
(11, "Castor", "Kelly", "Fusce.feugiat.Lorem@porta.co.uk", NULL),
(12, "Omar", "Oconnor", "eu.turpis@auctorvelit.co.uk", NULL),
(13, "Porter", "Leonard", "dui.Fusce@accumsanlaoreet.net", NULL),
(14, "Buckminster", "Gaines", "convallis.convallis.dolor@ligula.co.uk", NULL),
(15, "Hunter", "Rodriquez", "ridiculus.mus.Donec@est.co.uk", NULL),
(16, "Zahir", "Harper", "vel@estNunc.com", NULL),
(17, "Sopoline", "Warner", "vestibulum.nec.euismod@sitamet.co.uk", NULL),
(18, "Burton", "Parrish", "consequat.nec.mollis@nequenonquam.org", NULL),
(19, "Abbot", "Rose", "non@et.ca", NULL),
(20, "Barry", "Burks", "risus@libero.net", NULL);

--add the new customers into the table
INSERT INTO customer (customerID, firstname, lastname, email, phone) VALUES 
(21, 'Alice', 'Bergeress', 'alice@example.com', '1002000300'),
(22, 'Bae', 'Robbinson', 'bae@example.com', '1001001000'),
(23, 'Alex', 'Sharp', 'alex@example.com', '1001001000'),
(24, 'Bethany', 'Beskey', 'bethany@example.com', '1001001000');

--add a new collumn for admin or customer permissions--
ALTER TABLE customer ADD COLUMN role ENUM('admin', 'customer') NOT NULL DEFAULT 'customer';

--Bookings
DROP TABLE IF EXISTS bookings;
CREATE TABLE IF NOT EXISTS bookings (
  bookingID int NOT NULL auto_increment,
  firstname varchar(100) NOT NULL,
  lastname varchar(100) NOT NULL,
  phone varchar(15) NULL,
  checkin date NOT NULL,
  checkout date NOT NULL,
  roomname varchar(100) NOT NULL,
  extras varchar(500) NULL,
  review varchar(500) NULL,
  roomID int NOT NULL,
  customerID int NOT NULL,
  PRIMARY KEY (bookingID),
  FOREIGN KEY (roomID) REFERENCES room(roomID),
  FOREIGN KEY (customerID) REFERENCES customer(customerID)
) AUTO_INCREMENT=1;

INSERT INTO bookings (bookingID, firstname, lastname, phone, checkin, checkout, roomname, extras, review, roomID, customerID) 
VALUES 
(NULL, 'Desiree', 'Collier', '0', '2024-08-01', '2024-08-10', 'Octavia', 'none', 'none', 8, 2), 
(NULL, 'Montana', 'Gallagher', '0', '2024-08-01', '2024-08-10', 'Miranda', 'none', 'none', 6, 7), 
(NULL, 'Alice', 'Bergeress', '1002000300', '2024-07-20', '2024-07-23', 'Scarlett', '', 'none', 3, 3), 
(NULL, 'Bae', 'Robbinson', '1001001000', '2024-07-11', '2024-07-13', 'Kellie', '', '0', 1, 4), 
(NULL, 'Alex', 'Sharp', '1001001000', '2024-08-10', '2024-08-14', 'Scarlett', '', 'none', 3, 5), 
(NULL, 'Bethany', 'Beskey', '1001001000', '2024-08-22', '2024-08-24', 'Kellie', '', 'none', 1, 6), 
(NULL, 'Bethany', 'Beskey', '1001001000', '2024-08-10', '2024-08-14', 'Gretchen', '', 'none', 9, 6);
