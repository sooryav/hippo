DROP TABLE vendor;
commit;

CREATE TABLE vendor(
first_name VARCHAR(30) NOT NULL,
last_name VARCHAR(30) NOT NULL,
business_name VARCHAR(100) NULL,
email VARCHAR(60) NULL,
address1 VARCHAR(60)  NULL,
address2 VARCHAR(60) NULL,
city VARCHAR(40)  NULL,
state VARCHAR(40)  NULL,
zip INT UNSIGNED NOT NULL,
phone VARCHAR(20)  NULL,
category_id SMALLINT  NULL,
vendor_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
PRIMARY KEY (vendor_id));

INSERT INTO vendor VALUE
(
   'Atul', 'Gupta', 'Pani Poori Inc', 'atulgupta101@yahoo.com',
   '420 Roop Mahal', '', 'Kirkland', 'WA', 98034, '9709804003', 
   1, NULL 
);


INSERT INTO vendor VALUE
(
   'Soorya', 'Tanikela', 'Chole Bhature Inc', 'soorya@soorya.com',
   '123 Some Address', '', 'Redmond', 'WA', 98052, '1234567890', 
   1, NULL
);
