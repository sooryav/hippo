CREATE TABLE vendor(
first_name VARCHAR(30) NOT NULL,
last_name VARCHAR(30) NOT NULL,
business_name VARCHAR(100) NOT NULL,
email VARCHAR(60) NULL,
address1 VARCHAR(60) NOT NULL,
address2 VARCHAR(60) NULL,
city VARCHAR(40) NOT NULL,
state VARCHAR(40) NOT NULL,
zip INT UNSIGNED NOT NULL,
phone VARCHAR(20) NOT NULL,
category_id SMALLINT NOT NULL,
vendor_id INT UNSIGNED NOT NULL PRIMARY KEY);

INSERT INTO vendor VALUE
(
   'Atul', 'Gupta', 'Pani Poori Inc', 'atulgupta101@yahoo.com',
   '420 Roop Mahal', '', 'Kirkland', 'WA', 98034, '9709804003', 
   1, 1
);


INSERT INTO vendor VALUE
(
   'Soorya', 'Tanikela', 'Chole Bhature Inc', 'soorya@soorya.com',
   '123 Some Address', '', 'Redmond', 'WA', 98052, '1234567890', 
   1, 2
);
