<?php

namespace WordpressGateway\Website\Application;

use PSX\Api\Documentation\Generator;
use PSX\Api\Documentation\Generator\Sample;
use PSX\Api\Documentation\Generator\Sample\Loader;
use PSX\Controller\ViewAbstract;
use PSX\Controller\Tool\DocumentationController;
use PSX\Data\Schema\Generator as SchemaGenerator;

class Index extends DocumentationController
{
	protected function getMetaLinks()
	{
		return array(
			'Welcome'        => $this->reverseRouter->getAbsolutePath('WordpressGateway\Website\Application\Doc\Welcome'),
			'Authentication' => $this->reverseRouter->getAbsolutePath('WordpressGateway\Website\Application\Doc\Authentication'),
			'Error-Handling' => $this->reverseRouter->getAbsolutePath('WordpressGateway\Website\Application\Doc\ErrorHandling'),
		);
	}

	protected function getViewGenerators()
	{
		return array(
			'Schema'  => new Generator\Schema(new SchemaGenerator\Html()),
			'Example' => new Sample(new Loader\XmlFile(__DIR__ . '/../Resource/api_sample.xml')),
		);
	}
}
