<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Geografis Fasilitas Umum di Bandar Lampung</title>
    <link rel="icon" href="{{ asset('images/logo.jpeg') }}" type="image/png">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
    <nav class="navbar">
        <div class="container-fluid">
            <img src="{{ asset('images/logo.jpeg') }}" alt="Logo" class="navbar-logo" style="height: 40px; margin-right: 10px;">
            <h5 class="mb-0">Bandar Lampung Health & Market GIS</h5>
        </div>
    </nav>

    <div class="main-content">
        <div class="sidebar-left">
            <div class="search-box">
                <input type="text" class="search-input" id="searchInput" placeholder="Cari nama fasilitas...">
            </div>

            <div class="layer-group">
                <div class="layer-header">
                    <span>Fasilitas</span>
                </div>
                <div class="layer-item">
                    <input type="checkbox" id="rumahSakitLayer" checked>
                    <span>Rumah Sakit</span>
                </div>
                <div class="layer-item">
                    <input type="checkbox" id="pasarLayer" checked>
                    <span>Pasar</span>
                </div>
            </div>

            <div class="layer-group">
                <div class="layer-header">
                    <span>Peta Dasar</span>
                </div>
                <div class="layer-item">
                    <input type="checkbox" id="kecamatanLayer" checked>
                    <span>Polygon</span>
                </div>
                <div class="layer-item">
                    <input type="checkbox" id="jalanLayer" checked>
                    <span>Jalan</span>
                </div>
            </div>

            <div class="layer-group">
                <div class="layer-header">Informasi</div>
                <div id="info-panel" class="p-2">
                    Pilih fasilitas pada peta untuk melihat detail dan mendapatkan rute perjalanan.
                </div>
            </div>
        </div>

        <div class="map-container">
            <div id="map"></div>
            <div class="loading-indicator" id="loadingIndicator">
                Memuat rute...
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>
    <script>
        var facilities = {!! json_encode($facilities) !!};
    </script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
