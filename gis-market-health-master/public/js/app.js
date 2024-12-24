// Initialize map
var map = L.map('map').setView([-5.421, 105.257], 12);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '© OpenStreetMap contributors'
}).addTo(map);

// Custom icons with enhanced styling
var hospitalIcon = L.icon({
    iconUrl: '/images/hospital-icon.png',
    iconSize: [32, 32],
    iconAnchor: [16, 32],
    popupAnchor: [0, -32],
});

var marketIcon = L.icon({
    iconUrl: '/images/market-icon.png',
    iconSize: [32, 32],
    iconAnchor: [16, 32],
    popupAnchor: [0, -32],
});

// Layer groups with improved organization
var hospitalLayer = L.layerGroup().addTo(map);
var marketLayer = L.layerGroup().addTo(map);
var geoJsonLayer;
var roadLayer = L.layerGroup().addTo(map);
var routingControl;
var userMarker;
var activeRoute = false;

// Loading indicator functions
function showLoading() {
    document.getElementById('loadingIndicator').classList.add('active');
}

function hideLoading() {
    document.getElementById('loadingIndicator').classList.remove('active');
}

// Enhanced reset control
var ResetControl = L.Control.extend({
    options: {
        position: 'topleft'
    },

    onAdd: function(map) {
        var container = L.DomUtil.create('div', 'leaflet-bar leaflet-control');
        var button = L.DomUtil.create('a', 'reset-button', container);
        button.innerHTML = '↺';
        button.href = '#';
        button.title = 'Reset Peta';

        L.DomEvent.on(button, 'click', function(e) {
            L.DomEvent.preventDefault(e);
            resetNavigation();
        });

        return container;
    }
});

// Improved reset function
function resetNavigation() {
    if (routingControl) {
        map.removeControl(routingControl);
        routingControl = null;
        activeRoute = false;
    }
    if (geoJsonLayer) {
        map.fitBounds(geoJsonLayer.getBounds());
    }
    updateInfoPanel('Pilih fasilitas pada peta untuk melihat detail dan mendapatkan rute perjalanan.');
}

// Enhanced location tracking
function getCurrentLocation() {
    showLoading();
    return new Promise((resolve, reject) => {
        if ("geolocation" in navigator) {
            navigator.geolocation.getCurrentPosition(
                position => {
                    const userLocation = [position.coords.latitude, position.coords.longitude];
                    if (userMarker) {
                        userMarker.setLatLng(userLocation);
                    } else {
                        userMarker = L.marker(userLocation, {
                            icon: L.divIcon({
                                className: 'user-location-marker',
                                html: '<div class="user-location-dot"></div>'
                            })
                        }).addTo(map);
                    }
                    hideLoading();
                    resolve(userLocation);
                },
                error => {
                    hideLoading();
                    console.error("Error getting location:", error);
                    alert("Tidak dapat mengakses lokasi Anda. Pastikan GPS aktif dan izin lokasi diberikan.");
                    reject(error);
                },
                {
                    enableHighAccuracy: true,
                    timeout: 5000,
                    maximumAge: 0
                }
            );
        } else {
            hideLoading();
            reject(new Error("Browser Anda tidak mendukung geolokasi."));
        }
    });
}

// Information panel update
function updateInfoPanel(message) {
    document.getElementById('info-panel').innerHTML = message;
}

// Enhanced route creation
function createRoute(endLocation, facilityName) {
    showLoading();
    getCurrentLocation()
        .then(userLocation => {
            if (routingControl) {
                map.removeControl(routingControl);
            }

            routingControl = L.Routing.control({
                waypoints: [
                    L.latLng(userLocation[0], userLocation[1]),
                    L.latLng(endLocation[0], endLocation[1])
                ],
                routeWhileDragging: false,
                lineOptions: {
                    styles: [{ color: '#3182ce', weight: 4, opacity: 0.7 }]
                },
                createMarker: function() { return null; },
                addWaypoints: false,
                draggableWaypoints: false,
                fitSelectedRoutes: true
            }).addTo(map);

            routingControl.on('routesfound', function(e) {
                hideLoading();
                activeRoute = true;
                const routes = e.routes;
                const summary = routes[0].summary;
                updateInfoPanel(`
                    <strong>Rute ke ${facilityName}</strong><br>
                    Jarak: ${(summary.totalDistance / 1000).toFixed(1)} km<br>
                    Waktu tempuh: ${Math.round(summary.totalTime / 60)} menit
                `);
            });
        })
        .catch(error => {
            hideLoading();
            alert("Gagal membuat rute. Silakan coba lagi.");
        });
}

