<?php


namespace MpwebIntegration\Blog;


use Mpweb\Blog\Domain\Event;
use Mpweb\Blog\Domain\EventQueue;

class ArrayEventQueue implements EventQueue
{

    private $eventQueue;
    public function __construct()
    {
        $this->eventQueue=[];
    }
    public function publish(Event $event)
    {
        $this->eventQueue[] = $event;
    }

    public function isPublish(Event $event):bool
    {

        if (in_array($event,$this->eventQueue)) {

            return true;
        }
        return false;
    }

}