<?php


namespace MpwebUnit\Blog\Domain;


use Mpweb\Blog\Domain\Post;
use Mpweb\Blog\Domain\PostEvent;
use PHPUnit_Framework_MockObject_MockObject;

final class PostEventTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PostEvent
     */
    private $postEvent;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */

    private $postMock;


    protected function setUp()
    {

        $this->postMock = $this->createMock(Post::class);
        $this->postEvent = new PostEvent($this->postMock);

    }

    protected function tearDown()
    {
        $this->postMock = null;

        $this->postEvent = null;
    }
    /** @test
     *
     */

    public function shouldGetThePasswordWhenAValidPasswordIsGiven()
    {

        $this->assertInstanceOf(Post::class, $this->postEvent->getPost());

    }

}