<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActivityLog extends Model
{
    use HasFactory;

    protected $table = 'activity_logs';

    protected $fillable = [
        'actor_id',
        'action',
        'target_type',
        'target_id',
        'ip_address',
        'changes',
    ];

    protected $casts = [
        'changes' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public $timestamps = true;

    const ACTIONS = [
        'resource_create',
        'resource_update',
        'resource_delete',
        'reservation_create',
        'reservation_approve',
        'reservation_reject',
        'reservation_cancel',
        'user_login',
        'status_change',
    ];

    /**
     * Relation: l'activité appartient à un acteur (utilisateur)
     */
    public function actor()
    {
        return $this->belongsTo(User::class, 'actor_id');
    }

    /**
     * Scope: filtrer par type d'action
     */
    public function scopeByAction($query, $action)
    {
        return $query->where('action', $action);
    }

    /**
     * Scope: filtrer par acteur
     */
    public function scopeByActor($query, $actorId)
    {
        return $query->where('actor_id', $actorId);
    }

    /**
     * Scope: filtrer par type de cible
     */
    public function scopeByTargetType($query, $targetType)
    {
        return $query->where('target_type', $targetType);
    }

    /**
     * Scope: filtrer par date
     */
    public function scopeAfterDate($query, $date)
    {
        return $query->where('created_at', '>=', $date);
    }
}
