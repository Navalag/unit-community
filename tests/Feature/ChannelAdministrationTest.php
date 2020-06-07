<?php

namespace Tests\Feature;

use App\Channel;
use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;

class ChannelAdministrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->refreshApplicationWithLocale('en');

        $this->withExceptionHandling();
    }

    /** @test */
    public function an_administrator_can_create_a_channel()
    {
        $this->createChannel([
            'name' => 'php',
            'description' => 'This is the channel for discussing all things PHP.',
        ]);

        $this->get(route('channels.index'))
            ->assertSee('php')
            ->assertSee('This is the channel for discussing all things PHP.');
    }

    /** @test */
    public function non_administrators_cannot_create_channels()
    {
        $regularUser = create(User::class);

        $this->actingAs($regularUser)
            ->post(route('channels.store'), [
                'name' => 'forbidden',
                'description' => 'forbidden channel description',
            ])
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function non_administrators_cannot_edit_channels()
    {
        $regularUser = create(User::class);
        $channel = create(Channel::class);

        $this->actingAs($regularUser)
            ->patch(route('channels.update', $channel->slug), [
                'name' => 'forbidden',
                'description' => 'forbidden channel description',
            ])
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function non_administrators_cannot_delete_channels()
    {
        $regularUser = create(User::class);
        $channel = create(Channel::class);

        $this->actingAs($regularUser)
            ->delete(route('channels.destroy', $channel->slug), [
                'name' => 'forbidden',
                'description' => 'forbidden channel description',
            ])
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function an_administrator_can_edit_an_existing_channel()
    {
        $this->signInAdmin();

        $this->patch(
            route('channels.update', create(Channel::class)->slug),
            $updatedChannel = [
                'name' => 'altered',
                'description' => 'altered channel description',
            ]
        );

        $this->get(route('channels.index'))
            ->assertSee($updatedChannel['name'])
            ->assertSee($updatedChannel['description']);
    }

    /** @test */
    public function an_administrator_cannot_delete_channel_with_threads()
    {
        $this->signInAdmin();

        $thread = create(Thread::class);

        $this->delete(route('channels.destroy', $thread->channel->slug))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function an_administrator_can_delete_channel_without_threads()
    {
        $this->signInAdmin();

        $channel = create(Channel::class);

        $this->delete(route('channels.destroy', $channel->slug))
            ->assertStatus(302);
    }

    /** @test */
    public function a_channel_requires_a_name()
    {
        $this->createChannel(['name' => null])
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function a_channel_requires_a_description()
    {
        $this->createChannel(['description' => null])
            ->assertSessionHasErrors('description');
    }

    protected function createChannel($overrides = [])
    {
        $this->signInAdmin();

        $channel = make(Channel::class, $overrides);

        return $this->post(route('channels.store'), $channel->toArray());
    }
}
