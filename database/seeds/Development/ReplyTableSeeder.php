<?php

use App\Reply;
use App\Thread;
use Illuminate\Database\Seeder;

class ReplyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $threads = Thread::all();

        $threads->each(function ($thread) {
            factory(Reply::class, 30)->create(['thread_id' => $thread->id]);
        });
    }
}
