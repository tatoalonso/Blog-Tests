<?php


namespace Mpweb\Blog\Domain;


use InvalidArgumentException;

class Email
{

    private $email;

    public function __construct($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("$email is not a valid email address");
        }

        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }



}