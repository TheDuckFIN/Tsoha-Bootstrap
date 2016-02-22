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

INSERT INTO Member (usergroup_id, username, password, email, show_email, registered) 
	VALUES  (3, 'vlakanie', 'salasana', 'testi@testi.fi', true, CURRENT_TIMESTAMP);
INSERT INTO Member (usergroup_id, username, password, email, show_email, registered) 
	VALUES  (1, 'jorma', 'salasana', 'testi@testi.fi', true, CURRENT_TIMESTAMP);
INSERT INTO Member (usergroup_id, username, password, email, show_email, registered) 
	VALUES  (2, 'modemies', 'salasana', 'testi@testi.fi', true, CURRENT_TIMESTAMP);

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