-- Trigger: update_view_visible_wishlists on wishlists_online_dev.wishlist

DROP TRIGGER IF EXISTS update_view_visible_wishlists ON wishlists_online_dev.wishlist;

CREATE TRIGGER update_view_visible_wishlists
  AFTER INSERT OR UPDATE
  ON wishlists_online_dev.wishlist
  FOR EACH ROW
  EXECUTE PROCEDURE wishlists_online_dev.update_view_visible_wishlists();



-- Trigger: update_feed_updated_wishlist on wishlists_online_dev.wishlist

DROP TRIGGER IF EXISTS update_feed_wishlist ON wishlists_online_dev.wishlist;

CREATE TRIGGER update_feed_wishlist
  AFTER INSERT OR UPDATE
  ON wishlists_online_dev.wishlist
  FOR EACH ROW
  EXECUTE PROCEDURE wishlists_online_dev.update_feed_wishlist();


-- Trigger: update_feed_new_item_giver on wishlists_online_dev.wishlist_item

DROP TRIGGER IF EXISTS on_update_item_wishlist_giver ON wishlists_online_dev.wishlist_item;

CREATE TRIGGER on_update_item_wishlist_giver
  AFTER UPDATE
  ON wishlists_online_dev.wishlist_item
  FOR EACH ROW
  EXECUTE PROCEDURE wishlists_online_dev.update_feed_new_item_giver();


-- Trigger: on_insert_forum_post on wishlists_online_dev.forum_post

DROP TRIGGER IF EXISTS on_insert_forum_post ON wishlists_online_dev.forum_post;

CREATE TRIGGER on_insert_forum_post
  AFTER INSERT
  ON wishlists_online_dev.forum_post
  FOR EACH ROW
  EXECUTE PROCEDURE wishlists_online_dev.update_feed_forum_post();

  /************************************/

-- Trigger: on_create_forum_post_notification on wishlists_online_dev.forum_post

DROP TRIGGER IF EXISTS on_create_forum_post_notification ON wishlists_online_dev.forum_post;

CREATE TRIGGER on_create_forum_post_notification
  AFTER INSERT
  ON wishlists_online_dev.forum_post
  FOR EACH ROW
  EXECUTE PROCEDURE wishlists_online_dev.forum_post_generate_notification();

-- Trigger: on_create_reputation_notification on wishlists_online_dev.reputation

DROP TRIGGER IF EXISTS on_create_reputation_notification ON wishlists_online_dev.reputation;

CREATE TRIGGER on_create_reputation_notification
  AFTER INSERT
  ON wishlists_online_dev.reputation
  FOR EACH ROW
  EXECUTE PROCEDURE wishlists_online_dev.reputation_changed();

-- Trigger: on_update_reputation_notification on wishlists_online_dev.reputation

DROP TRIGGER IF EXISTS on_update_reputation_notification ON wishlists_online_dev.reputation;

CREATE TRIGGER on_update_reputation_notification
  AFTER UPDATE
  ON wishlists_online_dev.reputation
  FOR EACH ROW
  EXECUTE PROCEDURE wishlists_online_dev.reputation_changed();

-- Trigger: update_wishlist_creation_date on wishlists_online_dev.wishlist

DROP TRIGGER IF EXISTS update_wishlist_creation_date ON wishlists_online_dev.wishlist;

CREATE TRIGGER update_wishlist_creation_date
  BEFORE INSERT
  ON wishlists_online_dev.wishlist
  FOR EACH ROW
  EXECUTE PROCEDURE wishlists_online_dev.wishlist_created_now();

-- Trigger: update_wishlist_edit_date on wishlists_online_dev.wishlist

DROP TRIGGER IF EXISTS update_wishlist_edit_date ON wishlists_online_dev.wishlist;

CREATE TRIGGER update_wishlist_edit_date
  BEFORE UPDATE
  ON wishlists_online_dev.wishlist
  FOR EACH ROW
  EXECUTE PROCEDURE wishlists_online_dev.wishlist_edited_now();

  
 -- Trigger: update_authenticated_user_search_tsvector on wishlists_online_dev.authenticated_user

DROP TRIGGER IF EXISTS update_authenticated_user_search_tsvector ON wishlists_online_dev.authenticated_user;

CREATE TRIGGER update_authenticated_user_search_tsvector
  BEFORE INSERT OR UPDATE
  ON wishlists_online_dev.authenticated_user
  FOR EACH ROW
  EXECUTE PROCEDURE wishlists_online_dev.authenticated_user_generate_search_tsvector();
  
  
 -- Trigger: update_wishlist_search_tsvector on wishlists_online_dev.wishlist

DROP TRIGGER IF EXISTS update_wishlist_search_tsvector ON wishlists_online_dev.wishlist;

CREATE TRIGGER update_wishlist_search_tsvector
  BEFORE INSERT OR UPDATE
  ON wishlists_online_dev.wishlist
  FOR EACH ROW
  EXECUTE PROCEDURE wishlists_online_dev.wishlist_generate_search_tsvector();
