<?php

namespace Tests\Feature;

use App\Reply;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FavoritesTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->refreshApplicationWithLocale('en');
    }

    /** @test */
    public function guests_cannot_favorite_anything()
    {
        $this->withExceptionHandling()
             ->post(route('replies.favorites.store', 1))
             ->assertRedirect(route('login'));
    }
    
    /** @test */
    public function an_authenticated_user_can_favorite_any_reply()
    {
        $this->signIn();

        $reply = create(Reply::class);

        $this->post(route('replies.favorites.store', $reply->id));

        $this->assertCount(1, $reply->favorites);
    }

    /** @test */
    public function an_authenticated_user_can_unfavorite_a_reply()
    {
        $this->signIn();

        $reply = create(Reply::class);

        $reply->favorite($reply, auth()->user());

        $this->delete(route('replies.favorites.destroy', $reply->id));

        $this->assertCount(0, $reply->favorites);
    }

    /** @test */
    public function an_authenticated_user_may_only_favorite_a_reply_once()
    {
        $this->signIn();

        $reply = create(Reply::class);

        try {
            $this->post(route('replies.favorites.store', $reply->id));
            $this->post(route('replies.favorites.store', $reply->id));
        } catch (\Exception $e) {
            $this->fail('Did not expect to insert the same record set twice.');
        }

        $this->assertCount(1, $reply->favorites);
    }
}
