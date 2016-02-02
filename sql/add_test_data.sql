INSERT INTO Käyttäjäryhmä (nimi, väri) VALUES ('Ylläpitäjä', '#FF0000');
INSERT INTO Käyttäjäryhmä (nimi, väri) VALUES ('Moderaattori', '#00FF00');

INSERT INTO Käyttöoikeudet (käyttäjäryhmä_id, keskustelun_poisto, viestin_poisto, viestin_muokkaaminen, keskustelun_lukitseminen, porttikielto, keskustelualuehallinta, Käyttäjäryhmähallinta, asetushallinta, käyttäjähallinta)
	VALUES (1, true, true, true, true, true, true, true, true, true);
INSERT INTO Käyttöoikeudet (käyttäjäryhmä_id, keskustelun_poisto, viestin_poisto, viestin_muokkaaminen, keskustelun_lukitseminen, porttikielto, keskustelualuehallinta, Käyttäjäryhmähallinta, asetushallinta, käyttäjähallinta)
	VALUES (2, true, true, true, true, true, false, false, false, false);

INSERT INTO Käyttäjä (käyttäjäryhmä_id, Käyttäjätunnus, salasana, email, näytä_email) 
	VALUES  (1, 'vlakanie', 'salasana', 'testi@testi.fi', true);

INSERT INTO Kategoria (nimi) VALUES ('Yleinen');

INSERT INTO Aihealue (kategoria_id, nimi, kuvaus) VALUES (1, 'Testialue', 'Alueen kuvaus');
INSERT INTO Aihealue (kategoria_id, nimi, kuvaus) VALUES (1, 'Testialue 2', 'Alueen kuvaus! BLAA BLAA');