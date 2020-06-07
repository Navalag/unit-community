<?php

namespace Tests\Feature;

use App\Reply;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_fetch_their_most_recent_reply()
    {
        $user = create(User::class);

        $reply = create(Reply::class, ['user_id' => $user->id]);

        $this->assertEquals($reply->id, $user->lastReply->id);
    }

    /** @test */
    function a_user_can_determine_their_avatar_path()
    {
        $user = create(User::class);

        $this->assertEquals(asset('images/svg-sprite/icon-ava-' . strtolower(substr($user->name, 0, 1)) . '.svg'), $user->avatar_path);

        $user->avatar_path = 'avatars/me.jpg';

        $this->assertEquals(asset('storage/avatars/me.jpg'), $user->avatar_path);
    }
}
