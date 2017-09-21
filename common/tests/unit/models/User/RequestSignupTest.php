<?php

namespace common\tests\unit\models\User;

use Codeception\Test\Unit;
use common\models\User;

class RequestSignupTest extends Unit
{
    public function testSuccess()
    {
        $user = User::requestSignup(
            $username = 'username',
            $name1 = 'name1',
            $name2 = 'name2',
            $name3 = 'name3',
            $email = 'email@site.com',
            $password = 'password'
        );

        $this->assertEquals($username, $user->username);
        $this->assertEquals($email, $user->email);
        $this->assertNotEmpty($user->password_hash);
        $this->assertNotEquals($password, $user->password_hash);
        $this->assertNotEmpty($user->created_at);
        $this->assertNotEmpty($user->auth_key);
        $this->assertNotEmpty($user->email_confirm_token);
        $this->assertTrue($user->isWait());
        $this->assertFalse($user->isActive());
    }
}