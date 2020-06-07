<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MentionUsersTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->refreshApplicationWithLocale('en');
    }

    /** @test */
    function mentioned_users_in_a_reply_are_notified()
    {
        // Given we have a user, JohnDoe, who is signed in.
        $john = create(User::class, ['name' => 'JohnDoe']);

        $this->signIn($john);

        // And we also have a user, JaneDoe.
        $jane = create(User::class, ['name' => 'JaneDoe']);

        // If we have a thread
        $thread = create(Thread::class);

        // And JohnDoe replies to that thread and mentions @JaneDoe.
        $reply = make(Reply::class, [
            'body' => 'Hey @JaneDoe check this out.'
        ]);

        $this->json('post', $thread->path() . '/replies', $reply->toArray());

        // Then @JaneDoe should receive a notification.
        $this->assertCount(1, $jane->notifications);
    }

    /** @test */
    function it_can_fetch_all_mentioned_users_starting_with_the_given_characters()
    {
        create(User::class, ['name' => 'johndoe']);
        create(User::class, ['name' => 'johndoe2']);
        create(User::class, ['name' => 'janedoe']);

        $results = $this->json('GET', route('api.users', ['name' => 'john']));

        $this->assertCount(2, $results->json()['result']);
    }
}

