<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Resource extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'status',
        'location',
        'specs',
    ];

    protected $casts = [
        'specs' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    const TYPES = ['server', 'vm', 'storage', 'network'];
    const STATUSES = ['available', 'reserved', 'maintenance', 'down'];

    /**
     * Relation: une ressource a plusieurs réservations
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * Récupère les réservations futures (pending, approved, active)
     */
    public function upcomingReservations()
    {
        return $this->reservations()
            ->whereIn('status', ['pending', 'approved', 'active'])
            ->where('end_at', '>', now())
            ->orderBy('start_at')
            ->get();
    }

    /**
     * Scope: filtrer par type
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope: filtrer par statut
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope: recherche par nom ou location
     */
    public function scopeSearch($query, $term)
    {
        return $query->where('name', 'like', "%{$term}%")
                     ->orWhere('location', 'like', "%{$term}%");
    }
}
