<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Mountain;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Mountain::where('is_active', true)
            ->where('departure_date', '>', now());

        // Fitur Pencarian
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('location', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('difficulty')) {
            $query->where('difficulty', $request->difficulty);
        }

        $mountains = $query->latest('departure_date')->paginate(9);

        return view('user.home', compact('mountains'));
    }

    public function privateTrip()
    {
        return view('user.private-trip', [
            'admin_wa' => env('ADMIN_WHATSAPP', '6281234567890'),
        ]);
    }

    public function about()
    {
        return view('user.about');
    }
}