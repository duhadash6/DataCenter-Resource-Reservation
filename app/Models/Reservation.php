<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'resource_id',
        'start_at',
        'end_at',
        'status',
        'justification',
        'admin_note',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    const STATUSES = ['pending', 'approved', 'rejected', 'active', 'finished', 'cancelled'];

    /**
     * Relation: une réservation appartient à un utilisateur
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation: une réservation appartient à une ressource
     */
    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }

    /**
     * Scope: réservations de l'utilisateur courant
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope: réservations pending ou approved
     */
    public function scopePending($query)
    {
        return $query->whereIn('status', ['pending', 'approved']);
    }

    /**
     * Vérifie si la réservation peut être annulée
     */
    public function canBeCancelled(): bool
    {
        // Peut annuler si pending ou approved ET n'a pas commencé
        if (!in_array($this->status, ['pending', 'approved'])) {
            return false;
        }

        return $this->start_at > now();
    }

    /**
     * Vérifie si la réservation peut être approuvée
     */
    public function canBeApproved(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Vérifie si la réservation peut être rejetée
     */
    public function canBeRejected(): bool
    {
        return $this->status === 'pending';
    }
}
