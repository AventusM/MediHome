-- Lisää INSERT INTO lauseet tähän tiedostoon
-- Potilas - taulun testidata
INSERT INTO Potilas (etunimi, sukunimi, hetu, username, password) VALUES ('Anton', 'Moroz', '010190-255K', 'AntonM', 'test');
-- Lääkäri - taulun testidata
INSERT INTO Laakari (etunimi, sukunimi, sv, username, password) VALUES ('Viktor', 'Moroz', 123456, 'ViktorM', 'test');
-- Raportti - taulun testidata
INSERT INTO Raportti (hoitopyynto_id, laakari_id, pvm, input) VALUES (1, 1, CURRENT_DATE, 'Potilas valitti kurkku- ja sydänkipua. Kohonneen verenpaineen hoito aloitetaan potilaan toivuttua flunssasta.');
-- Hoitopyyntö - taulun testidata
INSERT INTO Hoitopyynto (potilas_id, laakari_id, kayntipvm) VALUES (1,1, CURRENT_TIME);
-- Hoito-ohje - taulun testidata
INSERT INTO Hoitoohje (potilas_id, laakari_id, luontipvm, muokkauspvm, input) VALUES (1, 1, date '2017-11-11' - integer '10', CURRENT_DATE, '5mg XXXXX.YYYYY.ZZZZZ kahdesti päivässä kohonneen verenpaineen hoitoon. Aktiivista liikuntaa vältettävä sekä ruokavalioon kiinnitettävä huolta');
