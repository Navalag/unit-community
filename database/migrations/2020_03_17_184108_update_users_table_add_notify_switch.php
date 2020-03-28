<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersTableAddNotifySwitch extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_receive_thread_updates_mail')->default(true)->after('avatar_path');
            $table->boolean('is_receive_reply_reactions_mail')->default(true)->after('is_receive_thread_updates_mail');
            $table->boolean('is_receive_mention_mail')->default(true)->after('is_receive_reply_reactions_mail');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_receive_thread_updates_mail');
            $table->dropColumn('is_receive_reply_reactions_mail');
            $table->dropColumn('is_receive_mention_mail');
        });
    }
}
