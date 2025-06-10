<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'user_id',
        'offer_id',
        'cover_letter',
        'cv_path',
        'phone',
        'status',
    ];

    /**
     * Get the user that owns the application
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the offer that owns the application
     */
    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }
}
