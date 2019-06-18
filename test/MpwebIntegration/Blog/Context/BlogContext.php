<?php

namespace MpwebIntegration\Blog\Context;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Mpweb\Blog\Domain\Post;
use Mpweb\Blog\Domain\PostEvent;
use Mpweb\Blog\Domain\User;
use MpwebIntegration\Blog\ArrayEventQueue;
use MpwebIntegration\Blog\ArrayPostRepository;
use PHPUnit_Framework_Assert;
use Behat\Gherkin\Node\PyStringNode;


final class BlogContext implements Context
{


    private $postRepository;
    private $eventQueue;
    private $wasSaved;
    private $newPost;
    private $publishIntention;

    public function __construct()
    {
        $this->postRepository = new ArrayPostRepository();
        $this->eventQueue = new ArrayEventQueue();

    }

    /**
     * @Given a user with a valid <password> and a valid <email>
     */
    public function aUserWithAValidPasswordAndAValidEmail(TableNode $table)
    {

        foreach ($table->getColumnsHash() as $userCredentials) {
            $this->user = new User($userCredentials['password'], $userCredentials['email']);

        }
    }

    /**
     * @Given a valid post written with a valid <title> and a valid <body>
     */
    public function aValidPostWrittenWithAValidTitleAndAValidBody(TableNode $table)
    {
        foreach ($table->getColumnsHash() as $postComponents) {
            $this->post = new Post($postComponents['password'], $postComponents['email']);
        }

    }

    /**
     * @Given a post with :title and :body  which exists
     */

    public function aPostWithTitleAndBodyWhichExists($title,$body)
    {
        $post =new Post($title,$body);
        $this->postRepository->save($post);
        PHPUnit_Framework_Assert::AssertTrue($this->postRepository->exists($post));

    }

    /**
     * @When a user tries to create a post with the same :title and :body
     */

    public function aUserTriesToCreateAPostWithTheSameTitleAndBody($title,$body)
    {
        $post =new Post($title,$body);
        $this->wasSaved =$this->postRepository->save($post);

    }

    /**
     * @Then the post with can not be saved
     */
    public function thePostWithTitleAndBodyCanNotBeSaved()
    {
        PHPUnit_Framework_Assert::AssertFalse($this->wasSaved);

    }

    /**
     * @Given a post named :title with:
     */
    public function aNewPostNamedWith($title, PyStringNode $string)
    {

        $this->newPost =new Post($title,$string->getRaw());
    }

    /**
     * @When a user wants save it
     */
    public function aUserWantsSaveIt()
    {

        $this->wasSaved =$this->postRepository->save($this->newPost);

    }

    /**
     * @When not publish it
     */
    public function notPublishIt()
    {
        $this->publishIntention = false;
    }

    /**
     * @Then the :post will be saved
     */
    public function thePostWillBeSaved()
    {
        PHPUnit_Framework_Assert::AssertTrue($this->wasSaved);
    }

    /**
     * @Then the :post will not be publish
     */
    public function thePostWillNotBePublish()
    {   $newPostEvent = new PostEvent($this->newPost);
        $wasPublished = $this->eventQueue->isPublish($newPostEvent);
        PHPUnit_Framework_Assert::AssertFalse($wasPublished);
    }

    /**
     * @Given a another post named :title with:
     */
    public function aAnotherPostNamedWith($title, PyStringNode $string)
    {
        $this->newPost =new Post($title,$string->getRaw());
    }

    /**
     * @When publish it
     */
    public function publishIt()
    {
        $this->publishIntention = true;
    }

    /**
     * @Then the post will  be publish
     */
    public function thePostWillBePublish()
    {
        $newPostEvent = new PostEvent($this->newPost);
        $this->eventQueue->publish(new PostEvent($this->newPost));
        $wasPublished = $this->eventQueue->isPublish($newPostEvent);
        PHPUnit_Framework_Assert::AssertTrue($wasPublished);

    }





}
