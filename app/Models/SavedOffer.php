<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavedOffer extends Model
{
    protected $table = 'saved_offers'; // Nom de la table

    protected $fillable = [
        'user_id',
        'offer_id',
    ];

    /**
     * Une offre sauvegardée appartient à un utilisateur.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Une offre sauvegardée correspond à une offre.
     */
    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }
}
