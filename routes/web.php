<?php

use App\Http\Controllers\ChannelsController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localize', 'localeSessionRedirect', 'localeCookieRedirect', 'saveLocale']
    ], function() {
    Route::get('/', function () {
        return redirect('/threads');
    });

    Auth::routes(['verify' => true]);

    Route::get('threads', 'ThreadsController@index')->name('threads');
    Route::get('threads/create', 'ThreadsController@create')->middleware('verified')->name('threads.create');
    Route::get('threads/{channel}/{thread}', 'ThreadsController@show');
    Route::patch('threads/{channel}/{thread}', 'ThreadsController@update');
    Route::delete('threads/{channel}/{thread}', 'ThreadsController@destroy');
    Route::post('threads', 'ThreadsController@store')->middleware('verified')->name('threads.store');
    Route::get('threads/{channel}', 'ThreadsController@index')->name('threads.channel');

    Route::post('locked-threads/{thread}', 'LockedThreadsController@store')->name('locked-threads.store')->middleware('admin');
    Route::delete('locked-threads/{thread}', 'LockedThreadsController@destroy')->name('locked-threads.destroy')->middleware('admin');

    Route::post('pinned-threads/{thread}', 'PinnedThreadsController@store')->name('pinned-threads.store')->middleware('admin');
    Route::delete('pinned-threads/{thread}', 'PinnedThreadsController@destroy')->name('pinned-threads.destroy')->middleware('admin');

    Route::get('/threads/{channel}/{thread}/replies', 'RepliesController@index')->name('threads.channel.replies.index');
    Route::post('/threads/{channel}/{thread}/replies', 'RepliesController@store')->name('threads.channel.replies.store');
    Route::patch('/replies/{reply}', 'RepliesController@update')->name('replies.update');
    Route::delete('/replies/{reply}', 'RepliesController@destroy')->name('replies.destroy');

    Route::post('/replies/{reply}/best', 'BestRepliesController@store')->name('best-replies.store');

    Route::post('/threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionsController@store')->middleware('auth');
    Route::delete('/threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionsController@destroy')->middleware('auth');

    Route::post('/replies/{reply}/favorites', 'FavoritesController@store')->name('replies.favorites.store');
    Route::delete('/replies/{reply}/favorites', 'FavoritesController@destroy')->name('replies.favorites.destroy');

    Route::get('/profiles/{user}', 'ProfilesController@show')->name('profile');
    Route::get('/profiles/{user}/notifications', 'UserNotificationsController@index')->name('profile.notifications.index');
    Route::delete('/profiles/{user}/notifications/{notification}', 'UserNotificationsController@destroy')->name('profile.notifications.destroy');

    Route::get('about', 'StaticPagesController@index');

    Route::patch('profiles/{user}/settings', 'UserSettingsController@update');
    Route::get('profiles/{user}/settings/update-email/{id}/{token}/{email}', 'UserSettingsController@updateEmail')->name('emailverification');

    Route::resource('channels', '\\' . ChannelsController::class)->only(['index', 'store', 'update', 'destroy']);
});

Route::get('api/users', 'Api\UsersController@index')->name('api.users');
Route::post('api/users/{user}/avatar', 'Api\UserAvatarController@store')->middleware('auth')->name('api.users.avatar');
