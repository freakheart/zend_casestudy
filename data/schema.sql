CREATE TABLE certificate 
(
	certificate_id integer PRIMARY KEY AUTOINCREMENT,
	isin varchar(50),
	trading_market varchar(50),
	currency varchar(10),
	issuer varchar(100),
	issuing_price float,
	current_price float,
	certificate_type varchar(50)
);

CREATE TABLE history 
( 
	history_id integer PRIMARY KEY AUTOINCREMENT, 
	certificate_id int REFERENCES certificate(certificate_id) ON DELETE CASCADE, 
	price float, 
	creation_date timestamp 
);

CREATE TABLE document 
( 
	document_id integer PRIMARY KEY AUTOINCREMENT,
	certificate_id integer REFERENCES certificate(certificate_id) ON DELETE CASCADE, 
	document_type varchar(50), 
	document_name varchar(100) 
);

CREATE TABLE bonus_certificate 
( 
	certificate_id int PRIMARY KEY REFERENCES certificate(certificate_id) ON DELETE CASCADE,
	barrier_level float
);

CREATE TABLE guarantee_certificate 
( 
	certificate_id int PRIMARY KEY REFERENCES certificate(certificate_id) ON DELETE CASCADE,
	participation_rate float
);