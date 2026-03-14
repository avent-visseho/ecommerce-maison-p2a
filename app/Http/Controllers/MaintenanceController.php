<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    /**
     * Display the maintenance page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('maintenance');
    }
}
