<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Notifications\VerifyEmailChange;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;
use Illuminate\Support\Facades\Notification;

class UserSettingsController extends Controller
{
    /**
     * Update user
     *
     * @param User $user
     * @param UpdateUserRequest $request
     * @return Response
     */
    public function update(User $user, UpdateUserRequest $request)
    {
        $newEmailNotVerifiedMessage = null;
        $user_id = Auth::user()->id;
        $currentUser = $user->find($user_id);
        $request->filled('name') ? $currentUser->name = $request->name : 0;

        if (!$currentUser->email_verified_at) {
            $request->filled('email') ? $currentUser->email = $request->email : 0;
            $currentUser->sendEmailVerificationNotification();
        }

        if ($currentUser->email_verified_at && $request->filled('email') && $currentUser->email != $request->email) {
            Notification::route('mail', $request->email)->notify(new VerifyEmailChange($currentUser, $request->email));
            $newEmailNotVerifiedMessage = trans('auth.user_settings.after_verifying');
        }

        $request->filled('newPassword') ? $currentUser->password = Hash::make($request->newPassword) : 0;

         $currentUser->is_receive_thread_updates_mail = $request->notifications['notifyThreadWasUpdated'];
         $currentUser->is_receive_reply_reactions_mail = $request->notifications['notifyReplyReaction'];
         $currentUser->is_receive_mention_mail = $request->notifications['notifyMention'];

        if ($currentUser->save()) {
            $currentUser->message = trans('common.updated_successfully');
            $currentUser->emailMessage = $newEmailNotVerifiedMessage;

            return response($currentUser, 200);
        }

        return response(['message' => trans('common.error_general')]);
    }

    /**
     * Update email
     *
     * @param User $user
     * @param Request $request
     * @return RedirectResponse|Redirector
     */
    public function updateEmail(User $user, Request $request)
    {
        $user = $user->find($request->id);

        if (md5($user->email) == $request->token) {
            $user->email = $request->email;
            $user->email_verified_at = Carbon::now();
            $user->save();
            Auth::login($user, true);
        }

        return redirect('/');
    }
}
