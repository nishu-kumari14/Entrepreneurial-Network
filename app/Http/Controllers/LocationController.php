<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{
    public function nearbyUsers(Request $request)
    {
        $user = auth()->user();
        $radius = $request->input('radius', 50); // Default 50km radius
        $limit = $request->input('limit', 20);

        $users = User::select('users.*')
            ->selectRaw('(6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance', [
                $user->latitude,
                $user->longitude,
                $user->latitude
            ])
            ->where('id', '!=', $user->id)
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->having('distance', '<', $radius)
            ->orderBy('distance')
            ->limit($limit)
            ->get();

        return view('location.nearby-users', compact('users', 'radius'));
    }

    public function updateLocation(Request $request)
    {
        $validated = $request->validate([
            'country' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'timezone' => 'required|string|max:255',
        ]);

        auth()->user()->update($validated);

        return redirect()->back()->with('success', 'Location updated successfully.');
    }

    public function searchByLocation(Request $request)
    {
        $query = $request->input('query');
        $country = $request->input('country');
        $state = $request->input('state');
        $city = $request->input('city');
        $radius = $request->input('radius', 50);

        $users = User::when($query, function($q) use ($query) {
            return $q->where('name', 'like', "%{$query}%")
                    ->orWhere('bio', 'like', "%{$query}%");
        })
        ->when($country, function($q) use ($country) {
            return $q->where('country', $country);
        })
        ->when($state, function($q) use ($state) {
            return $q->where('state', $state);
        })
        ->when($city, function($q) use ($city) {
            return $q->where('city', $city);
        })
        ->when($radius && auth()->user()->latitude && auth()->user()->longitude, function($q) use ($radius) {
            $user = auth()->user();
            return $q->selectRaw('users.*, (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance', [
                $user->latitude,
                $user->longitude,
                $user->latitude
            ])
            ->having('distance', '<', $radius)
            ->orderBy('distance');
        })
        ->paginate(20);

        return view('location.search', compact('users'));
    }

    public function getCountries()
    {
        $countries = User::select('country')
            ->whereNotNull('country')
            ->distinct()
            ->pluck('country');

        return response()->json($countries);
    }

    public function getStates($country)
    {
        $states = User::select('state')
            ->where('country', $country)
            ->whereNotNull('state')
            ->distinct()
            ->pluck('state');

        return response()->json($states);
    }

    public function getCities($state)
    {
        $cities = User::select('city')
            ->where('state', $state)
            ->whereNotNull('city')
            ->distinct()
            ->pluck('city');

        return response()->json($cities);
    }
} 