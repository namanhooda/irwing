<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  array<string, mixed>  $input
     */
    public function update(User $user, array $input): void
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'phone' => ['nullable', 'string', 'max:15'], // Add phone validation
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif', 'max:2048'], // Image validation
        ])->validateWithBag('updateProfileInformation');

        // Handle email verification if changed
        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'name' => $input['name'],
                'email' => $input['email'],
                'phone' => $input['phone'] ?? $user->phone,
            ])->save();
        }

        // Handle profile image upload
        if (isset($input['photo'])) {
            $path = $input['photo']->store('profile-photos', 'public');

            $user->forceFill([
                'profile' => $path,
            ])->save();
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  array<string, string>  $input
     */
    protected function updateVerifiedUser(User $user, array $input): void
    {
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'phone' => $input['phone'] ?? $user->phone,
            'status' => $input['status'],
            'email_verified_at' => null,
        ])->save();
        // Handle profile image upload
        if (isset($input['photo'])) {
            $path = $input['photo']->store('profile-photos', 'public');

            $user->forceFill([
                'profile' => $path,
            ])->save();
        }

        $user->sendEmailVerificationNotification();
    }
}
