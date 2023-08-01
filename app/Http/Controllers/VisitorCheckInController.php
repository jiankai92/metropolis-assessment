<?php

namespace App\Http\Controllers;

use App\Models\VisitorCheckIns;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class VisitorCheckInController extends Controller
{
    public function show()
    {
        return Inertia::render('VisitorCheckIn', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'successMessage' => session()->get('success') ?? '',
            'errorMessage' => session()->get('error') ?? '',
        ]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:64',
            'type' => 'required|string|max:255|',
            'vehicle_reg_no' => 'required_if:type,' . VisitorCheckIns::TYPE['VEHICLE'].'|min:3|max:16|',
        ]);

        $check_in = VisitorCheckIns::create([
            'name' => $request->name,
            'type' => $request->type,
            'vehicle_reg_no' => $request->vehicle_reg_no ?? null,
            'remakrs' => $request->remarks ?? null,
        ]);

        if ($check_in) {
            return redirect(route('visitor.checkin.show'))->with('success', 'Visitor checked In Successfully');
        }
        return redirect(route('visitor.checkin.show'))->with('error', 'Failed to check in.');
    }
}
