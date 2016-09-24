--					--
--   TEST INSERTS	--
--					--

--	ALWAYS ADD "wishlists_online_dev"									--
--  ADD A COMMENT FOR EACH ROW WITH ID SO YOU CAN DO REFERENCES FAST	--
--  CAREFUL WITH CONSTRAINTS											--
--  CAREFUL WITH INSERTS ORDER :
--		IF A REFERENCES B, INSERT IN B FIRST AND THEN INSERT IN A		--

ALTER SEQUENCE "wishlists_online_dev"."authenticated_user_id_seq" RESTART WITH 1;
ALTER SEQUENCE "wishlists_online_dev"."country_id_seq" RESTART WITH 1;
ALTER SEQUENCE "wishlists_online_dev"."wishlist_occasion_id_seq" RESTART WITH 1;
ALTER SEQUENCE "wishlists_online_dev"."wishlist_item_id_seq" RESTART WITH 1;
ALTER SEQUENCE "wishlists_online_dev"."wishlist_id_seq" RESTART WITH 1;
ALTER SEQUENCE "wishlists_online_dev"."report_id_seq" RESTART WITH 1;
ALTER SEQUENCE "wishlists_online_dev"."notification_id_seq" RESTART WITH 1;
ALTER SEQUENCE "wishlists_online_dev"."message_id_seq" RESTART WITH 1;
ALTER SEQUENCE "wishlists_online_dev"."chat_message_id_seq" RESTART WITH 1;
ALTER SEQUENCE "wishlists_online_dev"."forum_post_id_seq" RESTART WITH 1;

DELETE FROM "wishlists_online_dev"."email_confirmation";
DELETE FROM "wishlists_online_dev"."friend_request_notification";
DELETE FROM "wishlists_online_dev"."message_notification";
DELETE FROM "wishlists_online_dev"."forum_post_notification";
DELETE FROM "wishlists_online_dev"."forum_post_rating_notification";
DELETE FROM "wishlists_online_dev"."notification";
DELETE FROM "wishlists_online_dev"."report";
DELETE FROM "wishlists_online_dev"."reputation";
DELETE FROM "wishlists_online_dev"."forum_post";
DELETE FROM "wishlists_online_dev"."wishlist_item";
DELETE FROM "wishlists_online_dev"."wishlist";
DELETE FROM "wishlists_online_dev"."message";
DELETE FROM "wishlists_online_dev"."chat_message";
DELETE FROM "wishlists_online_dev"."friend";
DELETE FROM "wishlists_online_dev"."follow";
DELETE FROM "wishlists_online_dev"."authenticated_user";
DELETE FROM "wishlists_online_dev"."country";
DELETE FROM "wishlists_online_dev"."wishlist_occasion";



--country
--1
INSERT INTO "wishlists_online_dev"."country" ("name") VALUES ('Portugal');
--2
INSERT INTO "wishlists_online_dev"."country" ("name") VALUES ('Spain');
--3
INSERT INTO "wishlists_online_dev"."country" ("name") VALUES ('Pakistan');
--4
INSERT INTO "wishlists_online_dev"."country" ("name") VALUES ('United Arab Emirates');
--5
INSERT INTO "wishlists_online_dev"."country" ("name") VALUES ('United States of America');
--6
INSERT INTO "wishlists_online_dev"."country" ("name") VALUES ('Germany');
--7
INSERT INTO "wishlists_online_dev"."country" ("name") VALUES ('Italy');
--8
INSERT INTO "wishlists_online_dev"."country" ("name") VALUES ('France');
--9
INSERT INTO "wishlists_online_dev"."country" ("name") VALUES ('China');
--10
INSERT INTO "wishlists_online_dev"."country" ("name") VALUES ('Brazil');


--occasion        DON'T ADD MORE

--1
INSERT INTO "wishlists_online_dev"."wishlist_occasion" ("occasion_name") VALUES ('Christmas');
--2
INSERT INTO "wishlists_online_dev"."wishlist_occasion" ("occasion_name") VALUES ('Birthday');
--3
INSERT INTO "wishlists_online_dev"."wishlist_occasion" ("occasion_name") VALUES ('Easter');
--4
INSERT INTO "wishlists_online_dev"."wishlist_occasion" ("occasion_name") VALUES ('Valentines Day');
--5
INSERT INTO "wishlists_online_dev"."wishlist_occasion" ("occasion_name") VALUES ('No occasion');


