<?php

declare(strict_types=1);

use Yard\Hooks\Attributes\Action;

#[Action('save_post')]
function doSomethingOnSavePost($postId, $post): void
{
    // Do something
}
