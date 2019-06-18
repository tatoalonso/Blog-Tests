<?php


namespace Mpweb\Blog\Domain;



class User
{

    private $password;

    private $email;

    public function __construct( $password,  $email)
    {
        $this->email = new Email($email);

        $this->password = new Password($password);
    }

    public function getPassword():Password
    {
        return $this->password;
    }

    public function getEmail():Email
    {
        return $this->email;
    }

    public function setPassword($password):void
    {
        $this->password = new Password($password);
    }

    public function setEmail($email):void
    {
        $this->email = new Email($email);
    }


}