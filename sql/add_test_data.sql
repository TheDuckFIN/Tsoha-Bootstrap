INSERT INTO Usergroup (name, color, locked) VALUES ('Ylläpitäjä', '#FF0000', true);
INSERT INTO Usergroup (name, color, locked) VALUES ('Moderaattori', '#00FF00', true);

INSERT INTO Permission (usergroup_id, delete_thread, delete_message, edit_message, lock_thread, ban, boardmanagement, usergroupmanagement, settingsmanagement, usermanagement)
	VALUES (1, true, true, true, true, true, true, true, true, true);
INSERT INTO Permission (usergroup_id, delete_thread, delete_message, edit_message, lock_thread, ban, boardmanagement, usergroupmanagement, settingsmanagement, usermanagement)
	VALUES (2, true, true, true, true, true, false, false, false, false);

INSERT INTO Member (usergroup_id, username, password, email, show_email) 
	VALUES  (1, 'vlakanie', 'salasana', 'testi@testi.fi', true);

INSERT INTO Category (name) VALUES ('Yleinen');

INSERT INTO Board (category_id, name, description) VALUES (1, 'Testialue', 'Alueen kuvaus');
INSERT INTO Board (category_id, name, description) VALUES (1, 'Testialue 2', 'Alueen kuvaus! BLAA BLAA');

INSERT INTO Category (name) VALUES ('Taide');

INSERT INTO Board (category_id, name, description) VALUES (2, 'Kuvataide', 'Piirustuksia!');
INSERT INTO Board (category_id, name, description) VALUES (2, 'Musiikki', 'Lallalalalaa');
INSERT INTO Board (category_id, name, description) VALUES (2, 'Nykytaide', 'Anything');