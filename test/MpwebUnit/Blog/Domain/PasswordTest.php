<?php


namespace MpwebUnit\Blog\Domain;


use InvalidArgumentException;
use Mpweb\Blog\Domain\Password;

final class PasswordTest extends \PHPUnit_Framework_TestCase
{

    private $password;


    protected function tearDown()
    {
        $this->password = null;
    }

    /** @test
     * @dataProvider ValidPasswordDataProvider
     */

    public function shouldCreateAPasswordObjectWhenAValidPasswordIsGiven($password)
    {

        $this->password = new Password($password);
        $this->assertInstanceOf(Password::class, $this->password);
    }

    public function ValidPasswordDataProvider()
    {
        return [

            ['angelgmail2com'],
            ['AAAAl3'],
            ['1.234%%"%e'],
        ];
    }

    /** @test
     * @dataProvider InvalidFormatPasswordDataProvider
     */

    public function shouldThrowAnExceptionWhenAnInvalidFormatPasswordIsGiven($password)
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid password format');
        $this->password = new Password($password);

    }

    public function InvalidFormatPasswordDataProvider()
    {
        return [

            'no number'     =>  ['angelcom'],
            'no letter   '  =>  ['11111111'],
            'no number2'    =>  ['eden.hazard@studE/'],
        ];
    }

    /** @test
     * @dataProvider InvalidLengthPasswordDataProvider
     */

    public function shouldThrowAnExceptionWhenAnInvalidLengthPasswordIsGiven($password)
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid password length');
        $this->password = new Password($password);

    }

    public function InvalidLengthPasswordDataProvider()
    {
        return [

            'no password provided' =>   [''],
            'too short length'     =>   ['12'],
            'too long  length'     =>   ['123456789A123456789b123456789'],
        ];
    }


}