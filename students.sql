DROP TABLE IF EXISTS wyborcy;

DROP TABLE IF EXISTS wybory;

DROP TABLE IF EXISTS kandydaci;

DROP TABLE IF EXISTS zgloszenia_kandydatow;

DROP TABLE IF EXISTS glosy;

CREATE TABLE wybory(
	id NUMERIC(9) PRIMARY KEY,
	nazwa VARCHAR(12) NOT NULL,
	liczba_posad NUMERIC NOT NULL,
	termin_zgloszen TIMESTAMP NOT NULL,
	termin_rozpoczecia TIMESTAMP NOT NULL,
	termin_zakonczenia TIMESTAMP NOT NULL
);

CREATE TABLE wyborcy(
	numer_indeksu NUMERIC(6) PRIMARY KEY,
	imie VARCHAR(12) NOT NULL,
	nazwisko VARCHAR(19) NOT NULL
);

CREATE TABLE zgloszenia_kandydatow(
	id_zgloszenia NUMERIC(6) PRIMARY KEY,
	id_wyborow NUMERIC(9) NOT NULL REFERENCES wybory(id),
	nr_indeksu_wyborcy NUMERIC(6) NOT NULL REFERENCES wyborcy,
	kandydat NUMERIC(6) NOT NULL REFERENCES wyborcy
);

CREATE TABLE kandydaci(
	nr_indeksu_kandydata NUMERIC(6) PRIMARY KEY REFERENCES wyborcy(numer_indeksu),
	id_wyborow NUMERIC(6) NOT NULL REFERENCES wybory(id)
);

CREATE TABLE glosy(
	id_wyborow NUMERIC(9) NOT NULL REFERENCES wybory(id),
	nr_indeksu_wyborcy NUMERIC(6) PRIMARY KEY REFERENCES wyborcy(numer_indeksu),
	kandydat NUMERIC(6) REFERENCES kandydaci(nr_indeksu_kandydata)
);





