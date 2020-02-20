<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Notifications\VerifyEmailChange;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;
use Illuminate\Support\Facades\Notification;

class UserSettingsController extends Controller
{
    /**
     * Update user settings
     *
     * @param  UpdateUserRequest $request
     * @return Response
     */
    public function update(User $user, UpdateUserRequest $request)
    {
            $newEmailNotVerifiedMessage = null;
            $user_id = Auth::user()->id;
            $currentUser = $user->find($user_id);
            $request->filled('name') ? $currentUser->name = $request->name : 0;

            if(!$currentUser->email_verified_at){
                $request->filled('email') ? $currentUser->email = $request->email : 0;
                $currentUser->sendEmailVerificationNotification();
            }
            if($currentUser->email_verified_at && $request->filled('email')){
                Notification::route('mail', $request->email)->notify(new VerifyEmailChange($currentUser, $request->email));
                $newEmailNotVerifiedMessage = __('Your email will be changed after verifying');
            }

            $request->filled('newPassword') ? $currentUser->password = Hash::make($request->newPassword) : 0;

            if($currentUser->save()) {
                $currentUser->message = __('Updated successfully');
                $currentUser->emailMessage = $newEmailNotVerifiedMessage;
                return response($currentUser, 200);
            }

            return response(['message' => __('Something went wrong')]);
    }

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
