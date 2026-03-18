<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLogService
{
    /**
     * Enregistre une action dans le journal d'activité
     *
     * @param string $action (une des constantes ActivityLog::ACTIONS)
     * @param string $targetType (resource, reservation, user, etc)
     * @param int $targetId
     * @param array $changes (avant/après ou détails)
     * @return ActivityLog
     */
    public static function log(
        string $action,
        string $targetType,
        int $targetId,
        array $changes = []
    ): ActivityLog {
        $actorId = Auth::check() ? Auth::id() : null;

        return ActivityLog::create([
            'actor_id' => $actorId,
            'action' => $action,
            'target_type' => $targetType,
            'target_id' => $targetId,
            'ip_address' => Request::ip(),
            'changes' => $changes,
        ]);
    }

    /**
     * Raccourci pour enregistrer création de ressource
     */
    public static function logResourceCreate(int $resourceId, array $data)
    {
        return self::log(
            'resource_create',
            'resource',
            $resourceId,
            ['created' => $data]
        );
    }

    /**
     * Raccourci pour enregistrer modification de ressource
     */
    public static function logResourceUpdate(int $resourceId, array $oldData, array $newData)
    {
        return self::log(
            'resource_update',
            'resource',
            $resourceId,
            [
                'before' => $oldData,
                'after' => $newData,
            ]
        );
    }

    /**
     * Raccourci pour enregistrer création de réservation
     */
    public static function logReservationCreate(int $reservationId, array $data)
    {
        return self::log(
            'reservation_create',
            'reservation',
            $reservationId,
            ['created' => $data]
        );
    }

    /**
     * Raccourci pour enregistrer approbation
     */
    public static function logReservationApprove(int $reservationId)
    {
        return self::log(
            'reservation_approve',
            'reservation',
            $reservationId,
            ['action' => 'approved']
        );
    }

    /**
     * Raccourci pour enregistrer rejet
     */
    public static function logReservationReject(int $reservationId, string $reason)
    {
        return self::log(
            'reservation_reject',
            'reservation',
            $reservationId,
            ['reason' => $reason]
        );
    }

    /**
     * Raccourci pour enregistrer annulation
     */
    public static function logReservationCancel(int $reservationId)
    {
        return self::log(
            'reservation_cancel',
            'reservation',
            $reservationId,
            ['action' => 'cancelled']
        );
    }

    /**
     * Raccourci pour enregistrer login
     */
    public static function logUserLogin(int $userId)
    {
        return self::log(
            'user_login',
            'user',
            $userId,
            ['session_started' => now()->toIso8601String()]
        );
    }

    /**
     * Raccourci pour enregistrer changement de statut
     */
    public static function logStatusChange(
        string $targetType,
        int $targetId,
        string $oldStatus,
        string $newStatus
    ) {
        return self::log(
            'status_change',
            $targetType,
            $targetId,
            [
                'from' => $oldStatus,
                'to' => $newStatus,
            ]
        );
    }
}
