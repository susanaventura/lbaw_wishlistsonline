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
ALTER SEQUENCE "wishlists_online_dev"."notification_id_seq" RESTART WITH 1;
ALTER SEQUENCE "wishlists_online_dev"."chat_message_id_seq" RESTART WITH 1;
ALTER SEQUENCE "wishlists_online_dev"."forum_post_id_seq" RESTART WITH 1;

DELETE FROM "wishlists_online_dev"."wishlist_item";
DELETE FROM "wishlists_online_dev"."wishlist_notification";
DELETE FROM "wishlists_online_dev"."message_notification";
DELETE FROM "wishlists_online_dev"."friend_request_notification";
DELETE FROM "wishlists_online_dev"."forum_post_rating_notification";
DELETE FROM "wishlists_online_dev"."forum_post_notification";
DELETE FROM "wishlists_online_dev"."notification";

DELETE FROM "wishlists_online_dev"."forum_post";
DELETE FROM "wishlists_online_dev"."wishlist";
DELETE FROM "wishlists_online_dev"."email_confirmation";
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
--6
INSERT INTO "wishlists_online_dev"."wishlist_occasion" ("occasion_name") VALUES ('Occasion');


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
INSERT INTO "wishlists_online_dev"."wishlist" ("owner","creation_date","password","privacy","title","occasion") VALUES (1,NULL,NULL,1,'My birthday wishlist',2);

--2
INSERT INTO "wishlists_online_dev"."wishlist" ("owner","creation_date","password","privacy","title","occasion") VALUES (4,NULL,NULL,1,'Birthday wishes',2);

--3
INSERT INTO "wishlists_online_dev"."wishlist" ("owner","creation_date","password","privacy","title","occasion") VALUES (1,NULL,NULL,1,'Promotion',5);

--4
INSERT INTO "wishlists_online_dev"."wishlist" ("owner","creation_date","password","privacy","title","occasion") VALUES (5,NULL,NULL,1,'Got a Job',5);

--5
INSERT INTO "wishlists_online_dev"."wishlist" ("owner","creation_date","password","privacy","title","occasion") VALUES (6,NULL,NULL,1,'My Desired Stuff',5);

--6
INSERT INTO "wishlists_online_dev"."wishlist" ("owner","creation_date","password","privacy","title","occasion") VALUES (1,NULL,NULL,1,'My Christmas Present',1);

--7
INSERT INTO "wishlists_online_dev"."wishlist" ("owner","creation_date","password","privacy","title","occasion") VALUES (3,NULL,NULL,1,'Birthday Gift',2);

--wishlist item
INSERT INTO "wishlists_online_dev"."wishlist_item" ("wishlist","image","link","name","note","price","rating","giver") VALUES (3,NULL,NULL,'phone','a cute phone',100,2, NULL);
INSERT INTO "wishlists_online_dev"."wishlist_item" ("wishlist","image","link","name","note","price","rating","giver") VALUES (3,NULL,'http://dogs.pt','dog',NULL,400,4.5, NULL);

--forum_post
--1
INSERT INTO "wishlists_online_dev"."forum_post" ("creation_date","message","owner","wishlist","main_post") VALUES ('06-02-2013 00:53:00','This is a main post',1,1,NULL);

--2
INSERT INTO "wishlists_online_dev"."forum_post" ("creation_date","message","owner","wishlist","main_post") VALUES ('06-02-2013 00:55:00','This is a reply post',2,1,1);





