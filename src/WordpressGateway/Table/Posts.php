<?php

namespace WordpressGateway\Table;

use PSX\Framework\Util\Uuid;
use PSX\Sql\TableAbstract;
use PSX\Sql\Field;

/**
 * Posts
 */
class Posts extends TableAbstract
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
        $sql = '    SELECT posts.ID,
                           posts.post_date_gmt,
                           posts.post_content,
                           posts.post_title,
                           posts.post_excerpt,
                           posts.post_status,
                           posts.post_modified_gmt,
                           posts.guid,
                           posts.comment_count,
                           users.user_nicename,
                           users.user_url,
                           users.user_registered
                      FROM wp_posts posts
                INNER JOIN wp_users users
                        ON posts.post_author = users.ID
                     WHERE posts.post_status = "publish"
                       AND posts.post_type = "post"
                  ORDER BY posts.post_date DESC
                     LIMIT 16';

        $definition = [
            'entry' => $this->provider->newCollection($sql, [], [
                'id' => new Field\Callback('ID', function($id){
                    return Uuid::nameBased($id);
                }),
                'content' => 'post_content',
                'title' => 'post_title',
                'excerpt' => 'post_excerpt',
                'status' => 'post_status',
                'href' => 'guid',
                'createdAt' => new Field\DateTime('post_date_gmt'),
                'updatedAt' => new Field\DateTime('post_modified_gmt'),
                'commentCount' => 'comment_count',
                'author' => [
                    'displayName' => 'user_nicename',
                    'url' => 'user_url',
                    'createdAt' => new Field\DateTime('user_registered'),
                ],
            ])
        ];

        return $this->builder->build($definition);
    }

    /**
     * Returns one post entry by id
     *
     * @return array
     */
    public function getPostById($id)
    {
        $sql = '    SELECT posts.ID,
                           posts.post_date_gmt,
                           posts.post_content,
                           posts.post_title,
                           posts.post_excerpt,
                           posts.post_status,
                           posts.post_modified_gmt,
                           posts.guid,
                           posts.comment_count,
                           users.user_nicename,
                           users.user_url,
                           users.user_registered
                      FROM wp_posts posts
                INNER JOIN wp_users users
                        ON posts.post_author = users.ID
                     WHERE posts.post_status = "publish"
                       AND posts.post_type = "post"
                       AND posts.ID = :id';

        $definition = $this->provider->newEntity($sql, ['id' => $id], [
            'id' => new Field\Callback('ID', function($id){
                return Uuid::nameBased($id);
            }),
            'content' => 'post_content',
            'title' => 'post_title',
            'excerpt' => 'post_excerpt',
            'status' => 'post_status',
            'href' => 'guid',
            'createdAt' => new Field\DateTime('post_date_gmt'),
            'updatedAt' => new Field\DateTime('post_modified_gmt'),
            'commentCount' => 'comment_count',
            'author' => [
                'displayName' => 'user_nicename',
                'url' => 'user_url',
                'createdAt' => new Field\DateTime('user_registered'),
            ],
        ]);

        return $this->builder->build($definition);
    }
}
