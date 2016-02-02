CREATE TABLE Käyttäjäryhmä (
	id SERIAL PRIMARY KEY,
	nimi varchar(20) NOT NULL,
	väri varchar(7) NOT NULL
);

CREATE TABLE Käyttäjä (
	id SERIAL PRIMARY KEY,
	Käyttäjäryhmä_id INTEGER REFERENCES Käyttäjäryhmä(id),
	käyttäjätunnus varchar(16) NOT NULL,
	salasana varchar(250) NOT NULL,
	email varchar(200) NOT NULL,
	näytä_email boolean NOT NULL DEFAULT TRUE,
	avatar varchar(200),
	info varchar(400)
);

CREATE TABLE Käyttöoikeudet (
	käyttäjäryhmä_id INTEGER REFERENCES Käyttäjäryhmä(id),
	keskustelun_poisto boolean NOT NULL DEFAULT FALSE,
	viestin_poisto boolean NOT NULL DEFAULT FALSE,
	viestin_muokkaaminen boolean NOT NULL DEFAULT FALSE,
	keskustelun_lukitseminen boolean NOT NULL DEFAULT FALSE,
	porttikielto boolean NOT NULL DEFAULT FALSE,
	keskustelualuehallinta boolean NOT NULL DEFAULT FALSE,
	Käyttäjäryhmähallinta boolean NOT NULL DEFAULT FALSE,
	asetushallinta boolean NOT NULL DEFAULT FALSE,
	käyttäjähallinta boolean NOT NULL DEFAULT FALSE
);

CREATE TABLE Kategoria (
	id SERIAL PRIMARY KEY,
	nimi varchar(50) NOT NULL
);

CREATE TABLE Aihealue (
	id SERIAL PRIMARY KEY,
	kategoria_id INTEGER REFERENCES Kategoria(id),
	nimi varchar(50) NOT NULL,
	kuvaus varchar(150)
);

CREATE TABLE Keskustelu (
	id SERIAL PRIMARY KEY,
	aihealue_id INTEGER REFERENCES Aihealue(id),
	aloittaja_id INTEGER REFERENCES Käyttäjä(id),
	otsikko varchar(50) NOT NULL,
	lukittu boolean NOT NULL DEFAULT FALSE
);

CREATE TABLE Viesti (
	id SERIAL PRIMARY KEY,
	keskustelu_id INTEGER REFERENCES Keskustelu(id),
	lähettäjä_id INTEGER REFERENCES Käyttäjä(id),
	aika timestamp NOT NULL,
	viesti text NOT NULL
);

CREATE TABLE Muokkaus (
	id SERIAL PRIMARY KEY,
	viesti_id INTEGER REFERENCES Viesti(id),
	muokkaaja_id INTEGER REFERENCES Käyttäjä(id),
	aika timestamp NOT NULL,
	kuvaus varchar(100) NOT NULL
);

CREATE TABLE Porttikielto (
	käyttäjä_id INTEGER REFERENCES Käyttäjä(id),
	moderaattori_id INTEGER REFERENCES Käyttäjä(id),
	alku timestamp NOT NULL,
	loppu timestamp NOT NULL,
	syy varchar(250) NOT NULL
);

CREATE TABLE Saavutus (
	id SERIAL PRIMARY KEY,
	nimi varchar(30) NOT NULL,
	kuvaus varchar(200) NOT NULL
);

CREATE TABLE Käyttäjän_saavutus (
	käyttäjä_id INTEGER REFERENCES Käyttäjä(id),
	saavutus_id INTEGER REFERENCES Saavutus(id)
);

CREATE TABLE Yksityisviesti (
	id SERIAL PRIMARY KEY,
	lähettäjä_id INTEGER REFERENCES Käyttäjä(id),
	otsikko varchar(50) NOT NULL,
	aika timestamp NOT NULL,
	viesti text NOT NULL
);

CREATE TABLE Saapunut_viesti (
	vastaanottaja_id INTEGER REFERENCES Käyttäjä(id),
	viesti_id INTEGER REFERENCES Yksityisviesti(id)
);


CREATE TABLE Foorumin_asetukset (
	nimi varchar(50) NOT NULL
);