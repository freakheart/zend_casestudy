USE certificate_casestudy;
GO

INSERT INTO certificate           
(
	isin,
	trading_market,
	currency,
    issuer,
    issuing_price,
    current_price
)
VALUES
(
	'123456',
    'Germany',
    'EUR',
   	'Test',
    '100',
    '120'
);