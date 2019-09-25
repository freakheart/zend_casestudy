IF  NOT EXISTS (SELECT * FROM sys.databases WHERE name = 'certificate_casestudy')
CREATE DATABASE certificate_casestudy;
GO
USE certificate_casestudy;
if not exists 
(
	select * from information_schema.tables where table_name = 'certificate'
)
CREATE TABLE certificate 
(
	certificate_id int identity(1,1) PRIMARY KEY,
	isin varchar(50),
	trading_market varchar(50),
	currency varchar(10),
	issuer varchar(100),
	issuing_price float,
	current_price float
);
if not exists 
(
	select * from information_schema.tables where table_name = 'history'
)
CREATE TABLE history 
( 
	history_id int identity(1,1) PRIMARY KEY, 
	certificate_id int REFERENCES certificate(certificate_id) ON DELETE CASCADE, 
	current_price float, 
	created datetime 
);
if not exists 
(
	select * from information_schema.tables where table_name = 'document'
)
CREATE TABLE document 
( 
	document_id INT identity(1,1) PRIMARY KEY,
	certificate_id integer REFERENCES certificate(certificate_id) ON DELETE CASCADE, 
	document_type int, 
	document_name VARCHAR(100) 
);
if not exists 
(
	select * from information_schema.tables where table_name = 'bonus_certificate'
)
CREATE TABLE bonus_certificate 
( 
	certificate_id int PRIMARY KEY REFERENCES certificate(certificate_id) ON DELETE CASCADE 
);
if not exists 
(
	select * from information_schema.tables where table_name = 'guarantee_certificate'
)
CREATE TABLE guarantee_certificate 
( 
	certificate_id int PRIMARY KEY REFERENCES certificate(certificate_id) ON DELETE CASCADE 
);