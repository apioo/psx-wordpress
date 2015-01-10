<?php

namespace WordpressGateway\Api\Posts;

use PSX\Sql\TableAbstract;

/**
 * PostTable
 *
 * @see http://phpsx.org/doc/concept/table.html
 */
class PostTable extends TableAbstract
{
	public function getName()
	{
		return 'wp_posts';
	}

	public function getColumns()
	{
		return array(
			'ID' => self::TYPE_BIGINT | self::AUTO_INCREMENT | self::PRIMARY_KEY,
			'post_author' => self::TYPE_BIGINT,
			'post_date' => self::TYPE_DATETIME,
			'post_date_gmt' => self::TYPE_DATETIME,
			'post_content' => self::TYPE_TEXT,
			'post_title' => self::TYPE_TEXT,
			'post_excerpt' => self::TYPE_TEXT,
			'post_status' => self::TYPE_VARCHAR,
			'comment_status' => self::TYPE_VARCHAR,
			'ping_status' => self::TYPE_VARCHAR,
			'post_password' => self::TYPE_VARCHAR,
			'post_name' => self::TYPE_VARCHAR,
			'to_ping' => self::TYPE_TEXT,
			'pinged' => self::TYPE_TEXT,
			'post_modified' => self::TYPE_DATETIME,
			'post_modified_gmt' => self::TYPE_DATETIME,
			'post_content_filtered' => self::TYPE_TEXT,
			'post_parent' => self::TYPE_BIGINT,
			'guid' => self::TYPE_VARCHAR,
			'menu_order' => self::TYPE_INT,
			'post_type' => self::TYPE_VARCHAR,
			'post_mime_type' => self::TYPE_VARCHAR,
			'comment_count' => self::TYPE_BIGINT,
		);
	}

	/**
	 * Returns all post entries for the API
	 *
	 * @return array
	 */
	public function getPosts()
	{
		$sql = '    SELECT posts.ID AS id,
				           users.user_nicename AS author,
				           posts.post_content AS content,
				           posts.post_title AS title,
				           posts.post_status AS status,
				           posts.post_date AS date,
				           posts.post_modified AS modified,
				           posts.guid AS guid
				      FROM wp_posts posts
				INNER JOIN wp_users users
				        ON posts.post_author = users.ID
				     WHERE posts.post_status = "publish"
				       AND posts.post_type = "post"
				  ORDER BY posts.post_date DESC
				     LIMIT 16';

		return $this->connection->fetchAll($sql);
	}

	/**
	 * Returns one post entry by id
	 *
	 * @return array
	 */
	public function getPostById($id)
	{
		$sql = '    SELECT posts.ID AS id,
				           users.user_nicename AS author,
				           posts.post_content AS content,
				           posts.post_title AS title,
				           posts.post_status AS status,
				           posts.post_date AS date,
				           posts.post_modified AS modified,
				           posts.guid AS guid
				      FROM wp_posts posts
				INNER JOIN wp_users users
				        ON posts.post_author = users.ID
				     WHERE posts.post_status = "publish"
				       AND posts.post_type = "post"
				       AND posts.ID = :id';

		return $this->connection->fetchAssoc($sql, array('id' => $id));
	}
}
