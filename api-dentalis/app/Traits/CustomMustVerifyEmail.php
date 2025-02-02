<?php
namespace App\Traits;

trait CustomMustVerifyEmail
{
    /**
     * Mark the given user's email as verified.
     *
     * @return bool
     */
    public function markEmailAsVerified()
    {
        return $this->forceFill([
            'is_verified' => 1,
        ])->save();
    }

    /**
     * Determine if the user has verified their email address.
     *
     * @return bool
     */
    public function hasVerifiedEmail()
    {
        return $this->is_verified == 1;
    }
}