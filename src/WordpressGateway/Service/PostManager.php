<?php

namespace WordpressGateway\Service;

use DateTime;
use PSX\Data\RecordInterface;
use PSX\Filter;
use PSX\Http\Exception as HttpException;
use PSX\Validate;
use PSX\Validate\Property;
use PSX\Validate\RecordValidator;
use WordpressGateway\Api\Posts\PostTable;

class PostManager
{
	protected $postTable;

	public function __construct(PostTable $postTable)
	{
		$this->postTable = $postTable;
	}

	public function getPosts()
	{
		return $this->postTable->getPosts();
	}

	public function getPostById($id)
	{
		return $this->postTable->getPostById($id);
	}

	public function insert($authorId, RecordInterface $record)
	{
		$this->getValidator()->validate($record);

		$content = $record->getContent();
		$title   = $record->getTitle();
		$status  = $record->getStatus();

		$this->postTable->create(array(
			'post_author'   => $authorId,
			'post_date'     => new DateTime(),
			'post_date_gmt' => new DateTime(),
			'post_content'  => $content,
			'post_title'    => $title,
			'post_status'   => $status,
		));
	}

	public function update($authorId, RecordInterface $record)
	{
		$post = $this->postTable->get($record->getId());

		if(empty($post))
		{
			throw new HttpException\NotFoundException('Post does not exist');
		}

		$this->getValidator()->validate($record);

		$content = $record->getContent();
		$title   = $record->getTitle();
		$status  = $record->getStatus();

		$fields = array(
			'ID'                => $post['ID'],
			'post_author'       => $authorId,
			'post_modified'     => new DateTime(),
			'post_modified_gmt' => new DateTime(),
		);

		if(!empty($content))
		{
			$fields['post_content'] = $content;
		}

		if(!empty($title))
		{
			$fields['post_title'] = $title;
		}

		if(!empty($status))
		{
			$fields['post_status'] = $status;
		}

		$this->postTable->update($fields);
	}

	public function delete($authorId, RecordInterface $record)
	{
		$post = $this->postTable->get($record->getId());

		if(empty($post))
		{
			throw new HttpException\NotFoundException('Post does not exist');
		}

		$this->postTable->delete(array(
			'ID' => $record->getId(),
		));
	}

	protected function getValidator()
	{
		return new RecordValidator(new Validate(), array(
			new Property('id', Validate::TYPE_INTEGER),
			new Property('title', Validate::TYPE_STRING, array(new Filter\Html())),
			new Property('content', Validate::TYPE_STRING),
			new Property('status', Validate::TYPE_STRING),
		));
	}
}
