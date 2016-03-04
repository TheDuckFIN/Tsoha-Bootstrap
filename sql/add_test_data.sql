INSERT INTO Forum_settings (name, msg_size) VALUES ('Keskustelupalsta', 25000);

INSERT INTO Usergroup (name, color, locked) VALUES ('Rekisteröitynyt käyttäjä', '#428bca', true);
INSERT INTO Usergroup (name, color, locked) VALUES ('Moderaattori', '#00FF00', true);
INSERT INTO Usergroup (name, color, locked) VALUES ('Ylläpitäjä', '#FF0000', true);

INSERT INTO Permission (usergroup_id, delete_thread, delete_message, edit_message, lock_thread, ban, boardmanagement, usergroupmanagement, settingsmanagement, usermanagement)
	VALUES (1, false, false, false, false, false, false, false, false, false);
INSERT INTO Permission (usergroup_id, delete_thread, delete_message, edit_message, lock_thread, ban, boardmanagement, usergroupmanagement, settingsmanagement, usermanagement)
    VALUES (2, true, true, true, true, true, false, false, false, false);
INSERT INTO Permission (usergroup_id, delete_thread, delete_message, edit_message, lock_thread, ban, boardmanagement, usergroupmanagement, settingsmanagement, usermanagement)
	VALUES (3, true, true, true, true, true, true, true, true, true);

INSERT INTO Achievement (name, description) VALUES ('Moderaattori', 'Oho, olet saavuttanut selvästi jotain suurta, sillä moderaattoriksi ei pääse ihan joka poika! Pidä hauskaa viestejä poistellessa! :)');
INSERT INTO Achievement (name, description) VALUES ('Ylläpitäjä', 'Olet kingi.');
INSERT INTO Achievement (name, description) VALUES ('Ensimmäinen viesti', 'Woohoo! Olet kirjoittanut ensimmäisen viestisi! Siitä se lähtee :)');
INSERT INTO Achievement (name, description) VALUES ('Kymmenen viestiä', 'Oho, sinäpäs olet vauhdissa! Kymmenen viestiä on jo melko paljon!');
INSERT INTO Achievement (name, description) VALUES ('50 viestiä', 'Jos viestien lähettämisestä palkittaisiin, saisit jo varmasti pronssia! Onnittelut!');
INSERT INTO Achievement (name, description) VALUES ('100 viestiä', 'Tämä alkaa olemaan jo hopeamitalin arvoinen suoritus... Oletko varma etteivät sormesi kulu puhki viestien kirjoittamisesta?');
INSERT INTO Achievement (name, description) VALUES ('200 viestiä', 'KULTAA!!! SE ON SIINÄ!!! Sormesi ovar varmaan jo ihan ruvilla, mutta ei se haittaa, SILLÄ VOITIT KULTAA!!!');

INSERT INTO Member (usergroup_id, username, password, email, show_email, registered) 
	VALUES  (3, 'admin', '$1$1T0gMIgx$SiM/dArM7CGQGg295Q4wd0', 'admin@email.com', true, CURRENT_TIMESTAMP);

INSERT INTO Member_achievement(member_id, achievement_id) VALUES (1, 1);
INSERT INTO Member_achievement(member_id, achievement_id) VALUES (1, 2);
INSERT INTO Member_achievement(member_id, achievement_id) VALUES (1, 3);

INSERT INTO Category (name) VALUES ('Oletuskategoria');

INSERT INTO Board (category_id, name, description) VALUES (1, 'Oletusalue', 'Valmiiksi generoitu keskustelualue');

INSERT INTO Thread (board_id, starter_id, title, locked) VALUES (1, 1, 'Tervetuloa käyttämään keskustelupalstaa!', false);

INSERT INTO Message (sender_id, thread_id, time, message, firstpost) 
    VALUES (1, 1, CURRENT_TIMESTAMP, '[b]Tämä on automaattisesti generoitu viesti, jossa saat muutamia ohjeita keskustelupalstan käyttöön.[/b]

    Aloittaaksesi keskustelupalstan käytön, tulee sinun konfiguroida keskustelupalstan asetukset mieleiseksisi. Voit kirjautua tälle ylläpitäjäkäyttäjälle seuraavilla tunnuksilla:

    [b]Tunnus:[/b] admin
    [b]Salasana:[/b] salasana
    
    Aluksi kannattaa luoda itsellesi uusi käyttäjä, jolle asetat yllä mainitulla käyttäjällä ylläpitäjä-statuksen hallintapaneelista. Alkuperäinen admin-käyttäjä kannattaa poistaa. Tämän jälkeen voit esimerkiksi vaihtaa keskustelualueen nimen mieleiseksesi hallintapaneelin etusivulta. Luo haluamasi kategoriat ja keskustelualueet hallintapaneelista. Voit halutessasi myös luoda uusia käyttäjäryhmiä, elleivät nykyiset vastaa tarpeitasi. Kaiken automaattisesti generoidun, kuten tämän viestin voit huoletta poistaa!

    Foorumilla on käytössä muutamia bbcode-tageja, kuten [ i ], [ b ] sekä [ u ]. Tuki on kuitenkin todella rajoittunut tässä versiossa. Hauskaa keskustelua!', true);