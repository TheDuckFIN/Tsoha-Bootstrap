INSERT INTO Forum_settings (name, msg_size) VALUES ('Keskustelupalsta', 25000);

INSERT INTO Usergroup (name, color, locked) VALUES ('Rekisteröitynyt käyttäjä', '#333333', true);
INSERT INTO Usergroup (name, color, locked) VALUES ('Moderaattori', '#00FF00', true);
INSERT INTO Usergroup (name, color, locked) VALUES ('Ylläpitäjä', '#FF0000', true);

INSERT INTO Permission (usergroup_id, delete_thread, delete_message, edit_message, lock_thread, ban, boardmanagement, usergroupmanagement, settingsmanagement, usermanagement)
	VALUES (1, false, false, false, false, false, false, false, false, false);
INSERT INTO Permission (usergroup_id, delete_thread, delete_message, edit_message, lock_thread, ban, boardmanagement, usergroupmanagement, settingsmanagement, usermanagement)
    VALUES (2, true, true, true, true, true, false, false, false, false);
INSERT INTO Permission (usergroup_id, delete_thread, delete_message, edit_message, lock_thread, ban, boardmanagement, usergroupmanagement, settingsmanagement, usermanagement)
	VALUES (3, true, true, true, true, true, true, true, true, true);

INSERT INTO Achievement (name, description) VALUES ('Rekisteröitynyt käyttäjä', 'Olet onnistuneesti luonut käyttäjän foorumille! Mahtavaa! Tervetuloa joukkoomme :)');
INSERT INTO Achievement (name, description) VALUES ('Moderaattori', 'Oho, olet saavuttanut selvästi jotain suurta, sillä moderaattoriksi ei pääse ihan joka poika! Pidä hauskaa viestejä poistellessa! :)');
INSERT INTO Achievement (name, description) VALUES ('Ylläpitäjä', 'Olet kingi.');
INSERT INTO Achievement (name, description) VALUES ('Ensimmäinen viesti', 'Woohoo! Olet kirjoittanut ensimmäisen viestisi! Siitä se lähtee :)');
INSERT INTO Achievement (name, description) VALUES ('Kymmenen viestiä', 'Oho, sinäpäs olet vauhdissa! Kymmenen viestiä on jo melko paljon!');
INSERT INTO Achievement (name, description) VALUES ('50 viestiä', 'Jos viestien lähettämisestä palkittaisiin, saisit jo varmasti pronssia! Onnittelut!');
INSERT INTO Achievement (name, description) VALUES ('100 viestiä', 'Tämä alkaa olemaan jo hopeamitalin arvoinen suoritus... Oletko varma etteivät sormesi kulu puhki viestien kirjoittamisesta?');
INSERT INTO Achievement (name, description) VALUES ('200 viestiä', 'KULTAA!!! SE ON SIINÄ!!! Sormesi ovar varmaan jo ihan ruvilla, mutta ei se haittaa, SILLÄ VOITIT KULTAA!!!');





INSERT INTO Member (usergroup_id, username, password, email, show_email, registered) 
	VALUES  (3, 'vlakanie', '$1$1T0gMIgx$SiM/dArM7CGQGg295Q4wd0', 'testi@testi.fi', true, CURRENT_TIMESTAMP);
INSERT INTO Member (usergroup_id, username, password, email, show_email, registered) 
	VALUES  (1, 'jorma', '$1$1T0gMIgx$SiM/dArM7CGQGg295Q4wd0', 'testi@testi.fi', true, CURRENT_TIMESTAMP);
INSERT INTO Member (usergroup_id, username, password, email, show_email, registered) 
	VALUES  (2, 'modemies', '$1$1T0gMIgx$SiM/dArM7CGQGg295Q4wd0', 'testi@testi.fi', true, CURRENT_TIMESTAMP);
INSERT INTO Member (usergroup_id, username, password, email, show_email, registered) 
    VALUES  (1, 'matti', '$1$1T0gMIgx$SiM/dArM7CGQGg295Q4wd0', 'testi@testi.fi', true, CURRENT_TIMESTAMP);
INSERT INTO Member (usergroup_id, username, password, email, show_email, registered) 
    VALUES  (1, 'testi1', '$1$1T0gMIgx$SiM/dArM7CGQGg295Q4wd0', 'testi@testi.fi', true, CURRENT_TIMESTAMP);
INSERT INTO Member (usergroup_id, username, password, email, show_email, registered) 
    VALUES  (1, 'testi2', '$1$1T0gMIgx$SiM/dArM7CGQGg295Q4wd0', 'testi@testi.fi', true, CURRENT_TIMESTAMP);
