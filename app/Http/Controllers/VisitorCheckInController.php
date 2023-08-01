<?php

namespace App\Http\Controllers;

use App\Models\VisitorCheckIns;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            'contact_no' => 'required|digits_between:5,32',
            'type' => 'required|string|max:16',
            'vehicle_reg_no' => 'required_if:type,' . VisitorCheckIns::TYPE['VEHICLE'],
        ]);

        $check_in = VisitorCheckIns::create([
            'name' => $request->name,
            'contact_no' => $request->contact_no,
            'type' => $request->type,
            'vehicle_reg_no' => $request->vehicle_reg_no ?? null,
            'remarks' => $request->remarks ?? null,
        ]);

        if ($check_in) {
            return redirect(route('visitor.checkin.show'))->with('success', 'Visitor checked In Successfully');
        }
        return redirect(route('visitor.checkin.show'))->with('error', 'Failed to check in.');
    }

    public function list()
    {
        $check_ins = VisitorCheckIns::all();
        return Inertia::render('VisitorList', [
            'checkIns' => $check_ins
        ]);
    }

    public function search(Request $request)
    {
        $input = $request->all();
        $query = VisitorCheckIns::query();
        if (isset($input['name'])) {
            $query->where('name', 'LIKE', '%' . $input['name'] . '%');
        }
        if (isset($input['contact_no'])) {
            $query->where('contact_no', 'LIKE', '%' . $input['contact_no'] . '%');
        }
        if (isset($input['type'])) {
            $query->where('type', $input['type']);
        }
        if (isset($input['vehicle_reg_no'])) {
            $query->where('vehicle_reg_no', 'LIKE', '%' . $input['vehicle_reg_no'] . '%');
        }
        if (isset($input['status'])) {
            if ($input['status'] == '1') {
                $query->whereNotNull('checkout_at');
            } else {
                $query->whereNull('checkout_at');
            }
        }
        return $query->get();
    }

    public function adminCheckout(Request $request)
    {
        $input = $request->all();
        $check_in = VisitorCheckIns::find($input['id']);
        DB::beginTransaction();
        $check_in->checkout_at = Carbon::now();
        $check_in->save();
        DB::commit();
        return $check_in;
    }
}
