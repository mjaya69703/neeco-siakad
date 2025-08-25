<?php

namespace App\Http\Controllers;

// Use Systems
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// Use Models
use App\Models\Pengaturan\Kampus;
use App\Models\Pengaturan\System;


class RootController extends Controller
{
    public function renderHomePage()
    {
        $user = Auth::user();
        $data['spref'] = $user ? $user->prefix : '';
        $data['menus'] = null;
        $data['pages'] = "HomePage";
        $data['system'] = System::first();
        $data['academy'] = Kampus::first();

        return view('default-content', $data, compact('user'));
    }
}
