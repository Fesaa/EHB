DROP TABLE ancienniteiten;
DROP TABLE inschrijvingen;
DROP TABLE cursussen;
DROP TABLE specialisaties;
DROP TABLE studenten;
DROP TABLE docenten;

CREATE TABLE docenten (
    docent_id NUMBER(7),
    voornaam VARCHAR2(255) NOT NULL,
    achternaam VARCHAR2(255) NOT NULL,
    woonplaats VARCHAR2(15) NOT NULL,
    aanstellingsdatum DATE NOT NULL,
    CONSTRAINT pk_docenten_docent_id PRIMARY KEY (docent_id)
);

CREATE TABLE studenten (
  student_id NUMBER(7),
  voornaam VARCHAR2(255) NOT NULL,
  achternaam VARCHAR2(255) NOT NULL,
  geboortedatum DATE DEFAULT NULL,
  CONSTRAINT pk_studenten_student_id PRIMARY KEY (student_id)
);

CREATE TABLE specialisaties (
    specialisatie_id NUMBER(11),
    code VARCHAR2(8) NOT NULL,
    naam VARCHAR2(50) DEFAULT NULL,
    CONSTRAINT pk_specialisaties_specialisatie_id PRIMARY KEY (specialisatie_id),
    CONSTRAINT unique_specialisaties_code UNIQUE (code)
);

CREATE TABLE cursussen (
    cursusnr NUMBER(11),
    docent_id NUMBER(7) NOT NULL,
    specialisatie_id NUMBER(11) DEFAULT NULL,
    titel VARCHAR2(50) NOT NULL,
    studiepunten NUMBER(2) NOT NULL,
    bijkomende_kost NUMBER(4, 2) DEFAULT 0,
    CONSTRAINT pk_cursussen_cursusnr PRIMARY KEY (cursusnr),
    CONSTRAINT fk_cursussen_docenten_docent_id FOREIGN KEY (docent_id) REFERENCES docenten(docent_id),
    CONSTRAINT fk_cursussen_specialisaties_specialisatie_id FOREIGN KEY (specialisatie_id) REFERENCES specialisaties(specialisatie_id),
    CONSTRAINT unique_cursussen_titel UNIQUE (titel)
);

CREATE TABLE inschrijvingen (
    student_id NUMBER(7),
    cursusnr NUMBER(11),
    kost_betaald NUMBER(4, 2) NOT NULL,
    CONSTRAINT pk_inschrijvingen_student_id_cursusnr PRIMARY KEY (student_id, cursusnr),
    CONSTRAINT fk_inschrijvingen_studenten_student_id FOREIGN KEY (student_id) REFERENCES studenten(student_id),
    CONSTRAINT fk_inschrijvingen_studenten_cursusnr FOREIGN KEY (cursusnr) REFERENCES cursussen(cursusnr)
);

CREATE TABLE ancienniteiten (
    jaar NUMBER(2),
    basis NUMBER NOT NULL,
    extra NUMBER(8,2) NOT NULL,
    CONSTRAINT pk_acienniteiten_jaar PRIMARY KEY (jaar)
);

ALTER TABLE inschrijvingen ADD punten NUMBER(2);
ALTER TABLE docenten MODIFY woonplaats VARCHAR2(150);
ALTER TABLE ancienniteiten DROP COLUMN extra;
ALTER TABLE ancienniteiten RENAME COLUMN basis TO salaris;

INSERT INTO docenten (docent_id, voornaam, achternaam, woonplaats, aanstellingsdatum) VALUES (1234567, 'Dominik', 'Schellen', 'Westende', '01-NOV-2017');
INSERT INTO docenten (docent_id, voornaam, achternaam, woonplaats, aanstellingsdatum) VALUES (1234555, 'Hans', 'Beenhakker', 'Leuven', '08-DEC-2018');
INSERT INTO docenten (docent_id, voornaam, achternaam, woonplaats, aanstellingsdatum) VALUES (1234527, 'Leena', 'Schmidt', 'Doische', '05-JAN-2015');
INSERT INTO docenten (docent_id, voornaam, achternaam, woonplaats, aanstellingsdatum) VALUES (3210007, 'Eman', 'Davids', 'Court-Saint-Etienne', '07-AUG-2011');

