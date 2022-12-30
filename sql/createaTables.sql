CREATE TABLE asiakas (  
    id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    etunimi VARCHAR(255) NOT NULL,
    sukunimi VARCHAR(255) NOT NULL,
    osoite VARCHAR(40) NOT NULL,
    sposti VARCHAR(40) NOT NULL,
    postinro VARCHAR(5) NOT NULL,
    Postitmp VARCHAR(20) NOT NULL,
    puhnro VARCHAR(255) NOT NULL,
    salasana VARCHAR(255) NOT NULL
);


CREATE TABLE tilaus (
    tilausnro INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    id INT,
    tila VARCHAR(30),
    tilauspvm DATETIME,
    summa DECIMAL(10,2),
    FOREIGN KEY (id)
        REFERENCES asiakas(id)
        ON DELETE CASCADE
);

CREATE TABLE tuoteryhma(
    trid INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    trnimi varchar(60)
);

CREATE TABLE tuote (
    tuoteid INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    nimi VARCHAR(100) NOT NULL,
    hinta DECIMAL(10,2) ,
    trid INT ,
    kuva VARCHAR(50),
    saldo SMALLINT,
    koko VARCHAR(10),
    FOREIGN KEY (trid) 
        REFERENCES tuoteryhma(trid)
);
CREATE TABLE tilausrivi (
    tilausnro SMALLINT,
    rivinro INT(5),
    tuoteid INT,
    kpl SMALLINT,
    FOREIGN KEY (tilausnro)
        REFERENCES tilaus(tilausnro),
    FOREIGN KEY (tuoteid)
        REFERENCES tuote(tuoteid)
);