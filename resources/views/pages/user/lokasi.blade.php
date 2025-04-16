@extends('layouts.index')

@section('content')
    <div class="container mt-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4>Data Lokasi</h4>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form action="{{ route('lokasi.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="business_type">Jenis Bisnis</label>
                        <select name="business_type" id="business_type" class="form-control" onchange="updateParameters()">
                            <option value="">-- Pilih Jenis Bisnis --</option>
                            <option value="makanan">Makanan</option>
                            <option value="minuman">Minuman</option>
                            <option value="jasa">Jasa</option>
                        </select>
                    </div>

                    <div id="locations" class="mt-3"></div>

                    <div class="mt-3">
                        <button type="button" class="btn btn-primary" onclick="addLocation()">Tambah Lokasi</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const availableLocations = @json($availableLocations);
        let locationCount = 0;
        let selectedParameters = [];

        const parameters = {
            makanan: [
                "Kepadatan Penduduk", "Lalu Lintas Kendaraan", "Jenis Lingkungan",
                "Daya Beli Masyarakat", "Kompetitor", "Area Keramaian", "Ketersediaan Ruko"
            ],
            minuman: [
                "Lalu Lintas Pejalan Kaki", "Tempat Nongkrong Terdekat", "Target Pasar",
                "Estetika Lokasi", "Daya Beli Masyarakat", "Kompetitor"
            ],
            jasa: [
                "Visibilitas Lokasi", "Parkiran", "Kedekatan Perumahan",
                "Akses Transportasi Umum", "Kebisingan", "Kompetitor", "Keamanan Area"
            ]
        };

        const linguisticOptions = {
            "Kepadatan Penduduk": ["Rendah", "Sedang", "Tinggi"],
            "Lalu Lintas Kendaraan": ["Sepi", "Sedang", "Ramai"],
            "Jenis Lingkungan": ["Tidak Kondusif", "Netral", "Kondusif"],
            "Daya Beli Masyarakat": ["Rendah", "Sedang", "Tinggi"],
            "Kompetitor": ["Banyak", "Sedang", "Sedikit"],
            "Area Keramaian": ["Tidak Ramai", "Sedang", "Ramai"],
            "Ketersediaan Ruko": ["Tidak Tersedia", "Terbatas", "Tersedia"],

            "Lalu Lintas Pejalan Kaki": ["Sepi", "Sedang", "Ramai"],
            "Tempat Nongkrong Terdekat": ["Tidak Ada", "Sedikit", "Banyak"],
            "Target Pasar": ["Tidak Sesuai", "Cukup", "Sesuai"],
            "Estetika Lokasi": ["Buruk", "Sedang", "Menarik"],

            "Visibilitas Lokasi": ["Tidak Terlihat", "Cukup", "Jelas"],
            "Parkiran": ["Tidak Ada", "Sedikit", "Banyak"],
            "Kedekatan Perumahan": ["Jauh", "Sedang", "Dekat"],
            "Akses Transportasi Umum": ["Sulit", "Sedang", "Mudah"],
            "Kebisingan": ["Tinggi", "Sedang", "Rendah"],
            "Keamanan Area": ["Rawan", "Sedang", "Aman"]
        };

        function updateParameters() {
            const businessType = document.getElementById("business_type").value;
            const locationsDiv = document.getElementById("locations");
            locationsDiv.innerHTML = "";
            locationCount = 0;

            selectedParameters = parameters[businessType] || [];
            if (selectedParameters.length > 0) {
                addLocation();
            }
        }

        function addLocation() {
            locationCount++;
            const div = document.createElement("div");
            div.classList.add("card", "p-3", "mt-3");
            div.id = `location_${locationCount}`;

            const locationOptions = availableLocations.map(loc =>
                `<option value="${loc.latitude},${loc.longitude}" data-nama_lokasi="${loc.nama_lokasi}">
                ${loc.nama_lokasi}
            </option>`).join('');

            const parameterInputs = selectedParameters.map(p => {
                const options = linguisticOptions[p] || ["Rendah", "Sedang", "Tinggi"];
                return `
                <td>
                    <select name="locations[${locationCount}][parameters][${p.replace(/\s+/g, '_').toLowerCase()}]" class="form-control">
                        ${options.map(opt => `<option value="${opt}">${opt}</option>`).join("")}
                    </select>
                </td>`;
            }).join("");

            div.innerHTML = `
            <h5>Lokasi ${locationCount}</h5>
            <div class="form-group">
                <label>Nama Lokasi</label>
                <select class="form-control" onchange="setCoordinates(this, ${locationCount})">
                    <option value="">-- Pilih Lokasi --</option>
                    ${locationOptions}
                </select>
                <input type="hidden" name="locations[${locationCount}][name]" id="location_name_${locationCount}">
            </div>
            <div class="form-group">
                <label>Latitude</label>
                <input type="text" name="locations[${locationCount}][latitude]" id="latitude_${locationCount}" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label>Longitude</label>
                <input type="text" name="locations[${locationCount}][longitude]" id="longitude_${locationCount}" class="form-control" readonly>
            </div>
            <table class="table table-bordered mt-3">
                <thead><tr>${selectedParameters.map(p => `<th>${p}</th>`).join("")}</tr></thead>
                <tbody><tr>${parameterInputs}</tr></tbody>
            </table>
            <button type="button" class="btn btn-danger" onclick="removeLocation(${locationCount})">Hapus Lokasi</button>
        `;
            document.getElementById("locations").appendChild(div);
        }

        function setCoordinates(select, id) {
            const selected = select.options[select.selectedIndex];
            if (!selected.value) return;

            const [lat, lng] = selected.value.split(',');
            const name = selected.dataset.nama_lokasi;

            document.getElementById(`latitude_${id}`).value = lat;
            document.getElementById(`longitude_${id}`).value = lng;
            document.getElementById(`location_name_${id}`).value = name;
        }

        function removeLocation(id) {
            const div = document.getElementById(`location_${id}`);
            if (div) div.remove();
        }

        document.addEventListener("DOMContentLoaded", updateParameters);
    </script>
@endsection
