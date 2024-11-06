<?php

declare(strict_types=1);

it('can retrieve a random inspirational quote', function () {
    $quote = app()->make('Hooks')->getQuote();

    expect($quote)->tobe('For every Sage there is an Acorn.');
});

it('can retrieve post content', function () {
    $postId = 123;
    $post = new stdClass();
    $post->post_content = 'Hello World!';

    WP_Mock::userFunction('get_post')
        ->once()
        ->with(123)
        ->andReturn($post);

    $postContent = app()->make('Hooks')->getPostContent($postId);

    expect($postContent)->tobe('Hello World!');
});
