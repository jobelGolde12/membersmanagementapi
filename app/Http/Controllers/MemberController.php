<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{
    /* ============================================================
       FORMAT IF EITHER JSON OR XML
    ============================================================ */
    private function isJsonOrXml($data, $status = 200)
    {
        $acceptHeader = strtolower(request()->header('Accept', ''));
        $formatParam = strtolower(request()->get('format', ''));

        // ALWAYS honor ?format=xml first
        if ($formatParam === 'xml') {
            return $this->convertToXml($data, $status);
        }

        if ($formatParam === 'json') {
            return response()->json($data, $status);
        }

        // Next, check Accept headers
        if (str_contains($acceptHeader, 'application/xml') ||
            str_contains($acceptHeader, 'text/xml') ||
            str_contains($acceptHeader, 'xml')) {
            return $this->convertToXml($data, $status);
        }

        if (str_contains($acceptHeader, 'application/json') ||
            str_contains($acceptHeader, 'json')) {
            return response()->json($data, $status);
        }

        // Default to JSON
        return response()->json($data, $status);
    }

    private function convertToXml($data, $status = 200)
    {
        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><response/>');

        $this->arrayToXml($data, $xml);

        return response($xml->asXML(), $status)
            ->header('Content-Type', 'application/xml');
    }

    private function arrayToXml($data, &$xml)
    {
        foreach ($data as $key => $value) {
            // Numeric keys → use a generic tag name
            if (is_numeric($key)) {
                $key = "item_" . $key;
            }

            if (is_array($value)) {
                $subnode = $xml->addChild($key);
                $this->arrayToXml($value, $subnode);
            } elseif (is_object($value)) {
                $subnode = $xml->addChild($key);
                $this->arrayToXml((array)$value, $subnode);
            } else {
                $xml->addChild($key, htmlspecialchars($value));
            }
        }
    }

    private function sanitizeXmlKey($key)
    {
        if (empty($key)) return 'item';

        $key = preg_replace('/[^a-zA-Z0-9_]/', '_', $key);

        if (empty($key) || is_numeric(substr($key, 0, 1))) {
            $key = 'item_' . $key;
        }

        return $key;
    }

    /* ============================================================
       MEMBER FUNCTIONS
    ============================================================ */

    /**
     * Display a listing of all members.
     */
    public function index()
    {
        try {
            $members = Member::all();
            
            return $this->isJsonOrXml([
                'status' => 'success',
                'message' => 'Members retrieved successfully',
                'data' => $members->toArray()
            ], 200);
        } catch (\Exception $e) {
            return $this->isJsonOrXml([
                'status' => 'error',
                'message' => 'Failed to retrieve members',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified member.
     */
    public function show($id)
    {
        try {
            $member = Member::findOrFail($id);
            
            return $this->isJsonOrXml([
                'status' => 'success',
                'message' => 'Member retrieved successfully',
                'data' => $member->toArray()
            ], 200);
        } catch (\Exception $e) {
            return $this->isJsonOrXml([
                'status' => 'error',
                'message' => 'Member not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Store a newly created member.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'middle_name' => 'nullable|string|max:255',
                'address' => 'required|string',
                'contact_number' => 'required|string|max:20',
                'date_of_birth' => 'required|date',
                'registration_date' => 'required|date',
                'purok' => 'required|string|max:100',
                'status' => 'required|string|max:50',
                'occupation' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                return $this->isJsonOrXml([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Calculate age from date_of_birth
            $age = Carbon::parse($request->date_of_birth)->age;

            $member = Member::create(array_merge($request->all(), ['age' => $age]));

            return $this->isJsonOrXml([
                'status' => 'success',
                'message' => 'Member created successfully',
                'data' => $member->toArray()
            ], 201);
        } catch (\Exception $e) {
            return $this->isJsonOrXml([
                'status' => 'error',
                'message' => 'Failed to create member',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified member.
     */
    public function update(Request $request, $id)
    {
        try {
            $member = Member::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'first_name' => 'sometimes|string|max:255',
                'last_name' => 'sometimes|string|max:255',
                'middle_name' => 'nullable|string|max:255',
                'address' => 'sometimes|string',
                'contact_number' => 'sometimes|string|max:20',
                'date_of_birth' => 'sometimes|date',
                'registration_date' => 'sometimes|date',
                'purok' => 'sometimes|string|max:100',
                'status' => 'sometimes|string|max:50',
                'occupation' => 'sometimes|string|max:255',
            ]);

            if ($validator->fails()) {
                return $this->isJsonOrXml([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Recalculate age if date_of_birth is being updated
            if ($request->has('date_of_birth')) {
                $age = Carbon::parse($request->date_of_birth)->age;
                $request->merge(['age' => $age]);
            }

            $member->update($request->all());

            return $this->isJsonOrXml([
                'status' => 'success',
                'message' => 'Member updated successfully',
                'data' => $member->toArray()
            ], 200);
        } catch (\Exception $e) {
            return $this->isJsonOrXml([
                'status' => 'error',
                'message' => 'Failed to update member',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified member.
     */
    public function destroy($id)
    {
        try {
            $member = Member::findOrFail($id);
            $member->delete();

            return $this->isJsonOrXml([
                'status' => 'success',
                'message' => 'Member deleted successfully',
                'data' => null
            ], 200);
        } catch (\Exception $e) {
            return $this->isJsonOrXml([
                'status' => 'error',
                'message' => 'Failed to delete member',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get senior members (age 60 and above)
     */
    public function seniors()
    {
        try {
            $seniors = Member::where('age', '>=', 60)->get();

            return $this->isJsonOrXml([
                'status' => 'success',
                'message' => 'Senior members retrieved successfully',
                'data' => $seniors->toArray(),
                'count' => $seniors->count()
            ], 200);
        } catch (\Exception $e) {
            return $this->isJsonOrXml([
                'status' => 'error',
                'message' => 'Failed to retrieve senior members',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get minor members (age below 18)
     */
    public function minors()
    {
        try {
            $minors = Member::where('age', '<', 18)->get();

            return $this->isJsonOrXml([
                'status' => 'success',
                'message' => 'Minor members retrieved successfully',
                'data' => $minors->toArray(),
                'count' => $minors->count()
            ], 200);
        } catch (\Exception $e) {
            return $this->isJsonOrXml([
                'status' => 'error',
                'message' => 'Failed to retrieve minor members',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get active members
     */
    public function active()
    {
        try {
            $activeMembers = Member::where('status', 'active')->get();

            return $this->isJsonOrXml([
                'status' => 'success',
                'message' => 'Active members retrieved successfully',
                'data' => $activeMembers->toArray(),
                'count' => $activeMembers->count()
            ], 200);
        } catch (\Exception $e) {
            return $this->isJsonOrXml([
                'status' => 'error',
                'message' => 'Failed to retrieve active members',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get inactive members
     */
    public function inactive()
    {
        try {
            $inactiveMembers = Member::where('status', 'inactive')->get();

            return $this->isJsonOrXml([
                'status' => 'success',
                'message' => 'Inactive members retrieved successfully',
                'data' => $inactiveMembers->toArray(),
                'count' => $inactiveMembers->count()
            ], 200);
        } catch (\Exception $e) {
            return $this->isJsonOrXml([
                'status' => 'error',
                'message' => 'Failed to retrieve inactive members',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get male members
     */
    public function male()
    {
        try {
            $maleMembers = Member::where('gender', 'Male')->get();

            return $this->isJsonOrXml([
                'status' => 'success',
                'message' => 'Male members retrieved successfully',
                'data' => $maleMembers->toArray(),
                'count' => $maleMembers->count()
            ], 200);
        } catch (\Exception $e) {
            return $this->isJsonOrXml([
                'status' => 'error',
                'message' => 'Failed to retrieve male members',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get female members
     */
    public function female()
    {
        try {
            $femaleMembers = Member::where('gender', 'female')->get();

            return $this->isJsonOrXml([
                'status' => 'success',
                'message' => 'Female members retrieved successfully',
                'data' => $femaleMembers->toArray(),
                'count' => $femaleMembers->count()
            ], 200);
        } catch (\Exception $e) {
            return $this->isJsonOrXml([
                'status' => 'error',
                'message' => 'Failed to retrieve female members',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get members by purok
     */
    public function purok($purok)
    {
        try {
            $members = Member::where('purok', $purok)->get();

            return $this->isJsonOrXml([
                'status' => 'success',
                'message' => "Members from purok $purok retrieved successfully",
                'data' => $members->toArray(),
                'count' => $members->count()
            ], 200);
        } catch (\Exception $e) {
            return $this->isJsonOrXml([
                'status' => 'error',
                'message' => 'Failed to retrieve members by purok',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Search members by name
     */
    public function search(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'q' => 'required|string|min:2'
            ]);

            if ($validator->fails()) {
                return $this->isJsonOrXml([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $query = $request->input('q');
            
            $members = Member::where('first_name', 'LIKE', "%{$query}%")
                ->orWhere('last_name', 'LIKE', "%{$query}%")
                ->orWhere('middle_name', 'LIKE', "%{$query}%")
                ->get();

            return $this->isJsonOrXml([
                'status' => 'success',
                'message' => 'Search results retrieved successfully',
                'data' => $members->toArray(),
                'count' => $members->count()
            ], 200);
        } catch (\Exception $e) {
            return $this->isJsonOrXml([
                'status' => 'error',
                'message' => 'Search failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get member statistics
     */
    public function statistics()
    {
        try {
            $totalMembers = Member::count();
            $activeMembers = Member::where('status', 'active')->count();
            $inactiveMembers = Member::where('status', 'inactive')->count();
            $seniorMembers = Member::where('age', '>=', 60)->count();
            $minorMembers = Member::where('age', '<', 18)->count();
            
            $maleMembers = Member::where('gender', 'Male')->count();
            $femaleMembers = Member::where('gender', 'Female')->count();

            return $this->isJsonOrXml([
                'status' => 'success',
                'message' => 'Statistics retrieved successfully',
                'data' => [
                    'total_members' => $totalMembers,
                    'active_members' => $activeMembers,
                    'inactive_members' => $inactiveMembers,
                    'senior_members' => $seniorMembers,
                    'minor_members' => $minorMembers,
                    'male_members' => $maleMembers,
                    'female_members' => $femaleMembers,
                ]
            ], 200);
        } catch (\Exception $e) {
            return $this->isJsonOrXml([
                'status' => 'error',
                'message' => 'Failed to retrieve statistics',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get age distribution
     */
    public function ageDistribution()
    {
        try {
            $ageGroups = [
                '0-17' => Member::where('age', '<', 18)->count(),
                '18-25' => Member::whereBetween('age', [18, 25])->count(),
                '26-35' => Member::whereBetween('age', [26, 35])->count(),
                '36-45' => Member::whereBetween('age', [36, 45])->count(),
                '46-59' => Member::whereBetween('age', [46, 59])->count(),
                '60+' => Member::where('age', '>=', 60)->count(),
            ];

            return $this->isJsonOrXml([
                'status' => 'success',
                'message' => 'Age distribution retrieved successfully',
                'data' => [
                    'age_groups' => $ageGroups
                ]
            ], 200);
        } catch (\Exception $e) {
            return $this->isJsonOrXml([
                'status' => 'error',
                'message' => 'Failed to retrieve age distribution',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}