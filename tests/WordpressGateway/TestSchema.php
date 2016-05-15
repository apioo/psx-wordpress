<?php

namespace WordpressGateway;

use Doctrine\DBAL\Schema\Schema;

class TestSchema
{
    public static function getSchema()
    {
        $schema = new Schema();

        $table = $schema->createTable('wp_users');
        $table->addColumn('ID', 'integer', array('autoincrement' => true));
        $table->addColumn('user_login', 'string', array('length' => 60, 'default' => ''));
        $table->addColumn('user_pass', 'string', array('length' => 64, 'default' => ''));
        $table->addColumn('user_nicename', 'string', array('length' => 50, 'default' => ''));
        $table->addColumn('user_email', 'string', array('length' => 100, 'default' => ''));
        $table->addColumn('user_url', 'string', array('length' => 100, 'default' => ''));
        $table->addColumn('user_registered', 'datetime', array('default' => '0000-00-00 00:00:00'));
        $table->addColumn('user_activation_key', 'string', array('length' => 60, 'default' => ''));
        $table->addColumn('user_status', 'integer', array('default' => 0));
        $table->addColumn('display_name', 'string', array('length' => 250, 'default' => ''));
        $table->setPrimaryKey(array('ID'));

        $table = $schema->createTable('wp_posts');
        $table->addColumn('ID', 'integer', array('autoincrement' => true));
        $table->addColumn('post_author', 'integer');
        $table->addColumn('post_date', 'datetime', array('default' => '0000-00-00 00:00:00'));
        $table->addColumn('post_date_gmt', 'datetime', array('default' => '0000-00-00 00:00:00'));
        $table->addColumn('post_content', 'text');
        $table->addColumn('post_title', 'text');
        $table->addColumn('post_excerpt', 'text');
        $table->addColumn('post_status', 'string', array('length' => 20, 'default' => 'publish'));
        $table->addColumn('comment_status', 'string', array('length' => 20, 'default' => 'open'));
        $table->addColumn('ping_status', 'string', array('length' => 20, 'default' => 'open'));
        $table->addColumn('post_password', 'string', array('length' => 20, 'default' => ''));
        $table->addColumn('post_name', 'string', array('length' => 200, 'default' => ''));
        $table->addColumn('to_ping', 'text', array('default' => ''));
        $table->addColumn('pinged', 'text', array('default' => ''));
        $table->addColumn('post_modified', 'datetime', array('default' => '0000-00-00 00:00:00'));
        $table->addColumn('post_modified_gmt', 'datetime', array('default' => '0000-00-00 00:00:00'));
        $table->addColumn('post_content_filtered', 'text', array('default' => ''));
        $table->addColumn('post_parent', 'integer', array('default' => 0));
        $table->addColumn('guid', 'string', array('length' => 255, 'default' => ''));
        $table->addColumn('menu_order', 'integer', array('default' => 0));
        $table->addColumn('post_type', 'string', array('length' => 20, 'default' => 'post'));
        $table->addColumn('post_mime_type', 'string', array('length' => 100, 'default' => ''));
        $table->addColumn('comment_count', 'integer', array('default' => 0));
        $table->setPrimaryKey(array('ID'));

        $table = $schema->createTable('wp_access_token');
        $table->addColumn('ID', 'integer', array('autoincrement' => true));
        $table->addColumn('user_id', 'integer');
        $table->addColumn('access_token', 'string', array('length' => 255));
        $table->addColumn('expires', 'string', array('length' => 32));
        $table->addColumn('remote_addr', 'string', array('length' => 64));
        $table->addColumn('insert_date', 'datetime');
        $table->setPrimaryKey(array('ID'));

        return $schema;
    }
}