INSERT INTO studenten (student_id, voornaam, achternaam, geboortedatum) VALUES (1234567, 'Letitia', 'Dijksnam', '31-MAR-1990');
INSERT INTO studenten (student_id, voornaam, achternaam, geboortedatum) VALUES (1234513, 'Siegfried', 'Willigenburg', '19-NOV-1996');
INSERT INTO studenten (student_id, voornaam, achternaam, geboortedatum) VALUES (1321012, 'David', 'Akkerman', '01-NOV-1987');

INSERT INTO specialisaties (specialisatie_id, code, naam) VALUES (1, 'BAMCTMAW', 'Mobile App and Web');
INSERT INTO specialisaties (specialisatie_id, code, naam) VALUES (2, 'BAMCTART', 'Art and Technology');
INSERT INTO specialisaties (specialisatie_id, code, naam) VALUES (3, 'BAICTBIT', 'Business IT');
INSERT INTO specialisaties (specialisatie_id, code, naam) VALUES (4, 'BAICTNWS', 'Networks and Security');
INSERT INTO specialisaties (specialisatie_id, code, naam) VALUES (5, 'BAICTSWE', 'Software Engineering');

--INSERT INTO cursussen (cursusnr, docent_id, specialisatie_id, titel, studiepunten, bijkomende_kost) VALUES (100, 1234565, DEFAULT, 'SQL', 3, NULL);
INSERT INTO cursussen (cursusnr, docent_id, specialisatie_id, titel, studiepunten, bijkomende_kost) VALUES (200, 1234567, DEFAULT, 'SQL', 3, NULL);
INSERT INTO cursussen (cursusnr, docent_id, specialisatie_id, titel, studiepunten, bijkomende_kost) VALUES (111, 1234555, 5, 'Android', 4, 80.25);
INSERT INTO cursussen (cursusnr, docent_id, specialisatie_id, titel, studiepunten, bijkomende_kost) VALUES (123, 1234567, 4, 'Networking', 3, 50);
INSERT INTO cursussen (cursusnr, docent_id, specialisatie_id, titel, studiepunten, bijkomende_kost) VALUES (321, 1234555, 2, 'Design fundamentals', 2, 10.25);

INSERT INTO inschrijvingen (student_id, cursusnr, kost_betaald) VALUES (1234567, 111, 70);
INSERT INTO inschrijvingen (student_id, cursusnr, kost_betaald) VALUES (1234513, 123, 100.50);
--INSERT INTO inschrijvingen (student_id, cursusnr, kost_betaald) VALUES (1234513, 321, NULL);

INSERT INTO ancienniteiten (jaar, salaris) VALUES (1, 1000);
INSERT INTO ancienniteiten (jaar, salaris) VALUES (2, 1100);
INSERT INTO ancienniteiten (jaar, salaris) VALUES (3, 1200);


DELETE FROM inschrijvingen WHERE student_id = 1234567;
UPDATE inschrijvingen SET inschrijvingen.punten = 10 WHERE cursusnr = 111;

INSERT INTO studenten (student_id, voornaam, achternaam, geboortedatum) VALUES (0987654, 'Ameliah', 'Palmaers', DEFAULT);
INSERT INTO inschrijvingen (student_id, cursusnr, kost_betaald) VALUES (0987654, 200, DEFAULT);
INSERT INTO inschrijvingen (student_id, cursusnr, kost_betaald) VALUES (0987654, 111, DEFAULT);

UPDATE
    cursussen
SET
    docent_id =
        (SELECT
             docent_id
         FROM
             docenten
         WHERE
             voornaam = 'Leena'
         AND
            achternaam = 'Schmidt'
        )
WHERE
    docent_id =
        (SELECT
             docent_id
         FROM
             docenten
         WHERE
             voornaam = 'Hans'
         AND
            achternaam = 'Beenhakker'
         );
