<?php

namespace MpwebUnit\Blog\Application;


use Mpweb\Blog\Application\NewPostUseCase;
use Mpweb\Blog\Domain\EventQueue;
use Mpweb\Blog\Domain\Post;
use Mpweb\Blog\Domain\PostEvent;
use Mpweb\Blog\Domain\PostRepository;

class NewPostUseCaseTest extends \PHPUnit_Framework_TestCase
{

    const VALID_TITLE = "A Title";

    const VALID_CONTENT = "Some Content";

    private $newPostUseCase;

    private $postRepository;

    private $eventQueue;

    private $post;

    protected function setUp()
    {
        $this->post = new Post(self::VALID_TITLE, self::VALID_CONTENT);
        $this->postRepository = $this->createMock(PostRepository::class);
        $this->eventQueue = $this->createMock(EventQueue::class);
        $this->newPostUseCase = new NewPostUseCase($this->postRepository, $this->eventQueue);
    }

    protected function tearDown()
    {
        $this->post = null;
        $this->postRepository = null;
        $this->eventQueue = null;
        $this->newPostUseCase = null;
    }

    /** @test */
    public function shouldPersistAPostOneTimeIfItDoesNotExist()
    {
        $this->givenAPostRepositoryThatDoesntHaveASpecificPost();
        $this->thenThePostShouldBeSavedOnce();
        $this->whenTheNewPostUseCaseIsExecutedWithASpecificPost();
    }

    /** @test */
    public function shouldNotPersistAPostIfItAlreadyExists()
    {
        $this->givenAPostRepositoryThatHasASpecificPost();
        $this->thenThePostShouldNotBeSaved();
        $this->whenTheNewPostUseCaseIsExecutedWithASpecificPost();
    }

    /** @test */
    public function shouldPublishANewPostEventByDefaultIfThePostDoesNotExist()
    {
        $this->givenAPostRepositoryThatDoesntHaveASpecificPost();
        $this->thenAnEventShouldBePublished();
        $this->whenTheNewPostUseCaseIsExecutedWithASpecificPost();
    }

    /** @test */
    public function shouldNotPublishANewPostEventIfThePostAlreadyExists()
    {
        $this->givenAPostRepositoryThatHasASpecificPost();
        $this->thenAnEventShouldNotBePublished();
        $this->whenTheNewPostUseCaseIsExecutedWithASpecificPost();
    }

    /** @test */
    public function shouldPublishANewPostEventIfForcedToPublishAndThePostDoesNotExist()
    {
        $this->givenAPostRepositoryThatDoesntHaveASpecificPost();
        $this->thenAnEventShouldBePublished();
        $this->whenTheNewPostUseCaseIsExecutedAndForcedToPublishWithASpecificPost();
    }

    /** @test */
    public function shouldNotPublishANewPosEventIfForcedNotToPublishAndThePostDoesNotExist()
    {
        $this->givenAPostRepositoryThatDoesntHaveASpecificPost();
        $this->thenAnEventShouldNotBePublished();
        $this->whenTheNewPostUseCaseIsExecutedAndForcedNotToPublishWithASpecificPost();
    }

    public function shouldNotPublishANewPostEventIfForcedToPublishAndThePostAlreadyExists()
    {
        $this->givenAPostRepositoryThatHasASpecificPost();
        $this->thenAnEventShouldNotBePublished();
        $this->whenTheNewPostUseCaseIsExecutedAndForcedNotToPublishWithASpecificPost();
    }

    private function whenTheNewPostUseCaseIsExecutedWithASpecificPost()
    {
        $this->newPostUseCase->execute($this->post);
    }

    private function whenTheNewPostUseCaseIsExecutedAndForcedToPublishWithASpecificPost()
    {
        $this->newPostUseCase->execute($this->post, true);
    }

    private function whenTheNewPostUseCaseIsExecutedAndForcedNotToPublishWithASpecificPost()
    {
        $this->newPostUseCase->execute($this->post, false);
    }

    private function givenAPostRepositoryThatDoesntHaveASpecificPost()
    {
        $this->postRepository
            ->method('exists')
            ->willReturn(false);
    }

    private function thenThePostShouldBeSavedOnce()
    {
        $this->postRepository
            ->expects($this->once())
            ->method('save')
            ->with($this->isInstanceOf(Post::class));
    }

    private function givenAPostRepositoryThatHasASpecificPost()
    {
        $this->postRepository
            ->method('exists')
            ->willReturn(true);
    }

    private function thenThePostShouldNotBeSaved()
    {
        $this->postRepository
            ->expects($this->never())
            ->method('save');
    }

    private function thenAnEventShouldBePublished()
    {
        $this->eventQueue
            ->expects($this->once())
            ->method('publish')
            ->with($this->isInstanceOf(PostEvent::class));
    }

    private function thenAnEventShouldNotBePublished()
    {
        $this->eventQueue
            ->expects($this->never())
            ->method('publish');
    }

}