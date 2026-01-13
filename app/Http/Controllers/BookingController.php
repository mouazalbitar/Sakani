<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingRequest;
use App\Models\Apartment;
use App\Models\Booking;
use App\Notifications\NewBookingNotification;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function Illuminate\Support\now;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::all();
        return response()->json([
            'message' => 'Completed Successfully.',
            'data' => $bookings
        ], 200);
    }

    public function addBooking(BookingRequest $request)
    {
        $userId = Auth::user()->id;
        $apartment = Apartment::findOrFail($request['apartment_id']);
        $this->authorize('create', [Booking::class, $apartment]);
        $valid = $request->validated();
        try {
            return DB::transaction(function () use ($userId, $valid) {
                $isBooked = Booking::where('apartment_id', $valid['apartment_id'])
                    ->whereNotIn('status', ['canceled', 'rejected'])
                    ->where(function ($query) use ($valid) {
                        $query->where('start_date', '<=', $valid['end_date'])
                            ->where('end_date', '>=', $valid['start_date']);
                    })
                    ->lockForUpdate()
                    ->exists();
                if ($isBooked) {
                    throw new Exception('The Apartment is already Booked for the selected dates.');
                }
                $booking = Booking::create(['tenant_id' => $userId] + $valid);
                $owner = $booking->apartment->user_relation;
                $owner->notify(new NewBookingNotification($booking));
                return response()->json([
                    'message' => 'Booking Added Successfully.',
                    'data' => $booking
                ], 201);
            });
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error occurred while adding booking.',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function showBookings() // for tenant
    {
        $userId = Auth::user()->id;
        $bookings = Booking::where('tenant_id', $userId)->get();
        $bookings->makeHidden(['tenant_id', 'tenant', 'owner']);
        return response()->json([
            'message' => 'Complete Successfully.',
            'data' => $bookings
        ], 200);
    }

    public function showApartmentsBookings() // for owner
    {
        $userId = Auth::user()->id;
        $apartmentIds = Apartment::where('owner_id', $userId)->pluck('id')->toArray();
        $bookings = Booking::whereIn('apartment_id', $apartmentIds)->get(); //->with(['tenant:id,name,phone', 'apartment:id,title'])
        $bookings->makeHidden(['owner_id', 'owner']);
        return response()->json([
            'message' => 'Complete Successfully.',
            'data' => $bookings
        ], 200);
    }

    public function acceptBooking(Booking $booking)
    {
        if ($booking->apartment->owner_id !== Auth::user()->id && !Auth::user()->isAdmin) {
            return response()->json([
                'message' => 'You are Not Authorized to Accept this Booking.'
            ], 403);
        }

        if ($booking->status === 'approved') {
            return response()->json(['message' => 'This booking is already accepted.'], 422);
        }
        if ($booking->status === 'canceled') {
            return response()->json(['message' => 'This booking has been canceled before.'], 422);
        }
        if ($booking->status === 'rejected') {
            return response()->json(['message' => 'This booking has been rejected before.'], 422);
        }

        $booking->update(['status' => 'approved']);

        return response()->json([
            'message' => 'Booking Accepted Successfully.',
        ], 200);
    }

    public function rejectBooking(Booking $booking)
    {
        if ($booking->apartment->owner_id !== Auth::user()->id) {
            return response()->json([
                'message' => 'You are Not Authorized to reject this Booking.'
            ], 403);
        }

        if ($booking->status === 'canceled') {
            return response()->json(['message' => 'This booking is already canceled by Tenant.'], 422);
        }
        if ($booking->status === 'rejected') {
            return response()->json(['message' => 'This booking has been rejected before.'], 422);
        }
        if ($booking->status === 'approved') {
            return response()->json(['message' => 'This booking is already accepted before.'], 422);
        }

        $booking->update(['status' => 'rejected']);

        return response()->json([
            'message' => 'Booking Rejected Successfully.',
        ], 200);
    }

    public function cancelBooking(Booking $booking)
    {
        if ($booking->tenant_id !== Auth::user()->id) {
            return response()->json([
                'message' => 'You are Not Authorized to cancel this Booking.'
            ], 403);
        }

        if ($booking->status === 'canceled') {
            return response()->json(['message' => 'This booking is already canceled.'], 422);
        }
        if ($booking->status === 'rejected') {
            return response()->json(['message' => 'This booking has been rejected by owner.'], 422);
        }

        $booking->update(['status' => 'canceled']);

        return response()->json([
            'message' => 'Booking Canceled Successfully.',
        ], 200);
    }

    public function updateBooking(Booking $booking, BookingRequest $request)
    {
        $this->authorize('update', $booking);

        $validated = $request->validated();

        return DB::transaction(function () use ($booking, $validated) {
            $hasConflict = Booking::where('apartment_id', $booking->apartment_id)
                ->where('id', '!=', $booking->id)
                ->whereNotIn('status', ['canceled', 'rejected'])
                ->where(function ($query) use ($validated) {
                    $query->where('start_date', '<=', $validated['start_date'])
                        ->where('end_date', '>=', $validated['end_date']);
                })
                ->exists();
            if ($hasConflict) {
                return response()->json([
                    'message' => 'The apartment is already booked for the selected dates.',
                ], 422);
            }
            $booking->update($validated + ['status' => 'pending_update']);
            return response()->json([
                'message' => 'Booking Updated Successfully.',

            ], 200);
        });
    }

    public function apartmentBookings(Apartment $apartment)
    {
        $bookings = Booking::where('apartment_id', $apartment->id)->whereNotIn('status', ['canceled', 'rejected'])->get();
        return response()->json([
            'message' => 'Complete successfully.',
            'data' => $bookings
        ], 200);

    }

    public function DoneUserBookings()
    {
        $userId = Auth::user()->id;
        $bookings = Booking::where('tenant_id', $userId)
            ->where('status', 'approved')
            ->where('end_date', '<=', now())
            ->get();
        return response()->json([
            'message' => 'Complete Successfully',
            'data' => $bookings
        ], 200);
    }

    public function destroy(Booking $booking)
    {
    }
}
