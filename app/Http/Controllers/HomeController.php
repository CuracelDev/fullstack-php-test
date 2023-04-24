<?php

namespace App\Http\Controllers;

use App\Models\Hmo;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $hmos = cache()->remember('hmos', now()->addMinutes(30), function () { //cache can always be invalidated when a new hmo is added
            return Hmo::get()->toArray();
        });

        return view('submit-order', ['hmos' => $hmos]);
    }
}
