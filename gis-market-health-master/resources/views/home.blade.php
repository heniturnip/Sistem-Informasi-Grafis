<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Geografis Bandar Lampung</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        #map { height: 500px; }
        .filter-section { margin-bottom: 20px; }
        .category-box { display: flex; justify-content: space-around; margin: 20px 0; }
        .category-box div { text-align: center; }
        .card { box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); margin-bottom: 20px; }
        .card img { border-radius: 5px; }
        .card-body { padding: 20px; }
    </style>
</head>
<body>

    <header class="bg-primary text-white text-center py-4">
        <h1>Sistem Informasi Geografis Fasilitas Umum di Bandar Lampung</h1>
        <p>Petunjuk arah untuk menemukan fasilitas umum di Bandar Lampung</p>
    </header>

    <main class="container mt-4">
        <!-- Filter Section -->
        <section class="filter-section">
            <div class="row">
                <div class="col-md-6">
                    <input type="text" id="searchInput" class="form-control" placeholder="Cari Fasilitas..." onkeyup="filterFacilities()">
                </div>
                <div class="col-md-6">
                    <select id="categoryFilter" class="form-select" onchange="filterFacilities()">
                        <option value="">Pilih Kategori</option>
                        <option value="rumah sakit">Rumah Sakit</option>
                        <option value="pasar">Pasar</option>
                    </select>
                </div>
            </div>
        </section>

        <!-- Kategori Fasilitas -->
        <section>
            <h2>Kategori Fasilitas</h2>
            <div class="category-box">
                <div>
                    <img src="{{ asset('images/hospital-icon.png') }}" alt="Rumah Sakit" style="width: 60px;">
                    <p>Rumah Sakit</p>
                </div>
                <div>
                    <img src="{{ asset('images/market-icon.png') }}" alt="Pasar" style="width: 60px;">
                    <p>Pasar</p>
                </div>
            </div>
        </section>

        <!-- Peta Lokasi -->
        <section>
            <h2>Peta Lokasi Fasilitas</h2>
            <div id="map"></div>
        </section>

        <!-- Fasilitas Cards -->
        <section>
            <h2 class="mt-5">Fasilitas Umum Terdekat</h2>
            <div class="row">
                @foreach($facilities as $facility)
                    <div class="col-md-4">
                        <div class="card">
                            <img src="{{ asset('images/' . ($facility->type == 'pasar' ? 'market' : 'hospital') . '-icon.png') }}" class="card-img-top" alt="Fasilitas Icon">
                            <div class="card-body">
                                <h5 class="card-title">{{ $facility->name }}</h5>
                                <p class="card-text"><strong>Alamat:</strong> {{ $facility->address }}</p>
                                <p class="card-text"><strong>Jenis:</strong> {{ ucfirst($facility->type) }}</p>
                                <a href="{{ url('/facility/' . $facility->id) }}" class="btn btn-primary">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </main>

    <footer class="bg-primary text-white text-center py-3">
        <p>&copy; 2024 Sistem Informasi Geografis Bandar Lampung. All rights reserved.</p>
    </footer>

    <!-- JavaScript -->
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
    <script>
        var map = L.map('map').setView([-5.421, 105.257], 12); // Koordinat Bandar Lampung
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19
        }).addTo(map);

        var markers = [];

        @foreach($facilities as $facility)
            var marker = L.marker([{{ $facility->latitude }}, {{ $facility->longitude }}])
                .addTo(map)
                .bindPopup('<b>{{ $facility->name }}</b><br>{{ $facility->address }}');

            markers.push({
                marker: marker,
                name: '{{ $facility->name }}',
                type: '{{ $facility->type }}'
            });
        @endforeach

        function filterFacilities() {
            var searchQuery = document.getElementById('searchInput').value.toLowerCase();
            var categoryFilter = document.getElementById('categoryFilter').value;

            markers.forEach(function(item) {
                var nameMatch = item.name.toLowerCase().includes(searchQuery);
                var typeMatch = categoryFilter === "" || item.type === categoryFilter;

                if (nameMatch && typeMatch) {
                    item.marker.addTo(map);
                } else {
                    map.removeLayer(item.marker);
                }
            });
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