// Load GeoJSON with improved styling
fetch('/geojson/bandar_lampung.json')
    .then(response => response.json())
    .then(data => {
        geoJsonLayer = L.geoJSON(data, {
            style: function(feature) {
                var colors = {
                    'Kedaton': '#ffcdd2',
                    'Kemiling': '#90caf9',
                    'Panjang': '#c8e6c9',
                    'Rajabasa': '#e1bee7',
                    'Sukabumi': '#ffe0b2',
                    'Sukarame': '#fff9c4'
                };
                return {
                    fillColor: colors[feature.properties.name] || '#gray',
                    color: '#666',
                    weight: 1,
                    fillOpacity: 0.4,
                    smoothFactor: 0.5
                };
            },
            onEachFeature: function(feature, layer) {
                layer.bindPopup(`<strong>Kecamatan ${feature.properties.name}</strong>`);
            }
        }).addTo(map);
        map.fitBounds(geoJsonLayer.getBounds());
    })
    .catch(error => console.error('Error loading GeoJSON:', error));

// Load roads with improved styling
fetch('/geojson/jalan.geojson')
    .then(response => response.json())
    .then(data => {
        L.geoJSON(data, {
            style: function(feature) {
                return {
                    color: "#FF5733",
                    weight: 2,
                    opacity: 0.6,
                    smoothFactor: 0.5
                };
            }
        }).addTo(roadLayer);
    })
    .catch(error => console.error('Error loading road GeoJSON:', error));

// Enhanced facility markers
facilities.forEach(facility => {
    var popupContent = `
        <div class="facility-popup">
            <h6 class="mb-2">${facility.name}</h6>
            <p class="mb-2">${facility.address}</p>
            <div class="d-flex gap-2">
                <a href="/facility/${facility.id}" class="btn btn-sm btn-primary" style="color: white;">Lihat Detail</a>
                <button class="route-button" onclick="createRoute([${facility.latitude}, ${facility.longitude}], '${facility.name}')">
                    Rute ke Sini
                </button>
            </div>
        </div>
    `;

    var marker = L.marker(
        [facility.latitude, facility.longitude],
        {
            icon: facility.type === 'pasar' ? marketIcon : hospitalIcon,
            title: facility.name
        }
    ).bindPopup(popupContent);

    if (facility.type === 'pasar') {
        marketLayer.addLayer(marker);
    } else {
        hospitalLayer.addLayer(marker);
    }
});

// Enhanced layer controls
document.getElementById('rumahSakitLayer').addEventListener('change', function(e) {
    e.target.checked ? map.addLayer(hospitalLayer) : map.removeLayer(hospitalLayer);
    updateInfoPanel('Layer Rumah Sakit ' + (e.target.checked ? 'ditampilkan' : 'disembunyikan'));
});

document.getElementById('pasarLayer').addEventListener('change', function(e) {
    e.target.checked ? map.addLayer(marketLayer) : map.removeLayer(marketLayer);
    updateInfoPanel('Layer Pasar ' + (e.target.checked ? 'ditampilkan' : 'disembunyikan'));
});

document.getElementById('kecamatanLayer').addEventListener('change', function(e) {
    if (geoJsonLayer) {
        e.target.checked ? map.addLayer(geoJsonLayer) : map.removeLayer(geoJsonLayer);
        updateInfoPanel('Layer Polygon ' + (e.target.checked ? 'ditampilkan' : 'disembunyikan'));
    }
});

document.getElementById('jalanLayer').addEventListener('change', function(e) {
    e.target.checked ? map.addLayer(roadLayer) : map.removeLayer(roadLayer);
    updateInfoPanel('Layer Jalan ' + (e.target.checked ? 'ditampilkan' : 'disembunyikan'));
});

// Enhanced search functionality
document.getElementById('searchInput').addEventListener('input', function(e) {
    const searchText = e.target.value.toLowerCase();
    let matchCount = 0;

    function updateMarkerVisibility(layer) {
        const popupContent = layer.getPopup().getContent().toLowerCase();
        const isMatch = popupContent.includes(searchText);
        layer.setOpacity(isMatch ? 1 : 0.2);
        if (isMatch) matchCount++;
    }

    hospitalLayer.eachLayer(updateMarkerVisibility);
    marketLayer.eachLayer(updateMarkerVisibility);

    updateInfoPanel(searchText ?
        `Ditemukan ${matchCount} fasilitas dengan kata kunci "${e.target.value}"` :
        'Pilih fasilitas pada peta untuk melihat detail dan mendapatkan rute perjalanan.');
});

// Add reset control to map
map.addControl(new ResetControl());

// Initialize user location
getCurrentLocation().catch(error => console.warn("Initial location fetch failed:", error));

// Map zoom controls position
map.zoomControl.setPosition('topleft');
