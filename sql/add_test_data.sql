-- Lisää INSERT INTO lauseet tähän tiedostoon
-- Potilas - taulun testidata
INSERT INTO Potilas (etunimi, sukunimi, hetu, username, pass) VALUES ('Anton', 'Moroz', '010190-255K', 'AntonM', 'test');
-- Lääkäri - taulun testidata
INSERT INTO Laakari (etunimi, sukunimi, sv, username, pass) VALUES ('Viktor', 'Moroz', 123456, 'ViktorM', 'test');
-- Hoitopyyntö - taulun testidata
INSERT INTO Hoitopyynto (potilas_id, laakari_id, luontipvm, kayntipvm, raportti) VALUES (1,1, CURRENT_DATE - 10, CURRENT_DATE, 'Testihälytys');
INSERT INTO Hoitopyynto (potilas_id, laakari_id, luontipvm, kayntipvm, raportti) VALUES (1,1, CURRENT_DATE - 1, null, 'Testihälytys');
-- Hoito-ohje - taulun testidata
INSERT INTO Hoitoohje (potilas_id, laakari_id, luontipvm, muokkauspvm, ohje) VALUES (1, 1, date '2017-11-11' - integer '10', CURRENT_DATE, 'Laihdu läski');