--support_msg_subject_areas        DON'T ADD MORE

--1
INSERT INTO "wishlists_online_dev"."support_msg_subject_areas" ("name") VALUES ('Suggestion');
--2
INSERT INTO "wishlists_online_dev"."support_msg_subject_areas" ("name") VALUES ('Account issue');
--3
INSERT INTO "wishlists_online_dev"."support_msg_subject_areas" ("name") VALUES ('Wishlists issue');
--4
INSERT INTO "wishlists_online_dev"."support_msg_subject_areas" ("name") VALUES ('Website issue');
--5
INSERT INTO "wishlists_online_dev"."support_msg_subject_areas" ("name") VALUES ('General');





--authenticated user        DON'T ADD MORE

--1
INSERT INTO "wishlists_online_dev"."authenticated_user" ("active","admin_rights","birth_date","email","first_name","last_name","gender","password","profile_image","username","last_login","register_date","country") VALUES (True,True,'09-21-1994','susana@test.com','Susana','Ventura','F','$2y$12$Q6Ho3ylrCwDv9jp39LBt1e39jBhORcNhC9xjccPD9fHOCfEXstqNm',NULL,'susana',NULL,'2015-05-08 16:45:00+01',1);

--2
INSERT INTO "wishlists_online_dev"."authenticated_user" ("active","admin_rights","birth_date","email","first_name","last_name","gender","password","profile_image","username","last_login","register_date","country") VALUES (True,True,'09-21-1994','anwaar@test.com','Anwaar','Hussain','M','$2y$12$Q6Ho3ylrCwDv9jp39LBt1e39jBhORcNhC9xjccPD9fHOCfEXstqNm',NULL,'anwaar',NULL,'2015-05-13 09:28:37+01',3);

--3
INSERT INTO "wishlists_online_dev"."authenticated_user" ("active","admin_rights","birth_date","email","first_name","last_name","gender","password","profile_image","username","last_login","register_date","country") VALUES (True,True,'09-21-1994','rui@test.com','Rui','Grandao','M','$2y$12$Q6Ho3ylrCwDv9jp39LBt1e39jBhORcNhC9xjccPD9fHOCfEXstqNm',NULL,'ruigrandao',NULL,'2015-05-13 09:31:30+01',1);

--4
INSERT INTO "wishlists_online_dev"."authenticated_user" ("active","admin_rights","birth_date","email","first_name","last_name","gender","password","profile_image","username","last_login","register_date","country") VALUES (True,True,'09-21-1994','luis@test.com','Luis','Reis','M','$2y$12$Q6Ho3ylrCwDv9jp39LBt1e39jBhORcNhC9xjccPD9fHOCfEXstqNm',NULL,'luis',NULL,'2015-05-13 09:36:12+01',2);

--5
INSERT INTO "wishlists_online_dev"."authenticated_user" ("active","admin_rights","birth_date","email","first_name","last_name","gender","password","profile_image","username","last_login","register_date","country") VALUES (False,False,'1993-01-01','maria@test.com','Maria','Silva','F','$2y$12$Q6Ho3ylrCwDv9jp39LBt1e39jBhORcNhC9xjccPD9fHOCfEXstqNm',NULL,'maria',NULL,'2015-05-13 09:37:20+01',2);

--6
INSERT INTO "wishlists_online_dev"."authenticated_user" ("active","admin_rights","birth_date","email","first_name","last_name","gender","password","profile_image","username","last_login","register_date","country") VALUES (True,False,'1980-01-01','anna@test.com','Anna','Rose','F','$2y$12$Q6Ho3ylrCwDv9jp39LBt1e39jBhORcNhC9xjccPD9fHOCfEXstqNm',NULL,'anna',NULL,'2015-05-13 19:45:20+01',1);

--7
INSERT INTO "wishlists_online_dev"."authenticated_user" ("active","admin_rights","birth_date","email","first_name","last_name","gender","password","profile_image","username","last_login","register_date","country") VALUES (True,False,'1980-01-01','alan@test.com','Alan','Louis','M','$2y$12$Q6Ho3ylrCwDv9jp39LBt1e39jBhORcNhC9xjccPD9fHOCfEXstqNm',NULL,'alan',NULL,'2015-05-13 09:38:20+01',1);


--confirmation email        DON'T ADD MORE
INSERT INTO "wishlists_online_dev"."email_confirmation" ("confirmationkey","auth_user") VALUES ('2a266eceb641454d85e989f374c408edd79efbbe',5);


