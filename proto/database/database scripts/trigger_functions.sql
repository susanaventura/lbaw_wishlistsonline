-- Function: wishlists_online_dev.update_view_visible_wishlists()

-- DROP FUNCTION wishlists_online_dev.update_view_visible_wishlists();

CREATE OR REPLACE FUNCTION wishlists_online_dev.update_view_visible_wishlists()
  RETURNS trigger AS
$BODY$BEGIN

	CREATE OR REPLACE VIEW wishlists_online_dev.visible_wishlists AS
		SELECT id, owner FROM wishlists_online_dev.wishlist
		WHERE privacy != 0;

	RETURN NEW;
END;$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION wishlists_online_dev.update_view_visible_wishlists()
  OWNER TO lbaw1465;
  

  

-- Function: wishlists_online_dev.update_feed_new_item_giver()

-- DROP FUNCTION wishlists_online_dev.update_feed_wishlist();

CREATE OR REPLACE FUNCTION wishlists_online_dev.update_feed_wishlist()
  RETURNS trigger AS
$BODY$BEGIN
	--check if it is not a giver update
	IF (NEW.last_edit_date = current_timestamp) THEN
		INSERT INTO wishlists_online_dev.feed (date, wishlist, wishlist_create, wishlist_edit)
			VALUES (current_timestamp, NEW.id, NEW.creation_date, NEW.last_edit_date);
		
	END IF;
	RETURN NEW;
END;$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION wishlists_online_dev.update_feed_wishlist()
  OWNER TO lbaw1465;


-- Function: wishlists_online_dev.update_feed_new_item_giver()

-- DROP FUNCTION wishlists_online_dev.update_feed_new_item_giver();

CREATE OR REPLACE FUNCTION wishlists_online_dev.update_feed_new_item_giver()
  RETURNS trigger AS
$BODY$BEGIN

	INSERT INTO wishlists_online_dev.feed (date, wishlist, new_giver, old_giver)
		VALUES (current_timestamp, NEW.wishlist, NEW.giver, OLD.giver );

	RETURN NEW;
END;$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION wishlists_online_dev.update_feed_new_item_giver()
  OWNER TO lbaw1465;
  
  
  

-- Function: wishlists_online_dev.update_feed_forum_post()

-- DROP FUNCTION wishlists_online_dev.update_feed_forum_post();

CREATE OR REPLACE FUNCTION wishlists_online_dev.update_feed_forum_post()
  RETURNS trigger AS
$BODY$BEGIN

	INSERT INTO wishlists_online_dev.feed (date, wishlist, post)
		VALUES (current_timestamp, NEW.wishlist, NEW.id );

	RETURN NEW;
END;$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION wishlists_online_dev.update_feed_forum_post()
  OWNER TO lbaw1465;




-- Function: wishlists_online_dev.forum_post_generate_notification()

-- DROP FUNCTION wishlists_online_dev.forum_post_generate_notification();

CREATE OR REPLACE FUNCTION wishlists_online_dev.forum_post_generate_notification()
  RETURNS trigger AS
$BODY$BEGIN
	-- Create Reply notification --
	if (NEW.main_post <> NULL) THEN
		INSERT INTO wishlists_online_dev.notification (date, seen, receiver)
			VALUES (current_timestamp, false, (SELECT owner FROM wishlists_online_dev.forum_post WHERE id = NEW.main_post) );
	
		INSERT INTO wishlists_online_dev.forum_post_notification (notification, forum_reply) VALUES ( (SELECT last_value FROM wishlists_online_dev.notification_id_seq), NEW.id);
	END IF;

	RETURN NEW;
END;$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION wishlists_online_dev.forum_post_generate_notification()
  OWNER TO lbaw1465;

  
  
-- Function: wishlists_online_dev.reputation_changed()

-- DROP FUNCTION wishlists_online_dev.reputation_changed();

CREATE OR REPLACE FUNCTION wishlists_online_dev.reputation_changed()
  RETURNS trigger AS
$BODY$BEGIN
	-- Create Notification --
	INSERT INTO wishlists_online_dev.notification (date, seen, receiver)
	SELECT current_timestamp, false, owner FROM wishlists_online_dev.forum_post WHERE id = NEW.forum_post;

	-- Create Forum Post Rating notification --
	INSERT INTO wishlists_online_dev.forum_post_rating_notification (notification, auth_user, forum_post)
	SELECT id, NEW.auth_user, NEW.forum_post FROM wishlists_online_dev.notification ORDER BY id DESC LIMIT 1; 
	
	RETURN NEW;
END;$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION wishlists_online_dev.reputation_changed()
  OWNER TO lbaw1465;

-- Function: wishlists_online_dev.wishlist_created_now()

-- DROP FUNCTION wishlists_online_dev.wishlist_created_now();

CREATE OR REPLACE FUNCTION wishlists_online_dev.wishlist_created_now()
  RETURNS trigger AS
$BODY$BEGIN
  NEW.creation_date = current_timestamp;
  NEW.last_edit_date = NEW.creation_date;
  RETURN NEW;
END;$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION wishlists_online_dev.wishlist_created_now()
  OWNER TO lbaw1465;

-- Function: wishlists_online_dev.wishlist_edited_now()

-- DROP FUNCTION wishlists_online_dev.wishlist_edited_now();

CREATE OR REPLACE FUNCTION wishlists_online_dev.wishlist_edited_now()
  RETURNS trigger AS
$BODY$BEGIN
  NEW.last_edit_date = current_timestamp;
  RETURN NEW;
END;$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION wishlists_online_dev.wishlist_edited_now()
  OWNER TO lbaw1465;

  
-- Function: wishlists_online_dev.authenticated_user_generate_search_tsvector()

-- DROP FUNCTION wishlists_online_dev.authenticated_user_generate_search_tsvector();

CREATE OR REPLACE FUNCTION wishlists_online_dev.authenticated_user_generate_search_tsvector()
  RETURNS trigger AS
$BODY$BEGIN
  NEW.search_tsvector = to_tsvector(NEW.first_name || ' ' || NEW.last_name || ' ' || NEW.username);
  RETURN NEW;
END;$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION wishlists_online_dev.authenticated_user_generate_search_tsvector()
  OWNER TO lbaw1465;
  
  
-- Function: wishlists_online_dev.wishlist_generate_search_tsvector()

-- DROP FUNCTION wishlists_online_dev.wishlist_generate_search_tsvector();

CREATE OR REPLACE FUNCTION wishlists_online_dev.wishlist_generate_search_tsvector()
  RETURNS trigger AS
$BODY$BEGIN
  NEW.search_tsvector = to_tsvector(
	NEW.title || ' ' || 
	coalesce((SELECT occasion_name FROM wishlists_online_dev.wishlist_occasion WHERE id = NEW.occasion), '') || ' ' ||
	coalesce((SELECT string_agg(name, ' ') FROM wishlists_online_dev.wishlist_item WHERE wishlist = NEW.id), '')
	);  
  RETURN NEW;
END;$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION wishlists_online_dev.wishlist_generate_search_tsvector()
  OWNER TO lbaw1465;
  