INSERT INTO Member (usergroup_id, username, password, email, show_email, registered) 
    VALUES  (1, 'käyttäjä', '$1$1T0gMIgx$SiM/dArM7CGQGg295Q4wd0', 'testi@testi.fi', true, CURRENT_TIMESTAMP);

INSERT INTO Member_achievement(member_id, achievement_id) VALUES (1, 1);
INSERT INTO Member_achievement(member_id, achievement_id) VALUES (1, 3);
INSERT INTO Member_achievement(member_id, achievement_id) VALUES (1, 4);
INSERT INTO Member_achievement(member_id, achievement_id) VALUES (1, 5);

INSERT INTO Category (name) VALUES ('Yleinen');

INSERT INTO Board (category_id, name, description) VALUES (1, 'Testialue', 'Alueen kuvaus');
INSERT INTO Board (category_id, name, description) VALUES (1, 'Testialue 2', 'Alueen kuvaus! BLAA BLAA');

INSERT INTO Category (name) VALUES ('Taide');

INSERT INTO Board (category_id, name, description) VALUES (2, 'Kuvataide', 'Piirustuksia!');
INSERT INTO Board (category_id, name, description) VALUES (2, 'Musiikki', 'Lallalalalaa');
INSERT INTO Board (category_id, name, description) VALUES (2, 'Nykytaide', 'Anything');

INSERT INTO Thread (board_id, starter_id, title, locked) VALUES (1, 3, 'Keskustelu 1', false);
INSERT INTO Thread (board_id, starter_id, title, locked) VALUES (1, 1, 'KeskusSAJDJA', false);
INSERT INTO Thread (board_id, starter_id, title, locked) VALUES (1, 2, 'TESTI', true);
INSERT INTO Thread (board_id, starter_id, title, locked) VALUES (1, 1, 'Jassooo', false);

INSERT INTO Thread (board_id, starter_id, title, locked) VALUES (2, 2, 'adsadsa asdasd', false);
INSERT INTO Thread (board_id, starter_id, title, locked) VALUES (2, 3, 'KeskAAIJFLSKAL', false);
INSERT INTO Thread (board_id, starter_id, title, locked) VALUES (2, 1, 'örpöpröpö', false);

INSERT INTO Message (sender_id, thread_id, time, message, firstpost) VALUES (3, 1, CURRENT_TIMESTAMP, 'Lorem ipsum...', true);
INSERT INTO Message (sender_id, thread_id, time, message) VALUES (2, 1, CURRENT_TIMESTAMP, 'Loreadsdsam ipsum...');
INSERT INTO Message (sender_id, thread_id, time, message) VALUES (2, 1, CURRENT_TIMESTAMP, 'Lorem ipsdsadasum...');

INSERT INTO Message (sender_id, thread_id, time, message, firstpost) VALUES (1, 2, CURRENT_TIMESTAMP, 'Lorem asdadasd...', true);

INSERT INTO Message (sender_id, thread_id, time, message, firstpost) VALUES (2, 3, CURRENT_TIMESTAMP, 'Loreasddasdm ipasddsasum...', true);
INSERT INTO Message (sender_id, thread_id, time, message) VALUES (1, 3, CURRENT_TIMESTAMP, 'Loreasdasdsadasdm ipsum...');
INSERT INTO Message (sender_id, thread_id, time, message) VALUES (1, 3, CURRENT_TIMESTAMP, 'Loreasddasasdsaasdm ipsum...');
INSERT INTO Message (sender_id, thread_id, time, message) VALUES (3, 3, CURRENT_TIMESTAMP, 'Loreasdadaadasdm ipsum...');
INSERT INTO Message (sender_id, thread_id, time, message) VALUES (2, 3, CURRENT_TIMESTAMP, 'Loreasddasdm iasdsapsum...');

INSERT INTO Message (sender_id, thread_id, time, message, firstpost) VALUES (1, 4, CURRENT_TIMESTAMP, 'Lorem ipsum...', true);
INSERT INTO Message (sender_id, thread_id, time, message, firstpost) VALUES (2, 5, CURRENT_TIMESTAMP, 'Lortretretwem igfdgfdgfdpsum...', true);
INSERT INTO Message (sender_id, thread_id, time, message, firstpost) VALUES (3, 6, CURRENT_TIMESTAMP, 'Lorem ipsuytrtrurm...', true);
INSERT INTO Message (sender_id, thread_id, time, message, firstpost) VALUES (1, 7, CURRENT_TIMESTAMP, 'Loremasddsadsa ipsum...', true);