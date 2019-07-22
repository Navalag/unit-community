<?php

use App\User;
use Illuminate\Database\Seeder;
use Faker\Factory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $users = factory(User::class, 20)->create();
        $channels = factory(App\Channel::class, 6)->create()->toArray();

        $users->each(function ($user) use ($channels, $faker) {
            $thread = factory(App\Thread::class)->create([
                'user_id' => $user->id,
                'channel_id' => $faker->randomElements($channels)[0]['id'],
            ]);

            factory(App\Reply::class, 5)->create([
                'thread_id' => $thread->id,
                'user_id' => $user->id,
            ]);
        });
    }
}
