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
        'user_id',          // Au lieu de published_by
        'is_validated',
        'is_published',     // Pour distinguer les brouillons des offres publiées
        'type',
        'sector',
        'region',
        'budget',
        'duration',         // Durée du projet
        'required_skills',  // Compétences requises
        'company',          // Nom de l'entreprise
        'email',            // Email de contact
        'phone',            // Téléphone de contact
        'created_at',       // Date de création manuelle
    ];

    protected $casts = [
        'deadline' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'is_validated' => 'boolean',
        'is_published' => 'boolean',
        'budget' => 'float',
    ];

    /**
     * Relation avec l'utilisateur ayant publié l'offre.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
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
