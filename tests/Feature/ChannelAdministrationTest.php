<?php

namespace Tests\Feature;

use App\Channel;
use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class ChannelAdministrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withExceptionHandling();
        $this->refreshApplicationWithLocale('en');
    }

    /** @test */
    public function an_administrator_can_create_a_channel()
    {
        $this->createChannel([
            'name' => 'php',
            'description' => 'This is the channel for discussing all things PHP.',
        ]);

        $this->get('/en/channels')
            ->assertSee('php')
            ->assertSee('This is the channel for discussing all things PHP.');
    }

    /** @test */
    public function non_administrators_cannot_create_channels()
    {
        $this->expectException('Symfony\Component\HttpKernel\Exception\HttpException');

        $regularUser = create(User::class);


        $this->actingAs($regularUser)
            ->post('/en/channels', [
                'name' => 'forbidden',
                'description' => 'forbidden channel description',
            ]);
    }

    /** @test */
    public function non_administrators_cannot_edit_channels()
    {
        $this->expectException('Symfony\Component\HttpKernel\Exception\HttpException');

        $regularUser = create(User::class);
        $channel = create(Channel::class);

        $this->actingAs($regularUser)
            ->patch('/en/channels/' . $channel->slug, [
                'name' => 'forbidden',
                'description' => 'forbidden channel description',
            ]);
    }

    /** @test */
    public function non_administrators_cannot_delete_channels()
    {
        $this->expectException('Symfony\Component\HttpKernel\Exception\HttpException');

        $regularUser = create(User::class);
        $channel = create(Channel::class);

        $this->actingAs($regularUser)
            ->delete('/en/channels/' . $channel->slug, [
                'name' => 'forbidden',
                'description' => 'forbidden channel description',
            ]);
    }

    /** @test */
    public function an_administrator_can_edit_an_existing_channel()
    {
        $this->signInAdmin();

        $this->patch(
            '/en/channels/' . create(Channel::class)->slug,
            $updatedChannel = [
                'name' => 'altered',
                'description' => 'altered channel description',
            ]
        );

        $this->get('/en/channels')
            ->assertSee($updatedChannel['name'])
            ->assertSee($updatedChannel['description']);
    }

    /** @test */
    public function an_administrator_cannot_delete_channel_with_threads()
    {
        $this->expectException('Symfony\Component\HttpKernel\Exception\HttpException');

        $this->signInAdmin();

        $thread = create(Thread::class);

        $this->delete('/en/channels/' . $thread->channel->slug);
    }

    /** @test */
    public function an_administrator_can_delete_channel_without_threads()
    {
        $this->signInAdmin();

        $channel = create(Channel::class);

        $this->delete('/en/channels/' . $channel->slug)
            ->assertStatus(302);
    }

    /** @test */
    public function a_channel_requires_a_name()
    {
        $this->expectException(ValidationException::class);

        $this->createChannel(['name' => null]);
    }

    /** @test */
    public function a_channel_requires_a_description()
    {
        $this->expectException(ValidationException::class);

        $this->createChannel(['description' => null]);
    }

    protected function createChannel($overrides = [])
    {
        $this->signInAdmin();

        $channel = make(Channel::class, $overrides);

        return $this->post('/en/channels', $channel->toArray());
    }
}
