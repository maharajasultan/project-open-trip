<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Mountain;

class MountainController extends Controller
{
    public function show(Mountain $mountain)
    {
        abort_if(!$mountain->is_active, 404);

        return view('user.mountains.show', compact('mountain'));
    }
}