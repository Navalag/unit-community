<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Validator;

class UpdateUserSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        $this->markTestSkipped('Set up user update tests later!');

        $this->refreshApplicationWithLocale('en');

        $this->withExceptionHandling();

        $this->signIn();
    }

    /** @test  */
    function can_update_email_if_not_verified()
    {
        $user = create(User::class);

        $this->assertFalse($user->email_verified_at == null);

        $user->email = 'test@mail.com';

        $this->assertEquals('test@mail.com', $user->email);
    }

    /** @test  */
    function cannot_update_email_if_verified()
    {
        $user = create('App\User');

        $this->assertTrue($user->email_verified_at != null);

        $user->email = 'test@mail.com';

        $this->assertNotEquals('test@mail.com', $user->email);
    }

    public function providedData()
    {
        return [
            [['username' => 'Jora']],
            [['username' => 'John']],
            [['email' => 'mail@mail.com']],
            [['email' => 'notfail@mail.com']],
            [['oldPassword' => null]],
            [['newPassword' => null]],
            [['confirmNewPassword' => null]],
        ];
    }

    /**
     * @test
     * @dataProvider providedData
     */
    function form_can_pass_validation($data)
    {
        $user = create('App\User');

        $request = new UpdateUserRequest();

        $validator = Validator::make($data, $request->rules());

        $this->assertTrue($validator->passes());

    }

 }
