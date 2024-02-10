<?php

namespace App\Http\Controllers\Admin;


use App\Models\User;

class DashboardController extends AdminController
{
    public function __invoke()
    {

        $data['User'] = User::count();
        $data['interestedAutos'] = User::whereHas('interestedAutos')->count();
        $data['interestedRealEstate'] = User::whereHas('interestedRealEstate')->count();
        //$data['interestedRealEstate'] = User::whereHas('interestedRealEstate');
        //$data['interestedRealEstate'] = User::whereHas('interestedRealEstate');
        return view('admin.dashboard', $data);
    }
}
