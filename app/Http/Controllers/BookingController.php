<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingRequest;
use App\Models\Apartment;
use App\Models\Booking;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    public function showBookings()
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

    public function acceptBooking(int $id)
    {
        $booking = Booking::with('apartment')->findOrFail($id);

        if ($booking->apartment->owner_id !== Auth::user()->id && !Auth::user()->isAdmin) {
            return response()->json([
                'message' => 'You are Not Authorized to Accept this Booking.'
            ], 403);
        }

        if ($booking->status === 'approved') {
            return response()->json(['message' => 'This booking is already accepted.'], 422);
        }
        if ($booking->status === 'canceled') {
            return response()->json(['message' => 'This booking has been accepted before.'], 422);
        }

        $booking->update(['status' => 'approved']);

        return response()->json([
            'message' => 'Booking Accepted Successfully.',
        ], 200);
    }

    public function rejectBooking(int $id)
    {
        $booking = Booking::with('apartment')->findOrFail($id);

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

    public function canceledBooking(Booking $booking)
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

    public function updateBooking(BookingRequest $request, Booking $booking)
    {
        $this->authorize('update', $booking);

        $validated = $request->validated();

        return DB::transaction(function () use ($booking, $validated) {

            $isShortening =
                $validated['start_date'] === $booking->start_date &&
                $validated['end_date'] < $booking->end_date;

            if ($isShortening) { // حالياً فقط تقصير المدة
                $booking->update($validated);

                return response()->json([
                    'message' => 'Booking Updated Successfully.',
                    'data' => $booking
                ], 200);
            }

            return response()->json([
                'message' => 'You can only shorten the booking period.',
            ], 422);
        });
    }

    public function destroy(Booking $booking)
    {
        //
    }
}
