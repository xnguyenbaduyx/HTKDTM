@extends('layout')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
</div>

<div id="superset-dashboard" style="width: 100%; height: 600px;"></div>
<style>
    #superset-dashboard iframe{
        width: 100%;
        height: 100%;
    }
</style>

<script src="https://unpkg.com/@superset-ui/embedded-sdk"></script>
<script>
    supersetEmbeddedSdk.embedDashboard({
        id: "43406797-3673-4179-b8e5-771f922079d0", // ID bảng điều khiển
        supersetDomain: "http://82.112.237.22:8088/", // Miền Superset
        mountPoint: document.getElementById("superset-dashboard"), 
        fetchGuestToken: () => fetchGuestTokenFromBackend(),
        dashboardUiConfig: {
            hideTitle: true,
            filters: {
                expanded: true,
            },
        },
        iframeSandboxExtras: ['allow-top-navigation', 'allow-popups-to-escape-sandbox']
    });

    async function fetchGuestTokenFromBackend() {
        try {
            const response = await fetch('/test', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                },
            });


            const data = await response.json();
            return data; 
        } catch (error) {
            console.error('Error fetching guest token:', error);
            throw error;
        }
    }
</script>
@endsection