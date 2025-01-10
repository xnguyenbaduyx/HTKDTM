<?php

namespace App\Http\Controllers;

use App\Services\OpenStreetMapService;

class LocationController extends Controller
{
    protected $osmService;

    public function __construct(OpenStreetMapService $osmService)
    {
        $this->osmService = $osmService;
    }

    /**
     * Search for an address.
     *
     * @param string $query
     * @return \Illuminate\Http\JsonResponse
     */
    public function search($query)
    {
        $results = $this->osmService->searchAddress($query);

        return response()->json($results);
    }

    /**
     * Reverse geocode by coordinates.
     *
     * @param float $latitude
     * @param float $longitude
     * @return \Illuminate\Http\JsonResponse
     */
    public function reverse($latitude, $longitude)
    {
        $result = $this->osmService->reverseGeocode($latitude, $longitude);

        return response()->json($result);
    }
}