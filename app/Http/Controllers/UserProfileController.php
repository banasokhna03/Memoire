<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
class UserProfileController extends Controller
{
    public function show()
    {
        return view('offers.profile'); // Assurez-vous que le fichier de vue s'appelle 'profile.blade.php'
    }
}