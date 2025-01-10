@extends('layout')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
</div>

<!-- Content Row -->
<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-body">
                <iframe id="superset-iframe" width="100%" height="600px" frameborder="0" allowfullscreen></iframe>
            </div>
        </div>
    </div>
</div>

<script>
    async function fetchGuestToken() {
        const response = await fetch('/api/token/guest'); // Fetch the token from your API endpoint
        const data = await response.json();
        return data; // This should return the guest token
    }

    async function loadDashboard() {
        const tokenData = await fetchGuestToken();
        const guestToken = tokenData.token; // Extract the token
        const dashboardId = '43406797-3673-4179-b8e5-771f922079d0'; // Your dashboard ID
        const dashboardUrl = `http://82.112.237.22:8088/superset/dashboard/${dashboardId}/?token=${guestToken}`;
        document.getElementById('superset-iframe').src = dashboardUrl; // Set the iframe source
    }

    loadDashboard(); // Call the function to load the dashboard
</script>
@endsection