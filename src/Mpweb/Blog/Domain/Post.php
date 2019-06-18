<?php

namespace Mpweb\Blog\Domain;

use InvalidArgumentException;

class Post
{
    const MAX_TITLE_LENGTH = 50;
    const MAX_BODY_LENGTH = 2000;

    private $title;

    private $body;

    public function __construct($title, $body)
    {
        $this->titleValidation($title);
        $this->bodyValidation($body);

        $this->title =$title;
        $this->body =$body;

    }

    private function titleValidation($titleToValidate)
    {

        if ($titleToValidate === '')
        {
            throw new InvalidArgumentException('The tittle can´t be empty');

        }

        $titleLength = mb_strlen($titleToValidate);

        if ($titleLength > self::MAX_TITLE_LENGTH)
        {
            throw new InvalidArgumentException('Invalid tittle length');

        }


    }

    private function bodyValidation($bodyToValidate)
    {

        if ($bodyToValidate === '')
        {
            throw new InvalidArgumentException('The body can´t be empty');

        }

        $bodyLength = mb_strlen($bodyToValidate);

        if ($bodyLength > self::MAX_BODY_LENGTH)
        {
            throw new InvalidArgumentException('Invalid body length');

        }
    }

    public function getTitle()
    {
        return $this->title;
    }





}