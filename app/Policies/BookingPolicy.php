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
        return $apartment->owner_id !== $user->id ? Response::allow() : Response::deny('Owners cannot book their own apartments.');
    }

    public function update(User $user, Booking $booking)
    {
        if ($booking->tenant_id !== $user->id) {
            return Response::deny('You can\'t modify bookings made by other users.');
        }

        // if (Carbon::parse($booking->start_date)->isPast()) {
        //     return Response::deny('This booking has already started and can\'t be modified.');
        // }

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
