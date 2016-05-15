<?php

namespace WordpressGateway\Service;

use PSX\DateTime\DateTime;
use PSX\Record\RecordInterface;
use PSX\Http\Exception as HttpException;
use PSX\Validate\Filter;
use WordpressGateway\Table\Posts as PostsTable;

class Posts
{
    /**
     * @var \WordpressGateway\Table\Posts
     */
    protected $postsTable;

    public function __construct(PostsTable $postsTable)
    {
        $this->postsTable = $postsTable;
    }

    public function getPosts()
    {
        return $this->postsTable->getPosts();
    }

    public function getPost($id)
    {
        $post = $this->postsTable->getPostById($id);

        if (empty($post)) {
            throw new HttpException\NotFoundException('Invalid post');
        }

        return $post;
    }

    public function insert($authorId, RecordInterface $record)
    {
        $content = $record->content;
        $title   = $record->title;
        $excerpt = $record->excerpt ?: '';
        $status  = $record->status ?: 'publish';

        $this->postsTable->create(array(
            'post_author'   => $authorId,
            'post_date'     => new DateTime(),
            'post_date_gmt' => new DateTime(),
            'post_content'  => $content,
            'post_title'    => $title,
            'post_excerpt'  => $excerpt,
            'post_status'   => $status,
        ));
    }

    public function update($authorId, RecordInterface $record)
    {
        $post = $this->postsTable->get($record->id);

        if (empty($post)) {
            throw new HttpException\NotFoundException('Post does not exist');
        }

        $content = $record->content;
        $title   = $record->title;
        $status  = $record->status;

        $fields = array(
            'ID'                => $post->ID,
            'post_author'       => $authorId,
            'post_modified'     => new DateTime(),
            'post_modified_gmt' => new DateTime(),
        );

        if (!empty($content)) {
            $fields['post_content'] = $content;
        }

        if (!empty($title)) {
            $fields['post_title'] = $title;
        }

        if (!empty($status)) {
            $fields['post_status'] = $status;
        }

        $this->postsTable->update($fields);
    }

    public function delete($authorId, $postId)
    {
        $post = $this->postsTable->get($postId);

        if (empty($post)) {
            throw new HttpException\NotFoundException('Post does not exist');
        }

        if ($post->post_author != $authorId) {
            throw new HttpException\BadRequestException('Can only remove posts from yourself');
        }

        $this->postsTable->delete(array(
            'ID' => $post->ID,
        ));
    }
}
