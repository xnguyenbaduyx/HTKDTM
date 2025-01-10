@extends('layout')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Map</h1>
</div>

<!-- Content Row -->
<div class="row">

    <div id="map" style="height: 500px; width: 100%;"></div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var map = L.map('map').setView([10.8231, 106.6297], 13); // Default coordinates for Ho Chi Minh City
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
            }).addTo(map);

            // Example: Adding a marker
            function searchAddress(query) {
                fetch(`/search/${query}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length > 0) {
                            var result = data[0];
                            var lat = result.lat;
                            var lon = result.lon;

                            map.setView([lat, lon], 16); // Move map to result location
                            L.marker([lat, lon]).addTo(map).bindPopup(result.display_name).openPopup();
                        } else {
                            alert('No results found');
                        }
                    });
            }

            // Example: Add reverse geocode functionality
            function reverseGeocode(lat, lon) {
                fetch(`/reverse/${lat}/${lon}`)
                    .then(response => response.json())
                    .then(data => {
                        L.marker([lat, lon]).addTo(map).bindPopup(data.display_name).openPopup();
                    });
            }
        });
    </script>

</div>
@endsection
