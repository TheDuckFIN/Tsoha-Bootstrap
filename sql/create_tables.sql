CREATE TABLE Usergroup (
	id SERIAL PRIMARY KEY,
	name varchar(50) NOT NULL,
	color varchar(7) NOT NULL,
	locked boolean NOT NULL 
);

CREATE TABLE Member (
	id SERIAL PRIMARY KEY,
	usergroup_id INTEGER REFERENCES Usergroup(id),
	username varchar(16) NOT NULL,
	password varchar(250) NOT NULL,
	email varchar(200) NOT NULL,
	show_email boolean NOT NULL DEFAULT TRUE,
	avatar varchar(200),
	info varchar(400)
);

CREATE TABLE Permission (
	usergroup_id INTEGER REFERENCES Usergroup(id),
	delete_thread boolean NOT NULL DEFAULT FALSE,
	delete_message boolean NOT NULL DEFAULT FALSE,
	edit_message boolean NOT NULL DEFAULT FALSE,
	lock_thread boolean NOT NULL DEFAULT FALSE,
	ban boolean NOT NULL DEFAULT FALSE,
	boardmanagement boolean NOT NULL DEFAULT FALSE,
	usergroupmanagement boolean NOT NULL DEFAULT FALSE,
	settingsmanagement boolean NOT NULL DEFAULT FALSE,
	usermanagement boolean NOT NULL DEFAULT FALSE
);

CREATE TABLE Category (
	id SERIAL PRIMARY KEY,
	name varchar(50) NOT NULL
);

CREATE TABLE Board (
	id SERIAL PRIMARY KEY,
	category_id INTEGER REFERENCES Category(id),
	name varchar(50) NOT NULL,
	description varchar(150)
);

CREATE TABLE Thread (
	id SERIAL PRIMARY KEY,
	board_id INTEGER REFERENCES Board(id),
	starter_id INTEGER REFERENCES Member(id),
	title varchar(50) NOT NULL,
	locked boolean NOT NULL DEFAULT FALSE
);

CREATE TABLE Message (
	id SERIAL PRIMARY KEY,
	thread_id INTEGER REFERENCES Thread(id),
	sender_id INTEGER REFERENCES Member(id),
	time timestamp NOT NULL,
	message text NOT NULL
);

CREATE TABLE Edit (
	id SERIAL PRIMARY KEY,
	message_id INTEGER REFERENCES Message(id),
	editor_id INTEGER REFERENCES Member(id),
	time timestamp NOT NULL,
	description varchar(100) NOT NULL
);

CREATE TABLE Ban (
	id SERIAL PRIMARY KEY,
	member_id INTEGER REFERENCES Member(id),
	moderator_id INTEGER REFERENCES Member(id),
	start_time timestamp NOT NULL,
	end_time timestamp NOT NULL,
	reason varchar(250) NOT NULL
);

CREATE TABLE Achievement (
	id SERIAL PRIMARY KEY,
	name varchar(30) NOT NULL,
	description varchar(200) NOT NULL
);

CREATE TABLE Member_achievement (
	member_id INTEGER REFERENCES Member(id),
	achievement_id INTEGER REFERENCES Achievement(id)
);

CREATE TABLE Private_message (
	id SERIAL PRIMARY KEY,
	sender_id INTEGER REFERENCES Member(id),
	title varchar(50) NOT NULL,
	time timestamp NOT NULL,
	message text NOT NULL
);

CREATE TABLE Received_message (
	receiver_id INTEGER REFERENCES Member(id),
	message_id INTEGER REFERENCES Private_message(id)
);


CREATE TABLE Forum_settings (
	name varchar(50) NOT NULL
);