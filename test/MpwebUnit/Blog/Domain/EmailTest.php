<?php

namespace MpwebUnit\Blog\Domain;

use InvalidArgumentException;
use Mpweb\Blog\Domain\Email;


final class EmailTest extends \PHPUnit_Framework_TestCase
{

    private $email;

    protected function tearDown()
    {
        $this->email = null;

    }

    /** @test
    * @dataProvider ValidEmailDataProvider
    */

    public function shouldCreateAnEmailObjectWhenAValidEmailIsGiven($email)
    {

        $this->email = new Email($email);
        $this->assertInstanceOf(Email::class, $this->email);
    }

    public function ValidEmailDataProvider()
    {
        return [

            ['angel@gmail.com'],
            ['algo@msn.com'],
            ['eden.hazard@students.salle.url.edu'],
        ];
    }

    /** @test
     * @dataProvider InvalidEmailDataProvider
     */

    public function shouldThrowAnExceptionWhenAnInvalidEmailIsGiven($email)
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage($email.' is not a valid email address');
        $this->email = new Email($email);

    }

    public function InvalidEmailDataProvider()
    {
        return [

            'two @'     =>  ['angel@@gmail.com'],
            'missing @' =>  ['algoomsn.com'],
            'two docks' =>  ['eden.hazard@students..salle.url.edu'],
        ];
    }



}