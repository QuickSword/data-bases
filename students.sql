CREATE TABLE wybory(
	id NUMERIC(9) PRIMARY KEY,
	nazwa VARCHAR(12) NOT NULL,
	liczba_posad NUMERIC NOT NULL,
	termin_zgloszen TIMESTAMP NOT NULL,
	termin_rozpoczecia TIMESTAMP NOT NULL,
	termin_zakonczenia TIMESTAMP NOT NULL,
	CHECK ( liczba_posad > 0 ),
	CHECK ( termin_rozpoczecia >  wybory.termin_zgloszen),
	CHECK ( termin_zakonczenia > wybory.termin_rozpoczecia )

);

CREATE TABLE wyborcy(
	numer_indeksu NUMERIC(6) PRIMARY KEY,
	imie VARCHAR(12) NOT NULL,
	nazwisko VARCHAR(19) NOT NULL,
	czy_komisja BOOLEAN NOT NULL DEFAULT FALSE
);

CREATE TABLE kandydaci(
	id_wyborow NUMERIC(9) NOT NULL REFERENCES wybory(id),
	nr_indeksu_wyborcy NUMERIC(6) NOT NULL REFERENCES wyborcy,
	kandydat NUMERIC(6) NOT NULL PRIMARY KEY REFERENCES wyborcy,
	czy_wybrany BOOLEAN NOT NULL DEFAULT FALSE
);

CREATE TABLE glosy(
	id_wyborow NUMERIC(9) NOT NULL REFERENCES wybory(id),
	nr_indeksu_wyborcy NUMERIC(6) PRIMARY KEY REFERENCES wyborcy(numer_indeksu),
	kandydat NUMERIC(6) REFERENCES kandydaci(kandydat)
);

CREATE TABLE wyniki(
  id_wyborow NUMERIC(9) NOT NULL REFERENCES wybory(id),
  kandydat NUMERIC(6) NOT NULL PRIMARY KEY REFERENCES  kandydaci(kandydat),
  liczba_glosow NUMERIC
);





