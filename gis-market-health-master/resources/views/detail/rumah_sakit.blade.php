<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Fasilitas Rumah Sakit</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        #map { height: 500px; }

        .custom-header {
        background-color: #343a40;
        color: white;
    }
    </style>
</head>
<body>

    <header class="custom-header text-white text-center py-4">
        <h1>Detail Fasilitas Rumah Sakit</h1>
        <p>Informasi lengkap tentang rumah sakit di Bandar Lampung</p>
    </header>

    <main class="container mt-4">
        <section>
            <h2>{{ $facility->name }}</h2>
            <p><strong>Alamat:</strong> {{ $facility->address }}</p>
            <p><strong>Phone:</strong> {{ $facility->phone }}</p>
            <p><strong>Latitude:</strong> {{ $facility->latitude }}</p>
            <p><strong>Longitude:</strong> {{ $facility->longitude }}</p>
        </section>

        <section>
            <h3>Lokasi Rumah Sakit di Peta</h3>
            <div id="map"></div>
        </section>

        <section>
            <a href="{{ url('/') }}" class="btn btn-primary mt-3">Kembali ke Halaman Utama</a>
        </section>
    </main>

    <footer class="text-center py-3 mt-4">
        <p>&copy; 2024 Sistem Informasi Geografis | Kelompok 6.</p>
    </footer>

    <script>
        var map = L.map('map').setView([{{ $facility->latitude }}, {{ $facility->longitude }}], 15);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a>',
            maxZoom: 19
        }).addTo(map);

        var facilityIcon = L.icon({
            iconUrl: '{{ asset('images/hospital-icon.png') }}',
            iconSize: [32, 32],
            iconAnchor: [16, 32],
            popupAnchor: [0, -32]
        });

        L.marker([{{ $facility->latitude }}, {{ $facility->longitude }}], { icon: facilityIcon })
            .addTo(map)
            .bindPopup('<b>{{ $facility->name }}</b><br>{{ $facility->address }}');
    </script>

</body>
</html>
