<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApproveReservationRequest;
use App\Http\Requests\RejectReservationRequest;
use App\Models\Reservation;
use App\Services\ActivityLogService;
use App\Services\ReservationConflictService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationAdminController extends Controller
{
    protected ReservationConflictService $conflictService;

    public function __construct(ReservationConflictService $conflictService)
    {
        $this->conflictService = $conflictService;
    }

    /**
     * Display reservations list with filters
     * GET /admin/reservations
     */
    public function index(Request $request)
    {
        $query = Reservation::with(['user', 'resource']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by resource type
        if ($request->filled('resource_type')) {
            $query->whereHas('resource', function ($q) {
                $q->where('type', request('resource_type'));
            });
        }

        // Filter by date
        if ($request->filled('from_date')) {
            $query->where('start_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->where('end_at', '<=', $request->to_date);
        }

        // Search
        if ($request->filled('search')) {
            $query->where(function ($q) {
                $q->whereHas('user', function ($u) {
                    $u->where('name', 'like', '%' . request('search') . '%');
                })
                ->orWhereHas('resource', function ($r) {
                    $r->where('name', 'like', '%' . request('search') . '%');
                });
            });
        }

        $reservations = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.reservations.index', [
            'reservations' => $reservations,
        ]);
    }

    /**
     * Approve a reservation
     * POST /admin/reservations/{reservation}/approve
     */
    public function approve(ApproveReservationRequest $request, Reservation $reservation)
    {
        // Check if reservation can be approved
        if (!$reservation->canBeApproved()) {
            return back()
                ->withErrors(['approve' => 'This reservation cannot be approved.']);
        }

        // Check for conflicts before approval (approved/active only)
        if ($this->conflictService->hasConflictForApproval($reservation)) {
            return back()
                ->withErrors(['conflict' => 'A reservation conflict was detected. Approval is impossible.']);
        }

        // Approve reservation
        $oldStatus = $reservation->status;
        $reservation->update(['status' => 'approved']);

        // Log activity
        ActivityLogService::logReservationApprove($reservation->id);

        return back()
            ->with('success', 'Reservation approved successfully.');
    }

    /**
     * Reject a reservation
     * POST /admin/reservations/{reservation}/reject
     */
    public function reject(RejectReservationRequest $request, Reservation $reservation)
    {
        // Check if reservation can be rejected
        if (!$reservation->canBeRejected()) {
            return back()
                ->withErrors(['reject' => 'This reservation cannot be rejected.']);
        }

        $reason = $request->validated()['reason'];

        // Reject reservation
        $oldStatus = $reservation->status;
        $reservation->update([
            'status' => 'rejected',
            'admin_note' => $reason,
        ]);

        // Log activity
        ActivityLogService::logReservationReject($reservation->id, $reason);

        return back()
            ->with('success', 'Reservation rejected successfully.');
    }
}
