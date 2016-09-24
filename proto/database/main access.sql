--users

INSERT INTO authenticated_user(birth_date, email, first_name, last_name, gender, password, profile_image, username, last_login, register_date, country)
VALUES (?,?,?,?,?,?,?,?,?,?,?);

--userExists
SELECT id FROM authenticated_user
WHERE username = ? OR email = ?;

--getUserId
SELECT id FROM authenticated_user
WHERE username = ? OR email = ?;

--verify login
SELECT password, active
FROM authenticated_user
WHERE username = ? OR email = ?;

--saveConfirmKey
INSERT INTO email_confirmation(confirmationKey, auth_user)
VALUES(?,?);

--getConfirmKey
SELECT confirmationKey
FROM email_confirmation WHERE auth_user = ?;

--activateUser
UPDATE authenticated_user
SET active=true WHERE email = ?;

DELETE FROM email_confirmation WHERE confirmationKey = ?;

--updateOnlineState
UPDATE authenticated_user set online=? WHERE username = ?;




--get user pic
SELECT profile_image
FROM authenticated_user
WHERE id = ?;


--update profile_image
UPDATE authenticated_user
SET birth_date = ?, first_name = ?, last_name = ?, gender = ?,
password = ?, profile_image = ?, country = ?
WHERE id = ?;

--updateAdminState
UPDATE authenticated_user
SET admin_rights = ?
WHERE id = ?;

--update active state
UPDATE authenticated_user
SET active = ?
WHERE id = ?;



--get users (from search on top bar)
SELECT username, profile_image
FROM authenticated_user
WHERE
	(username = ? OR email = ? OR first_name = ? OR last_name = ?) AND
	active = true;
	
--report an user
INSERT INTO report(date, reason, author, reported_user)
VALUES(?,?,?,?);

--report a wishlist
INSERT INTO report(date, reason, author, reported_wishlist)
VALUES(?,?,?,?);

--report forum post
INSERT INTO report(date, reason, author, reported_forum_post)
VALUES(?,?,?,?);


--follow user
INSERT INTO follow(follower, followed)
VALUES(?,?);

--unfollow user
DELETE FROM follow WHERE follower=? AND followed=?;

--become friend with an user
INSERT INTO friend(user1, user2)
VALUES(?,?)

--create notification
INSERT INTO notification(date, receiver)
VALUES (?,?) RETURNING id;

--send friend request notification
INSERT INTO friend_request_notification(notification, sender)
VALUES(?, ?);


--list reports
SELECT * FROM report
ORDER BY date ASC
LIMIT ? OFFSET ?;





SELECT * FROM general_notifications
ORDER BY date ASC
LIMIT ? OFFSET ?;

--list of notifications to present in "Friend requests"
SELECT * FROM friend_request_notification
ORDER BY date ASC
LIMIT ? OFFSET ?;

--list of notifications to present in "Messages"
SELECT * FROM message_notification
ORDER BY date ASC
LIMIT ? OFFSET ?;

--get number of not seen notifications
SELECT COUNT(id)


--delete user
DELETE FROM authenticated_user
WHERE id = ?;



















--select random items that other users want
WITH RECURSIVE r AS ( 
    WITH b AS (SELECT min(id), max(id) FROM wishlist_item) 
    ( 
        SELECT id, min, max, array[]::integer[] AS a, 0 AS n 
        FROM wishlist_item, b 
        WHERE id > min + (max - min) * random() 
        LIMIT 8 
    ) UNION ALL ( 
        SELECT t.id, min, max, a || t.id, r.n + 1 AS n 
        FROM wishlist_item AS t, r 
        WHERE 
            t.id > min + (max - min) * random() AND 
            t.id <> all(a) AND 
            r.n + 1 < 10 
        LIMIT 8 
    ) 
) 
SELECT image, link, name
FROM wishlist_item
WHERE id IN 
	(SELECT t.id
	 FROM wishlist_item AS t, r
	 WHERE r.id = t.id);
	
	
--list notifications to present in "Notifications"
CREATE OR REPLACE VIEW general_notifications AS
SELECT * FROM notification
WHERE id NOT IN
	(	SELECT notification
		FROM friend_request_notification
	)
	AND id NOT IN
	(	SELECT notification
		FROM message_notification	
	);
	

--complete wishlist
CREATE OR REPLACE VIEW complete_wishlists AS
SELECT * FROM wishlist




--	
--wall
--


/*
--get all wishlists //se creation_date = last_edit é ''criou a wishlist X'', senao é ''editou a wishlist X''
SELECT * FROM wishlist
ORDER BY last_edit_date ASC;

--get forum posts //userX participou no forum
select * FROM forum_post
ORDER BY creation_date ASC;
*/

CREATE OR REPLACE VIEW wall(forum_msg_id, wishlist_id, wishlist_owner, date) AS
	WITH visible_wishlists AS (
		SELECT * FROM wishlist
		WHERE privacy != 0
	)
	SELECT id AS wishlist_id, owner AS wishlist_owner, las_edit_date AS date
	FROM visible_wishlists
	UNION ALL
	SELECT id AS forum_msg_id, wishlist AS wishlist_id, NULL AS wishlist_owner, creation_date AS date
	WHERE forum_wishlist IN (SELECT id FROM visible_wishlists);

	
	
--user wall
SELECT * FROM wall
WHERE wishlist_id IN
	(SELECT followed FROM follow
	WHERE follower = ?)
ORDER BY date ASC,
LIMIT ? OFFSET ?;



