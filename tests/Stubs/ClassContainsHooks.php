<?php

declare(strict_types=1);

namespace Yard\Hook\Tests\Stubs;

use Yard\Hook\Action;
use Yard\Hook\Filter;

class ClassContainsHooks
{
	#[Action('save_post', 10)]
	public function doSomething($one, $two): string
	{
		return 'parent';
	}

	#[Action('save_post', 5)]
	public function doSomethingElse($one, $two, $three)
	{
		//
	}

	#[Action('save_post')]
	public function doSomethingWithDefaultArgs()
	{
		//
	}

	#[Filter('the_content', 10)]
	public function filterSomething($one, $two)
	{
		//
	}

	#[Filter('the_content', 5)]
	public function filterSomethingElse($one)
	{
		//
	}

	#[Filter('the_content')]
	public function filterSomethingElseWithDefaultArgs()
	{
		//
	}

	#[Action('init')]
	#[Action('admin_init')]
	public function doSomethingOnInitAndAdminInit()
	{
		//
	}

	#[Action('fake_hook')]
	public function shouldNotGetRegistered()
	{
		throw new \Exception('This method should never be registered');
	}
}
