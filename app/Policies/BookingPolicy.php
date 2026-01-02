<?php

namespace App\Policies;

use App\Models\Apartment;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Carbon;

class BookingPolicy
{
    public function viewAny(User $user): bool
    {
        return false;
    }

    public function view(User $user, Booking $booking): bool
    {
        return false;
    }

    public function create(User $user, Apartment $apartment)
    {
        return $apartment->owner_id !== $user->id ? Response::allow() : Response::deny('Owners can\'t book their own apartments.');
    }

    public function update(User $user, Booking $booking)
    {
        if ($booking->tenant_id !== $user->id)
            return Response::deny('You can\'t modify bookings made by others.');

        if ($booking->status === 'canceled' || $booking->status === 'rejected')
            return false;

        return Response::allow();
    }

    public function delete(User $user, Booking $booking): bool
    {
        return false;
    }

    public function restore(User $user, Booking $booking): bool
    {
        return false;
    }

    public function forceDelete(User $user, Booking $booking): bool
    {
        return false;
    }
}