--wishlist

--1
INSERT INTO "wishlists_online_dev"."wishlist" ("owner","creation_date","password","privacy","title","occasion") VALUES (1,'2015-05-13 09:40:20+01',NULL,0,'My birthday wishlist',2);

--2
INSERT INTO "wishlists_online_dev"."wishlist" ("owner","creation_date","password","privacy","title","occasion") VALUES (4,'2015-05-13 09:40:20+01',NULL,1,'Birthday wishes',2);

--3
INSERT INTO "wishlists_online_dev"."wishlist" ("owner","creation_date","password","privacy","title","occasion") VALUES (7,'2015-05-13 10:40:20+01',NULL,2,'Promotion',5);

--4
INSERT INTO "wishlists_online_dev"."wishlist" ("owner","creation_date","password","privacy","title","occasion") VALUES (5,'2015-05-13 11:00:20+01',NULL,1,'Got a Job',5);

--5
INSERT INTO "wishlists_online_dev"."wishlist" ("owner","creation_date","password","privacy","title","occasion") VALUES (6,'2015-05-14 13:00:20+01',NULL,2,'My Desired Stuff',5);

--6
INSERT INTO "wishlists_online_dev"."wishlist" ("owner","creation_date","password","privacy","title","occasion") VALUES (2,'2015-05-14 19:00:20+01',NULL,1,'My Christmas Present',1);

--7
INSERT INTO "wishlists_online_dev"."wishlist" ("owner","creation_date","password","privacy","title","occasion") VALUES (3,'2015-05-14 23:10:20+01',NULL,1,'Birthday Gift',2);

--Notification

--1
INSERT INTO "wishlists_online_dev"."notification" (date,"seen","receiver")VALUES('2015-05-13 09:40:20+01',False,1);

--2
INSERT INTO "wishlists_online_dev"."notification" (date,"seen","receiver")VALUES('2015-05-14 06:10:20+01',True,7);

--3
INSERT INTO "wishlists_online_dev"."notification" (date,"seen","receiver")VALUES('2015-05-14 08:09:20+01',True,5);

--4
INSERT INTO "wishlists_online_dev"."notification" (date,"seen","receiver")VALUES('2015-05-14 08:09:20+01',True,2);

--5
INSERT INTO "wishlists_online_dev"."notification" (date,"seen","receiver")VALUES('2015-05-14 08:25:20+01',False,7);

--6
INSERT INTO "wishlists_online_dev"."notification" (date,"seen","receiver")VALUES('2015-05-22 02:01:20+01',False,2);

--7
INSERT INTO "wishlists_online_dev"."notification" (date,"seen","receiver")VALUES('2015-05-22 02:11:20+01',True,1);


--message

--1
INSERT INTO "wishlists_online_dev"."message" (date,"message","author","receiver")VALUES('2015-05-14 06:10:20+01','Nice Wishlist',2,1);

--2
INSERT INTO "wishlists_online_dev"."message" (date,"message","author","receiver")VALUES('2015-05-13 09:40:20+01','Finding some present for you!=p',4,5);

--3
INSERT INTO "wishlists_online_dev"."message" (date,"message","author","receiver")VALUES('2015-05-14 06:10:20+01','Cool!!',3,7);

--message_notification
--1
INSERT INTO "wishlists_online_dev"."message_notification"("notification","message")VALUES(1,1);
--2
INSERT INTO "wishlists_online_dev"."message_notification"("notification","message")VALUES(2,3);
--3
INSERT INTO "wishlists_online_dev"."message_notification"("notification","message")VALUES(3,2);

--chat_message

--1
INSERT INTO "wishlists_online_dev"."chat_message" (date,"message","author","receiver")VALUES('2015-05-15 11:50:20+01','Hi, Where?',2,1);

--2
INSERT INTO "wishlists_online_dev"."chat_message" (date,"message","author","receiver")VALUES('2015-05-15 12:35:20+01','Ola! Como Esta?',4,3);

--3
INSERT INTO "wishlists_online_dev"."chat_message" (date,"message","author","receiver")VALUES('2015-05-15 18:40:20+01','Hi, Sup?',6,7);

--wishlist_item

--1
INSERT INTO "wishlists_online_dev"."wishlist_item" ("wishlist","image","link","name","price","rating","giver")VALUES(4,NULL,NULL,'ROLEX Watch',545.0,2.5,3);

