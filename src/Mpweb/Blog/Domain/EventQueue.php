<?php

namespace Mpweb\Blog\Domain;


interface EventQueue
{

    public function publish(Event $event);

}