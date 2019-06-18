<?php


namespace MpwebUnit\Blog\Domain;



use InvalidArgumentException;
use Mpweb\Blog\Domain\Email;
use Mpweb\Blog\Domain\Password;
use Mpweb\Blog\Domain\User;

final class UserTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var User
     */
    private $user;



    protected function tearDown()
    {
        $this->user = null;

    }


    /** @test
     * @dataProvider ValidEmailAndPasswordDataProvider
     */

    public function shouldCreateAnUserObjectWhenAValidEmailAndAValidPasswordAreGiven($password, $email)
    {

        $this->user = new User($password,$email);
        $this->assertInstanceOf(User::class, $this->user);
    }

    public function ValidEmailAndPasswordDataProvider()
    {
        return [

            ['angelgmail2com','angel@gmail.com'  ],
            ['AAAAl3','algo@msn.com'],
            ['1.234%%"%e','eden.hazard@students.salle.url.edu'],

        ];
    }

    /** @test
     * @dataProvider InvalidEmailAndPasswordDataProvider
     */

    public function shouldThrowAnExceptionWhenAnInvalidEmailOrAndInvalidPaswordAreGiven($password, $email)
    {
        $this->expectException(InvalidArgumentException::class);
        $this->user = new User($password,$email);

    }

    public function InvalidEmailAndPasswordDataProvider()
    {
        return [

            'Invalid email,missing  @'     => ['angelgmail2com','angelgmail.com'  ],
            'Invalid password, no number'  => ['AAAAl','algo@msn.com'],
            'Invalid password & email'     => ['e','eden.hazardstudents.salle.url.edu'],

        ];
    }

    /** @test
     * @dataProvider ValidEmailAndPasswordDataProvider
     */

    public function shouldSetThePasswordWhenAValidPasswordIsGiven($password ,$email)
    {
        $this->user = new User($password,$email);
        $this->user->setPassword('Abcvl3');
        $this->assertInstanceOf(Password::class, $this->user->getPassword());
    }

    /** @test
     * @dataProvider ValidEmailAndPasswordDataProvider
     */

    public function shouldSetTheEmailWhenAValidPasswordIsGiven($password ,$email)
    {
        $this->user = new User($password,$email);
        $this->user->setEmail('newmail@gmail.com');
        $this->assertInstanceOf(Email::class, $this->user->getEmail());
    }





}