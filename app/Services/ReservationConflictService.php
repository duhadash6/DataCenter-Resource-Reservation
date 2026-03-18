<?php

namespace App\Services;

use App\Models\Reservation;
use App\Models\Resource;
use Carbon\Carbon;

class ReservationConflictService
{
    /**
     * Vérifie s'il y a un conflit de réservation
     * Conflit si : (start_at < existing_end) AND (end_at > existing_start)
     * Ne considère que : pending, approved, active
     *
     * @param Resource $resource
     * @param Carbon $startAt
     * @param Carbon $endAt
     * @param int|null $excludeReservationId (pour permettre l'édition)
     * @return bool
     */
    public function hasConflict(
        Resource $resource,
        Carbon $startAt,
        Carbon $endAt,
        ?int $excludeReservationId = null
    ): bool {
        $query = Reservation::where('resource_id', $resource->id)
            ->whereIn('status', ['pending', 'approved', 'active']);

        if ($excludeReservationId) {
            $query->where('id', '!=', $excludeReservationId);
        }

        $conflict = $query->where(function ($q) use ($startAt, $endAt) {
            $q->where('start_at', '<', $endAt)
              ->where('end_at', '>', $startAt);
        })->first();

        return $conflict !== null;
    }

    /**
     * Récupère la liste des réservations en conflit
     *
     * @param Resource $resource
     * @param Carbon $startAt
     * @param Carbon $endAt
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getConflictingReservations(
        Resource $resource,
        Carbon $startAt,
        Carbon $endAt
    ) {
        return Reservation::where('resource_id', $resource->id)
            ->whereIn('status', ['pending', 'approved', 'active'])
            ->where('start_at', '<', $endAt)
            ->where('end_at', '>', $startAt)
            ->with('user')
            ->orderBy('start_at')
            ->get();
    }

    /**
     * Vérifie le conflit avant approbation (approved/active uniquement)
     *
     * @param Reservation $reservation
     * @return bool
     */
    public function hasConflictForApproval(Reservation $reservation): bool
    {
        $query = Reservation::where('resource_id', $reservation->resource_id)
            ->where('id', '!=', $reservation->id)
            ->whereIn('status', ['approved', 'active']);

        $conflict = $query->where(function ($q) use ($reservation) {
            $q->where('start_at', '<', $reservation->end_at)
              ->where('end_at', '>', $reservation->start_at);
        })->first();

        return $conflict !== null;
    }

    /**
     * Récupère les conflits pour l'approbation
     *
     * @param Reservation $reservation
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getConflictsForApproval(Reservation $reservation)
    {
        return Reservation::where('resource_id', $reservation->resource_id)
            ->where('id', '!=', $reservation->id)
            ->whereIn('status', ['approved', 'active'])
            ->where('start_at', '<', $reservation->end_at)
            ->where('end_at', '>', $reservation->start_at)
            ->with('user')
            ->orderBy('start_at')
            ->get();
    }
}
