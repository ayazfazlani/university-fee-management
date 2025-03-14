<?php

namespace App\Observers;

use Illuminate\Foundation\Auth\User;



class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {


        if ($user->role === 'HOD') {
            $user->assignRole('HOD');
        } elseif ($user->role === 'CR') {
            $user->assignRole('CR');
        } else {
            $user->assignRole('Student');
        }
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
