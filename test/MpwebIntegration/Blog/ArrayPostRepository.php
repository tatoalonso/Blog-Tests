<?php


namespace MpwebIntegration\Blog;

use Mpweb\Blog\Domain\PostRepository;
use Mpweb\Blog\Domain\Post;

class ArrayPostRepository implements PostRepository
{

    private $postRepository;

    public function __construct()
    {
        $this->postRepository=[];
    }
    public function exists(Post $post): bool
    {
        return in_array($post, $this->postRepository);
    }

    public function save(Post $post):bool
    {
        if (!$this->exists($post)) {
            $this->postRepository[] = $post;
            return true;
        }
        return false;
    }

}