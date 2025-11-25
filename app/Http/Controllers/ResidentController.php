<?php

namespace App\Http\Controllers;

use App\Models\HouseHold;
use App\Models\Resident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ResidentController extends Controller
{
    public function index()
    {
        $residents = Resident::with('houseHold')->paginate(15);
        $households = HouseHold::all();

        return view('residents.index', compact('residents', 'households'));
    }

    /**
     * Show the form for creating a new resident.
     */
    public function create()
    {
        $households = HouseHold::all();

        return view('residents.create', compact('households'));
    }

    /**
     * Store a newly created resident in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'household_no' => 'nullable|string|max:255',
            'house_hold_id' => 'nullable|exists:house_holds,id',
            'firstname' => 'required|string|max:255',
            'middlename' => 'nullable|string|max:255',
            'lastname' => 'required|string|max:255',
            'alias' => 'nullable|string|max:255',
            'birthday' => 'required|date',
            'age' => 'required|integer|min:0',
            'gender' => 'required|in:Male,Female',
            'civil_status' => 'required|in:Single,Married,Divorced,Widowed',
            'voter_status' => 'required|in:Registered,Not Registered',
            'birth_of_place' => 'nullable|string|max:255',
            'citizenship' => 'nullable|string|max:255',
            'mobile_no' => 'nullable|string|max:255',
            'height' => 'nullable|string|max:255',
            'weight' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'father' => 'nullable|string|max:255',
            'mother' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Resident::create($request->all());

        return redirect()->route('residents.index')
            ->with('success', 'Resident created successfully.');
    }

    /**
     * Update the specified resident in storage.
     */
    public function update(Request $request, Resident $resident)
    {
        $validator = Validator::make($request->all(), [
            'household_no' => 'nullable|string|max:255',
            'house_hold_id' => 'nullable|exists:house_holds,id',
            'firstname' => 'required|string|max:255',
            'middlename' => 'nullable|string|max:255',
            'lastname' => 'required|string|max:255',
            'alias' => 'nullable|string|max:255',
            'birthday' => 'required|date',
            'age' => 'required|integer|min:0',
            'gender' => 'required|in:Male,Female',
            'civil_status' => 'required|in:Single,Married,Divorced,Widowed',
            'voter_status' => 'required|in:Registered,Not Registered',
            'birth_of_place' => 'nullable|string|max:255',
            'citizenship' => 'nullable|string|max:255',
            'mobile_no' => 'nullable|string|max:255',
            'height' => 'nullable|string|max:255',
            'weight' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'father' => 'nullable|string|max:255',
            'mother' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $resident->update($request->all());

        return redirect()->route('residents.index')
            ->with('success', 'Resident updated successfully.');
    }

    /**
     * Remove the specified resident from storage.
     */
    public function destroy(Resident $resident)
    {
        $resident->delete();

        return redirect()->route('residents.index')
            ->with('success', 'Resident deleted successfully.');
    }

    public function bulkPrint(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return redirect()->route('residents.index')
                ->with('error', 'No residents selected.');
        }

        $residents = Resident::whereIn('id', $ids)
            ->with('houseHold')
            ->get();

        return view('residents.print', compact('residents'));
    }

    public function getEditData(Resident $resident)
    {
        return response()->json([
            'id' => $resident->id,
            'household_no' => $resident->household_no,
            'house_hold_id' => $resident->house_hold_id,
            'firstname' => $resident->firstname,
            'middlename' => $resident->middlename,
            'lastname' => $resident->lastname,
            'alias' => $resident->alias,
            'birthday' => $resident->birthday,
            'age' => $resident->age,
            'gender' => $resident->gender,
            'civil_status' => $resident->civil_status,
            'voter_status' => $resident->voter_status,
            'birth_of_place' => $resident->birth_of_place,
            'citizenship' => $resident->citizenship,
            'mobile_no' => $resident->mobile_no,
            'height' => $resident->height,
            'weight' => $resident->weight,
            'email' => $resident->email,
            'father' => $resident->father,
            'mother' => $resident->mother,
        ]);
    }

    // Get resident data for viewing (AJAX)
    public function getViewData(Resident $resident)
    {
        return response()->json([
            'household_no' => $resident->household_no,
            'house_hold_id' => $resident->house_hold_id,
            'firstname' => $resident->firstname,
            'middlename' => $resident->middlename,
            'lastname' => $resident->lastname,
            'alias' => $resident->alias,
            'birthday' => $resident->birthday,
            'age' => $resident->age,
            'gender' => $resident->gender,
            'civil_status' => $resident->civil_status,
            'voter_status' => $resident->voter_status,
            'birth_of_place' => $resident->birth_of_place,
            'citizenship' => $resident->citizenship,
            'mobile_no' => $resident->mobile_no,
            'height' => $resident->height,
            'weight' => $resident->weight,
            'email' => $resident->email,
            'father' => $resident->father,
            'mother' => $resident->mother,
        ]);
    }
}
