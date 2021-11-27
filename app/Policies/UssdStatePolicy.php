<?php

namespace App\Policies;

use App\Models\UssdState;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UssdStatePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param \App\User $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\User $user
     * @param \App\Models\UssdState $ussdState
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, UssdState $ussdState)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\User $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\User $user
     * @param \App\Models\UssdState $ussdState
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, UssdState $ussdState)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\User $user
     * @param \App\Models\UssdState $ussdState
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, UssdState $ussdState)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\User $user
     * @param \App\Models\UssdState $ussdState
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, UssdState $ussdState)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\User $user
     * @param \App\Models\UssdState $ussdState
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, UssdState $ussdState)
    {
        //
    }
}
