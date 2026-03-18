<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReservationRequest;
use App\Models\Reservation;
use App\Models\Resource;
use App\Services\ActivityLogService;
use App\Services\ReservationConflictService;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    protected ReservationConflictService $conflictService;

    public function __construct(ReservationConflictService $conflictService)
    {
        $this->conflictService = $conflictService;
    }

    /**
     * Display reservation creation form
     * GET /resources/{resource}/reserve
     */
    public function create(Resource $resource)
    {
        return view('reservations.create', [
            'resource' => $resource,
        ]);
    }

    /**
     * Create a new reservation
     * POST /resources/{resource}/reserve
     */
    public function store(StoreReservationRequest $request, Resource $resource)
    {
        $startAt = \Carbon\Carbon::parse($request->validated()['start_at']);
        $endAt = \Carbon\Carbon::parse($request->validated()['end_at']);

        // Check for conflicts
        if ($this->conflictService->hasConflict($resource, $startAt, $endAt)) {
            return back()
                ->withInput()
                ->withErrors(['conflict' => 'This resource is not available for the selected period.']);
        }

        // Create reservation
        $reservation = Reservation::create([
            'user_id' => Auth::id(),
            'resource_id' => $resource->id,
            'start_at' => $startAt,
            'end_at' => $endAt,
            'status' => 'pending',
            'justification' => $request->validated()['justification'] ?? null,
        ]);

        // Log activity
        ActivityLogService::logReservationCreate($reservation->id, [
            'resource_id' => $resource->id,
            'start_at' => $startAt,
            'end_at' => $endAt,
        ]);

        return redirect()
            ->route('reservations.show', $reservation->id)
            ->with('success', 'Reservation created successfully. Awaiting administrator approval.');
    }

    /**
     * Display user's reservations list
     * GET /my-reservations
     */
    public function index()
    {
        $reservations = Reservation::byUser(Auth::id())
            ->with('resource')
            ->paginate(15);

        return view('reservations.index', [
            'reservations' => $reservations,
        ]);
    }

    /**
     * Display reservation details
     * GET /reservations/{reservation}
     */
    public function show(Reservation $reservation)
    {
        // Check that user owns the reservation or is admin
        if ($reservation->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        return view('reservations.show', [
            'reservation' => $reservation,
        ]);
    }

    /**
     * Cancel a reservation
     * POST /my-reservations/{reservation}/cancel
     */
    public function cancel(Reservation $reservation)
    {
        // Check that user owns the reservation
        if ($reservation->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Check if cancellation is allowed
        if (!$reservation->canBeCancelled()) {
            return back()
                ->withErrors(['cancel' => 'This reservation cannot be cancelled.']);
        }

        // Cancel reservation
        $oldStatus = $reservation->status;
        $reservation->update(['status' => 'cancelled']);

        // Log activity
        ActivityLogService::logReservationCancel($reservation->id);

        return redirect()
            ->route('reservations.index')
            ->with('success', 'Reservation cancelled successfully.');
    }
}
