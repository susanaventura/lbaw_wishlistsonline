--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

DROP SCHEMA IF EXISTS wishlists_online_dev CASCADE;
CREATE SCHEMA wishlists_online_dev;
ALTER SCHEMA wishlists_online_dev OWNER TO lbaw1465;

SET search_path = wishlists_online_dev, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;


DROP TABLE IF EXISTS Authenticated_User CASCADE;
DROP TABLE IF EXISTS Country CASCADE;
DROP TABLE IF EXISTS Chat_Message CASCADE;
DROP TABLE IF EXISTS Report CASCADE;
DROP TABLE IF EXISTS Friend CASCADE;
DROP TABLE IF EXISTS Follow CASCADE;
DROP TABLE IF EXISTS Wishlist CASCADE;
DROP TABLE IF EXISTS wishlist_occasion CASCADE;
DROP TABLE IF EXISTS Wishlist_Item CASCADE;
DROP TABLE IF EXISTS Forum_Post CASCADE;
DROP TABLE IF EXISTS Reputation CASCADE;
DROP TABLE IF EXISTS Notification CASCADE;
DROP TABLE IF EXISTS Friend_Request_Notification CASCADE;
DROP TABLE IF EXISTS Forum_Post_Rating_Notification CASCADE;
DROP TABLE IF EXISTS wishlist_notification CASCADE;
DROP TABLE IF EXISTS Message_Notification CASCADE;
DROP TABLE IF EXISTS Message CASCADE;
DROP TABLE IF EXISTS Email_Confirmation CASCADE;
DROP TABLE IF EXISTS password_recovery CASCADE;
DROP TABLE IF EXISTS feed CASCADE;


-- Country
CREATE TABLE Country (
	id serial PRIMARY KEY,
	name text UNIQUE NOT NULL
);

--Authenticated USER
CREATE TABLE Authenticated_User (
    id serial PRIMARY KEY, 
    active bool DEFAULT false NOT NULL,
	admin_rights bool DEFAULT false NOT NULL,
	birth_date date NOT NULL,
	email text UNIQUE NOT NULL,
	first_name text NOT NULL,
	last_name text NOT NULL,
	gender char(1) NOT NULL CHECK(gender = 'F' OR gender = 'M'),
	password text NOT NULL,
	profile_image text,
	username text UNIQUE NOT NULL,
	last_login timestamptz,
	register_date timestamptz NOT NULL,
	country int CONSTRAINT country_ref REFERENCES Country,
	online timestamptz DEFAULT false NOT NULL,
	search_tsvector tsvector
);


--Chat_Message
CREATE TABLE Chat_Message(
	id SERIAL PRIMARY KEY,
	date timestamptz NOT NULL,
	message text NOT NULL,
	author int REFERENCES Authenticated_User ON DELETE CASCADE,
	receiver int REFERENCES Authenticated_User ON DELETE CASCADE,
	CONSTRAINT author_dif_receiver CHECK (author != receiver)
);




--Friend
CREATE TABLE Friend (
	user1 int REFERENCES authenticated_user ON DELETE CASCADE,
	user2 int REFERENCES authenticated_user ON DELETE CASCADE,
	CONSTRAINT user1_dif_user2 CHECK(
		user1 != user2
	),
	PRIMARY KEY(user1,user2)
);


--Follow
CREATE TABLE Follow (
	follower int REFERENCES authenticated_user ON DELETE CASCADE,
	followed int REFERENCES authenticated_user ON DELETE CASCADE,
	CONSTRAINT follower_dif_followed CHECK(
		follower != followed
	),
	PRIMARY KEY(follower,followed)
);



--wishlist_occasion

CREATE TABLE wishlist_occasion(
	id serial PRIMARY KEY,
	occasion_name text UNIQUE NOT NULL
);


--Wishlist
CREATE TABLE Wishlist (
	id serial PRIMARY KEY,
	owner int NOT NULL REFERENCES authenticated_user ON DELETE CASCADE,
	creation_date timestamptz NOT NULL,
	last_edit_date timestamptz NOT NULL, --alterar no esquema
	password text,
	privacy int NOT NULL DEFAULT 0, --0 (“Private”), 1 (“Only Friends”), 2 (“Public”)
	title text NOT NULL,
	occasion int NOT NULL REFERENCES wishlist_occasion,
	search_tsvector tsvector,
	CONSTRAINT edit_after_creation CHECK(
		last_edit_date >= creation_date 
	),
	CONSTRAINT valid_privacy CHECK(
		privacy = 0 OR privacy = 1 OR privacy = 2
	)
);



--wishlist_item
CREATE TABLE wishlist_item (
	id serial,
	wishlist int REFERENCES wishlist ON DELETE CASCADE,
	image text,
	link text,
	name text NOT NULL,
	note text,
	price float DEFAULT 0.0,
	rating float,
	giver int REFERENCES authenticated_userON DELETE CASCADE,
	PRIMARY KEY(id, wishlist)
);


--forum_post
CREATE TABLE forum_post (
	id serial PRIMARY KEY,
	creation_date timestamptz NOT NULL,
	message text NOT NULL,
	owner int NOT NULL REFERENCES authenticated_userON DELETE CASCADE,
	wishlist int NOT NULL REFERENCES wishlist,
	main_post int REFERENCES forum_post
	CONSTRAINT id_dif_main_post CHECK (
		id != main_post
	)
);


