<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class RedirectController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;

        return match ($role) {
            'présentateur' => redirect('/presentateur'),
            'secretaire' => redirect('/secretaire'),
            'étudiant' => redirect('/etudiant'),
            default => abort(403, 'Accès refusé.'),
        };
    }
}

