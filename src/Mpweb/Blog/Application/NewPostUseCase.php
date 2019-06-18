<?php

namespace Mpweb\Blog\Application;


use Mpweb\Blog\Domain\EventQueue;
use Mpweb\Blog\Domain\Post;
use Mpweb\Blog\Domain\PostEvent;
use Mpweb\Blog\Domain\PostRepository;

class NewPostUseCase
{

    private $postRepository;

    private $eventQueue;

    public function __construct(PostRepository $postRepository,  EventQueue $eventQueue)
    {
        $this->postRepository = $postRepository;
        $this->eventQueue = $eventQueue;
    }

    public function execute(Post $post, $publish = true)
    {
        $exists = $this->postRepository->exists($post);
        if ($exists == true) return;
        $this->postRepository->save($post);
        if ($publish == false) return;
        $this->eventQueue->publish(new PostEvent($post));
    }

}