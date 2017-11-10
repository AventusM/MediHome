-- Lisää CREATE TABLE lauseet tähän tiedostoon
CREATE TABLE Potilas(
id SERIAL PRIMARY KEY,
etunimi varchar(20) NOT NULL,
sukunimi varchar(20) NOT NULL,
hetu varchar(11) NOT NULL,
username varchar(20) NOT NULL,
password varchar(20) NOT NULL
);

CREATE TABLE Laakari(
id SERIAL PRIMARY KEY,
etunimi varchar(20) NOT NULL,
sukunimi varchar(20) NOT NULL,
sv integer NOT NULL,
username varchar(20) NOT NULL,
password varchar(20) NOT NULL
);

CREATE TABLE Hoitopyynto(
id SERIAL PRIMARY KEY,
potilas_id INTEGER REFERENCES Potilas(id),
laakari_id INTEGER REFERENCES Laakari(id),
kayntipvm date
);

CREATE TABLE Raportti(
id SERIAL PRIMARY KEY,
hoitopyynto_id INTEGER REFERENCES Hoitopyynto(id),
laakari_id INTEGER REFERENCES Laakari(id),
pvm date,
input text
);

CREATE TABLE Hoitoohje(
id SERIAL PRIMARY KEY,
potilas_id INTEGER REFERENCES Potilas(id),
laakari_id INTEGER REFERENCES Laakari(id),
luontipvm date,
muokkauspvm date,
input text
);