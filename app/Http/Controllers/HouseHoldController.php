<?php

namespace App\Http\Controllers;

use App\Models\HouseHold;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HouseHoldController extends Controller
{
    //

    public function bulkPrint(Request $request)
    {
        $ids = (array) $request->input('ids'); // ✅ force array

        if (empty($ids)) {
            return redirect()->route('households.index')
                ->with('error', 'No households selected.');
        }

        $households = Household::whereIn('id', $ids)
            ->with('residents')
            ->get();

        return view('households.print', compact('households'));
    }

    public function index()
    {
        $households = HouseHold::paginate(15);

        return view('households.index', compact('households'));
    }

    /**
     * Show the form for creating a new household.
     */
    public function create()
    {
        return view('households.create');
    }

    /**
     * Store a newly created household in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'household_no' => 'required|string|unique:house_holds,household_no|max:255',
            'household_head' => 'nullable|string|max:255',
            'purok' => 'required|string|max:255',
            'address' => 'required|string',
            'house_ownership' => 'required|in:Owned,Rented,Shared,Informal Settler',
            'house_type' => 'required|in:Concrete,Semi-Concrete,Light Materials',
            'electricity' => 'required|boolean',
            'monthly_income' => 'nullable|numeric|min:0',
            'livelihood' => 'nullable|string|max:255',
            'beneficiaries' => 'nullable|array',
            'disaster_risk' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();
        $data['beneficiaries'] = json_encode($request->input('beneficiaries', []));
        $data['disaster_risk'] = json_encode($request->input('disaster_risk', []));

        HouseHold::create($data);

        return redirect()->route('households.index')
            ->with('success', 'Household created successfully.');
    }

    /**
     * Update the specified household in storage.
     */
    public function update(Request $request, HouseHold $household)
    {
        $validator = Validator::make($request->all(), [
            'household_no' => 'required|string|max:255|unique:house_holds,household_no,'.$household->id,
            'household_head' => 'nullable|string|max:255',
            'purok' => 'required|string|max:255',
            'address' => 'required|string',
            'house_ownership' => 'required|in:Owned,Rented,Shared,Informal Settler',
            'house_type' => 'required|in:Concrete,Semi-Concrete,Light Materials',
            'electricity' => 'required|boolean',
            'monthly_income' => 'nullable|numeric|min:0',
            'livelihood' => 'nullable|string|max:255',
            'beneficiaries' => 'nullable|array',
            'disaster_risk' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();
        $data['beneficiaries'] = json_encode($request->input('beneficiaries', []));
        $data['disaster_risk'] = json_encode($request->input('disaster_risk', []));

        $household->update($data);

        return redirect()->route('households.index')
            ->with('success', 'Household updated successfully.');
    }

    /**
     * Remove the specified household from storage.
     */
    public function destroy(HouseHold $household)
    {
        $household->delete();

        return redirect()->route('households.index')
            ->with('success', 'Household deleted successfully.');
    }

    /**
     * Get household data for editing (AJAX)
     */
    public function getEditData(HouseHold $household)
    {
        return response()->json([
            'id' => $household->id,
            'household_no' => $household->household_no,
            'household_head' => $household->household_head,
            'purok' => $household->purok,
            'address' => $household->address,
            'house_ownership' => $household->house_ownership,
            'house_type' => $household->house_type,
            'electricity' => $household->electricity,
            'monthly_income' => $household->monthly_income,
            'livelihood' => $household->livelihood,
            'beneficiaries' => json_decode($household->beneficiaries ?? '[]'),
            'disaster_risk' => json_decode($household->disaster_risk ?? '[]'),
        ]);
    }

    /**
     * Get household data for viewing (AJAX)
     */
    public function getViewData(HouseHold $household)
    {
        return response()->json([
            'household_no' => $household->household_no,
            'household_head' => $household->household_head,
            'purok' => $household->purok,
            'address' => $household->address,
            'house_ownership' => $household->house_ownership,
            'house_type' => $household->house_type,
            'electricity' => $household->electricity,
            'monthly_income' => $household->monthly_income,
            'livelihood' => $household->livelihood,
            'beneficiaries' => json_decode($household->beneficiaries ?? '[]'),
            'disaster_risk' => json_decode($household->disaster_risk ?? '[]'),
        ]);
    }
}