--2
INSERT INTO "wishlists_online_dev"."wishlist_item" ("wishlist","image","link","name","price","rating","giver")VALUES(7,NULL,NULL,'Fender Ash/Walnut Guitar',1149.0,4.5,1);

--3
INSERT INTO "wishlists_online_dev"."wishlist_item" ("wishlist","image","link","name","price","rating","giver")VALUES(6,NULL,NULL,'Samsung Laptop',449.0,1.0,1);

--4
INSERT INTO "wishlists_online_dev"."wishlist_item" ("wishlist","image","link","name","price","rating","giver")VALUES(2,NULL,NULL,'Xbox 360',209.0,0.5,5);

--5
INSERT INTO "wishlists_online_dev"."wishlist_item" ("wishlist","image","link","name","price","rating","giver")VALUES(3,NULL,NULL,'Levis Jeans',45.0,1.0,7);

--friend
--1
INSERT INTO "wishlists_online_dev"."friend"("user1","user2")VALUES(4,5);
INSERT INTO "wishlists_online_dev"."friend"("user1","user2")VALUES(5,4);
--2
INSERT INTO "wishlists_online_dev"."friend"("user1","user2")VALUES(1,2);
INSERT INTO "wishlists_online_dev"."friend"("user1","user2")VALUES(2,1);
--3
INSERT INTO "wishlists_online_dev"."friend"("user1","user2")VALUES(3,7);
INSERT INTO "wishlists_online_dev"."friend"("user1","user2")VALUES(7,3);

--friend_request_notification
--1
INSERT INTO "wishlists_online_dev"."friend_request_notification"("notification","sender")VALUES(4,1);
--2
INSERT INTO "wishlists_online_dev"."friend_request_notification"("notification","sender")VALUES(5,3);

--follow
--1
INSERT INTO "wishlists_online_dev"."follow"("follower","followed")VALUES(1,3);
--2
INSERT INTO "wishlists_online_dev"."follow"("follower","followed")VALUES(3,6);

--forum_post
--1
INSERT INTO "wishlists_online_dev"."forum_post"("creation_date","message","owner","wishlist","main_post")VALUES('2015-05-21 20:40:20+01','Cool Stuff!! :-)',5,2,null);
--2
INSERT INTO "wishlists_online_dev"."forum_post"("creation_date","message","owner","wishlist","main_post")VALUES('2015-05-22 02:00:20+01','Hmmm!! Expensive',1,6,null);
--3
INSERT INTO "wishlists_online_dev"."forum_post"("creation_date","message","owner","wishlist","main_post")VALUES('2015-05-22 02:25:20+01','Did not like it much!! :-p',3,3,null);
--4
INSERT INTO "wishlists_online_dev"."forum_post"("creation_date","message","owner","wishlist","main_post")VALUES('2015-05-22 02:10:20+01','Yeah it is!',2,6,null);

--Report
--1
INSERT INTO "wishlists_online_dev"."report"(date,"reason","author","responsable_admin","reported_wishlist","reported_forum_post","reported_user")VALUES('2015-05-23 02:25:20+01','This user is sending me annoying messages',4,null,null,null,5);
--2
INSERT INTO "wishlists_online_dev"."report"(date,"reason","author","responsable_admin","reported_wishlist","reported_forum_post","reported_user")VALUES('2015-05-24 12:25:20+01','This post comprises of inappropriate words',2,1,null,2,null);
--3
INSERT INTO "wishlists_online_dev"."report"(date,"reason","author","responsable_admin","reported_wishlist","reported_forum_post","reported_user")VALUES('2015-05-25 18:25:20+01','This wislist is a copy of mine one. Please inform the concerned user and remove it asap',1,null,4,null,null);

--reputation
--1
--INSERT INTO "wishlists_online_dev"."reputation" ("auth_user","forum_post","reputation")VALUES(1,1,0);
--2
--INSERT INTO "wishlists_online_dev"."reputation" ("auth_user","forum_post","reputation")VALUES(7,2,1);

--forum_post_notification
--1
INSERT INTO "wishlists_online_dev"."forum_post_notification" ("notification","forum_post","forum_reply")VALUES(6,2,null);
--2
INSERT INTO "wishlists_online_dev"."forum_post_notification" ("notification","forum_post","forum_reply")VALUES(7,null,1);
