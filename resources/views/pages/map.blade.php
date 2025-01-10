@extends('layout')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Map</h1>
    <div class="d-flex">
        <input type="text" id="searchQuery" class="form-control w-50 mr-2" placeholder="Enter a location" />
        <button id="searchButton" class="btn btn-primary">Search</button>
    </div>
</div>

<!-- Map Row -->
<div class="row">
    <div id="map" style="height: 500px; width: 100%;"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var map = L.map('map').setView([10.8231, 106.6297], 13); // Default coordinates for Ho Chi Minh City
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
            }).addTo(map);

            // Add search functionality
            document.getElementById('searchButton').addEventListener('click', function () {
                var query = document.getElementById('searchQuery').value;
                if (!query) {
                    alert('Please enter a location');
                    return;
                }

                fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length > 0) {
                            var result = data[0];
                            var lat = parseFloat(result.lat);
                            var lon = parseFloat(result.lon);

                            map.setView([lat, lon], 16); // Move map to result location
                            L.marker([lat, lon]).addTo(map).bindPopup(result.display_name).openPopup();
                        } else {
                            alert('No results found');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while searching');
                    });
            });
        });
    </script>
</div>
@endsection
