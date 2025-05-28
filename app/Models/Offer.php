<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'deadline',
        'published_by',
        'is_validated',
        'type',
        'sector',
        'region',
        'budget',
    ];

    protected $casts = [
        'deadline' => 'datetime',
    ];

    /**
     * Relation avec l'utilisateur ayant publié l'offre.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'published_by');
    }

    /**
     * Scope pour récupérer uniquement les offres archivées (date limite dépassée).
     */
    public function scopeArchived($query)
    {
        return $query->where('deadline', '<', now());
    }

    /**
     * Vérifie si l'offre est expirée.
     */
    public function isExpired()
    {
        return $this->deadline->isPast();
    }

    /**
     * Attribut formaté pour l'affichage de la date limite.
     */
    public function getFormattedDeadlineAttribute()
    {
        return $this->deadline->format('d/m/Y');
    }
}
