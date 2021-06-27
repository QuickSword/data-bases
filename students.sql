CREATE TABLE users(
    log varchar(5) NOT NULL PRIMARY KEY,
    pass varchar(12) 
);
CREATE TABLE wybory
(
    id                 SERIAL PRIMARY KEY,
    nazwa              VARCHAR(12) NOT NULL,
    liczba_posad       NUMERIC     NOT NULL,
    termin_zgloszen    TIMESTAMP   NOT NULL,
    termin_rozpoczecia TIMESTAMP   NOT NULL,
    termin_zakonczenia TIMESTAMP   NOT NULL,
    CHECK ( liczba_posad > 0 ),
    CHECK ( termin_rozpoczecia >= wybory.termin_zgloszen),
    CHECK ( termin_zakonczenia >= wybory.termin_rozpoczecia )

);

CREATE TABLE wyborcy
(
    numer_indeksu VARCHAR(5) PRIMARY KEY REFERENCES users(log),
    imie          VARCHAR(12) NOT NULL,
    nazwisko      VARCHAR(19) NOT NULL,
    czy_komisja   BOOLEAN     NOT NULL DEFAULT FALSE
);

CREATE TABLE kandydaci
(
    id_wyborow         SERIAL REFERENCES wybory (id),
    kandydat           VARCHAR(5) NOT NULL PRIMARY KEY REFERENCES wyborcy
);

CREATE TABLE glosy(  
    id_wyborow SERIAL REFERENCES wybory(id),  
    nr_indeksu_wyborcy VARCHAR(5) NOT NULL REFERENCES wyborcy(numer_indeksu),  
    kandydat VARCHAR(5) REFERENCES kandydaci(kandydat), 
    PRIMARY KEY(id_wyborow, nr_indeksu_wyborcy) 
);
