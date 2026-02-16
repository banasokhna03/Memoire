<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    // Permet à Laravel d'écrire dans ces colonnes
    protected $fillable = ['role', 'content'];
}