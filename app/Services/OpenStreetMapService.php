<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class OpenStreetMapService
{
    protected $baseUrl = 'https://nominatim.openstreetmap.org';

    /**
     * Search for an address.
     *
     * @param string $query
     * @return array
     */
    public function searchAddress($query)
    {
        $response = Http::get("{$this->baseUrl}/search", [
            'q' => $query,
            'format' => 'json',
        ]);

        return $response->json();
    }

    /**
     * Reverse geocode by coordinates.
     *
     * @param float $latitude
     * @param float $longitude
     * @return array
     */
    public function reverseGeocode($latitude, $longitude)
    {
        $response = Http::get("{$this->baseUrl}/reverse", [
            'lat' => $latitude,
            'lon' => $longitude,
            'format' => 'json',
        ]);

        return $response->json();
    }
}