--reputation
CREATE TABLE reputation (
	auth_user int REFERENCES authenticated_user ON DELETE CASCADE,
	forum_post int REFERENCES forum_postON DELETE CASCADE,
	reputation int NOT NULL CHECK(
		reputation = 1 or reputation = 0
	),
	PRIMARY KEY(auth_user, forum_post)
);

--notification
CREATE TABLE notification(
	id serial PRIMARY KEY,
	date timestamptz NOT NULL,
	seen bool NOT NULL DEFAULT false,
	receiver int NOT NULL REFERENCES authenticated_user
);


--friend_request_notification
CREATE TABLE friend_request_notification(
	notification int PRIMARY KEY REFERENCES notification,
	sender int NOT NULL REFERENCES authenticated_user
);

--forum_post_rating_notification
CREATE TABLE forum_post_rating_notification(
	notification int PRIMARY KEY REFERENCES notification,
	auth_user int NOT NULL,
	forum_post int NOT NULL,
	FOREIGN KEY(auth_user, forum_post) REFERENCES reputation(auth_user, forum_post)
);


--forum_post_notification
CREATE TABLE forum_post_notification(
	notification int PRIMARY KEY REFERENCES notification,
	forum_post int REFERENCES forum_post,
	forum_reply int REFERENCES forum_post,
	CONSTRAINT post_nn CHECK(
		(forum_reply NOTNULL AND forum_post ISNULL)
		OR
		(forum_post NOTNULL AND forum_reply ISNULL)
	)
);

--wishlist_notification
CREATE TABLE wishlist_notification(
	notification int PRIMARY KEY REFERENCES notification,
	deletedItemName text,
	deletedWishlistName text,
	editedWishlistItem int,
	editedWishlist int,
	FOREIGN KEY(editedWishlistItem, editedWishlist) REFERENCES wishlist_item(id, wishlist),
	CONSTRAINT wishlist_nn CHECK(
		(deletedItemName NOTNULL AND deletedWishlistName ISNULL AND editedWishlistItem ISNULL AND editedWishlist ISNULL)
		OR
		(deletedWishlistName NOTNULL AND deletedItemName ISNULL AND editedWishlistItem ISNULL AND editedWishlist ISNULL)
		OR
		(editedWishlistItem NOTNULL AND editedWishlist NOTNULL AND deletedWishlistName ISNULL AND deletedItemName IS NULL)
	)
);

CREATE TABLE wishlist_item_giver_notification(
	notification int PRIMARY KEY REFERENCES notification,
	item int, wishlist int,
	FOREIGN KEY(item, wishlist) REFERENCES wishlist_item(id, wishlist),
	new_giver int REFERENCES authenticated_user
);


--message
CREATE TABLE message(
	id serial PRIMARY KEY,
	date timestamptz NOT NULL,
	message text NOT NULL,
	author int NOT NULL REFERENCES authenticated_user,
	receiver int NOT NULL REFERENCES authenticated_user
);

--message_notification
CREATE TABLE message_notification(
	notification int PRIMARY KEY REFERENCES notification,
	message int NOT NULL REFERENCES message
);


--message
CREATE TABLE support_msg(
	id serial PRIMARY KEY,
	date timestamptz NOT NULL,
	subject text NOT NULL,
	subject_area int NOT NULL REFERENCES support_msg_subject_areas,
	message text NOT NULL,
	author int NOT NULL REFERENCES authenticated_user,
	seen bool NOT NULL DEFAULT false
);


CREATE TABLE support_msg_subject_areas(
	id serial PRIMARY KEY,
	name text UNIQUE NOT NULL
);


--email confirmation
CREATE TABLE email_confirmation(
	confirmationKey text PRIMARY KEY,
	auth_user int UNIQUE NOT NULL REFERENCES authenticated_user
);


--Report
CREATE TABLE Report(
	id serial PRIMARY KEY,
	date timestamptz NOT NULL,
	reason text,
	author int NOT NULL REFERENCES Authenticated_User,
	responsable_admin int REFERENCES Authenticated_User,
	reported_wishlist int REFERENCES Wishlist,
	reported_forum_post int REFERENCES Forum_Post,
	reported_user int REFERENCES Authenticated_User
	CONSTRAINT one_reported_item_nn CHECK(
		(reported_wishlist NOTNULL AND
		reported_forum_post ISNULL AND
		reported_user ISNULL) 
		OR
		(reported_forum_post NOTNULL AND
		reported_wishlist ISNULL AND
		reported_user ISNULL) 
		OR
		(reported_user NOTNULL AND
		reported_forum_post ISNULL AND
		reported_wishlist ISNULL) 
	)
);

--PasswordRecovery
CREATE TABLE password_recovery(
	auth_user int PRIMARY KEY REFERENCES authenticated_user,
	temp_psw text NOT NULL,
	confirmationKey text NOT NULL,
	date timestamptz NOT NULL
);


--feed
CREATE TABLE feed(
	id serial PRIMARY KEY,
	date timestamptz NOT NULL,
	wishlist int NOT NULL REFERENCES wishlist ON DELETE CASCADE,
	new_giver int DEFAULT NULL REFERENCES authenticated_user ON DELETE CASCADE,
	old_giver int DEFAULT NULL REFERENCES authenticated_user ON DELETE CASCADE,
	wishlist_edit timestamptz DEFAULT NULL,
	wishlist_create timestamptz DEFAULT NULL,
	post int DEFAULT NULL REFERENCES forum_post ON DELETE CASCADE
);


