<?php


namespace Mpweb\Blog\Domain;

use InvalidArgumentException;


class Password
{
    const MIN_PASSWORD_LENGTH =  3;
    const MAX_PASSWORD_LENGTH = 28;
    const REGEX_PASS = '/S*(?=\S*[a-zA-Z])(?=\S*[\d])\S*$/';

    private $password;

    private $hashPassword;

    public function __construct($passwordToValidate)
    {
        if($this->passwordValidation($passwordToValidate))
        {

            $this->password = $passwordToValidate;
            $this->hashPassword = password_hash($this->password, PASSWORD_DEFAULT);

        }

    }

    private function passwordValidation(string $passwordToValidate):bool
    {
        $passwordLength= mb_strlen($passwordToValidate);

        if((self::MIN_PASSWORD_LENGTH > $passwordLength) || (self::MAX_PASSWORD_LENGTH < $passwordLength))
        {

            throw new InvalidArgumentException('Invalid password length');

        }

        if((!preg_match(self::REGEX_PASS, $passwordToValidate)))
        {

            throw new InvalidArgumentException('Invalid password format');

        }

        return true;

    }

    public function getPasswordHash()
    {

        return $this->hashPassword;

    }

}