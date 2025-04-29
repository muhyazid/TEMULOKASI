@extends('layouts.index')

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bs-stepper/dist/css/bs-stepper.min.css">

    <div class="container mt-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Input Data Lokasi</h4>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <!-- Stepper -->
                <div id="stepper" class="bs-stepper">
                    <div class="bs-stepper-header" role="tablist">
                        <div class="step" data-target="#step-1">
                            <button type="button" class="step-trigger" role="tab">
                                <span class="bs-stepper-circle">1</span>
                                <span class="bs-stepper-label">Pilih Jenis & Lokasi</span>
                            </button>
                        </div>
                        <div class="line"></div>
                        <div class="step" data-target="#step-2">
                            <button type="button" class="step-trigger" role="tab">
                                <span class="bs-stepper-circle">2</span>
                                <span class="bs-stepper-label">Isi Parameter</span>
                            </button>
                        </div>
                        <div class="line"></div>
                        <div class="step" data-target="#step-3">
                            <button type="button" class="step-trigger" role="tab">
                                <span class="bs-stepper-circle">3</span>
                                <span class="bs-stepper-label">Konversi Crisp</span>
                            </button>
                        </div>
                    </div>

                    <div class="bs-stepper-content">
                        <form id="lokasi-form" action="{{ route('lokasi.store') }}" method="POST">
                            @csrf

                            <!-- Step 1 -->
                            <div id="step-1" class="content" role="tabpanel">
                                <div class="form-group">
                                    <label for="business_type">Jenis Bisnis</label>
                                    <select name="business_type" id="business_type" class="form-control"
                                        onchange="updateParameters()">
                                        <option value="">-- Pilih Jenis Bisnis --</option>
                                        <option value="makanan">Makanan</option>
                                        <option value="minuman">Minuman</option>
                                    </select>
                                </div>

                                <div id="locations" class="mt-3"></div>

                                <button type="button" class="btn btn-primary mt-3" onclick="addLocation()">Tambah
                                    Lokasi</button>
                                <div class="mt-4">
                                    <button type="button" class="btn btn-primary" onclick="stepper.next()">Lanjut</button>
                                </div>
                            </div>

                            <!-- Step 2 -->
                            <div id="step-2" class="content" role="tabpanel">
                                <div id="parameter-container" class="row"></div>
                                <div class="mt-4">
                                    <button type="button" class="btn btn-secondary"
                                        onclick="stepper.previous()">Kembali</button>
                                    <button type="button" class="btn btn-primary" onclick="stepper.next()">Lanjut ke
                                        Konversi</button>
                                </div>
                            </div>

                            <!-- Step 3 -->
                            <div id="step-3" class="content" role="tabpanel">
                                <div class="text-right mb-3">
                                    <button type="button" class="btn btn-info" onclick="hitungKonversi()">Tampilkan Hasil
                                        Konversi</button>
                                </div>

                                <div id="crisp-result" class="row"></div>

                                <div class="mt-4">
                                    <button type="button" class="btn btn-secondary"
                                        onclick="stepper.previous()">Kembali</button>
                                    <button type="submit" class="btn btn-success">Simpan & Lanjut Proses</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Stepper & Script -->
    <script src="https://cdn.jsdelivr.net/npm/bs-stepper/dist/js/bs-stepper.min.js"></script>
    <script>
        const stepper = new window.Stepper(document.querySelector('#stepper'));
        const availableLocations = @json($availableLocations);
        let locationCount = 0;
        let selectedParameters = [];

        const parameters = {
            makanan: ["Aksesibilitas", "Visibilitas", "Daya Beli Masyarakat", "Kompetitor",
                "Ketersediaan Infrastruktur", "Lingkungan Sekitar", "Ketersediaan Parkir"
            ],
            minuman: ["Aksesibilitas", "Visibilitas", "Daya Beli Masyarakat", "Kompetitor",
                "Ketersediaan Infrastruktur", "Lingkungan Sekitar", "Ketersediaan Parkir"
            ]
        };

        const parameterDescriptions = {
            "Aksesibilitas": "Kemudahan akses menuju lokasi oleh pelanggan.",
            "Visibilitas": "Seberapa mudah lokasi terlihat dari jalan utama atau keramaian.",
            "Daya Beli Masyarakat": "Kemampuan finansial masyarakat di sekitar lokasi.",
            "Kompetitor ": "Jumlah pesaing sejenis di sekitar lokasi.",
            "Ketersediaan Infrastruktur": "Kelengkapan fasilitas penunjang seperti parkir, listrik, dll.",
            "Lingkungan Sekitar": "Kondisi sosial dan keamanan lingkungan sekitar lokasi.",
            "Ketersediaan Parkir": "Luas lahan atau tempat parkir yang tersedia di lokasi."
        };

        const linguisticOptions = {
            "Aksesibilitas": ["Tidak Mudah", "Cukup Mudah", "Sangat Mudah"],
            "Visibilitas": ["Tidak Terlihat", "Terlihat Sebagian", "Sangat Terlihat"],
            "Daya Beli Masyarakat": ["Rendah", "Menengah", "Tinggi"],
            "Kompetitor": ["< 2", "2 - 4", "> 4"],
            "Ketersediaan Infrastruktur": ["Tidak Lengkap", "Cukup", "Lengkap"],
            "Lingkungan Sekitar": ["Tidak Mendukung", "Netral", "Sangat Mendukung"],
            "Ketersediaan Parkir": ["Sempit", "Cukup", "Luas"]
        };

        const crispMap = {
            "Tidak Mudah": 2,
            "Cukup Mudah": 5,
            "Sangat Mudah": 8,
            "Tidak Terlihat": 2,
            "Terlihat Sebagian": 5,
            "Sangat Terlihat": 8,
            "Rendah": 2,
            "Menengah": 5,
            "Tinggi": 8,
            "< 2": 2,
            "2 - 4": 5,
            "> 4": 8,
            "Tidak Lengkap": 2,
            "Cukup": 5,
            "Lengkap": 8,
            "Tidak Mendukung": 2,
            "Netral": 5,
            "Sangat Mendukung": 8,
            "Sempit": 2,
            "Cukup": 5,
            "Luas": 8
        };

        function updateParameters() {
            const businessType = document.getElementById("business_type").value;
            const locationsDiv = document.getElementById("locations");
            document.getElementById("parameter-container").innerHTML = '';
            document.getElementById("crisp-result").innerHTML = '';
            locationsDiv.innerHTML = '';
            locationCount = 0;
            selectedParameters = parameters[businessType] || [];
            if (selectedParameters.length > 0) addLocation();
        }

        function addLocation() {
            locationCount++;

            const locDiv = document.createElement("div");
            locDiv.classList.add("card", "p-3", "mt-3");
            locDiv.id = `location_${locationCount}`;
            const locOptions = availableLocations.map(loc =>
                `<option value="${loc.latitude},${loc.longitude}" data-nama_lokasi="${loc.nama_lokasi}">
                    ${loc.nama_lokasi}
                </option>`).join('');

            locDiv.innerHTML = `
                <h5>Lokasi ${locationCount}</h5>
                <div class="form-group">
                    <label>Nama Lokasi</label>
                    <select class="form-control" id="location_select_${locationCount}" onchange="setCoordinates(this, ${locationCount}, true)">
                        <option value="">-- Pilih Lokasi --</option>
                        ${locOptions}
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
                </div>`;
            document.getElementById("locations").appendChild(locDiv);

            const paramContainer = document.getElementById("parameter-container");
            const paramCard = document.createElement("div");
            paramCard.className = "col-12 mb-4";
            paramCard.id = `param_card_${locationCount}`;

            paramCard.innerHTML = `
                <div class="card shadow-sm border-info">
                    <div class="card-header bg-info text-white font-weight-bold">
                        Parameter Lokasi ${locationCount} (<span id="loc_name_label_${locationCount}">Belum Dipilih</span>)
                    </div>
                    <div class="card-body">
                        <div class="row" id="param_inputs_${locationCount}">
                            ${selectedParameters.map(p => {
                                const options = linguisticOptions[p] || ["Rendah", "Sedang", "Tinggi"];
                                const description = parameterDescriptions[p] || "";
                                return `
                                                                                                                            <div class="col-md-6 mb-3">
                                                                                                                                <label class="font-weight-bold">${p}</label>
                                                                                                                                <small class="form-text text-muted">${description}</small>
                                                                                                                                <select name="locations[${locationCount}][parameters][${p.replace(/\s+/g, '_').toLowerCase()}]" 
                                                                                                                                    class="form-control" id="ling_${locationCount}_${p.replace(/\s+/g, '_')}">
                                                                                                                                    ${options.map(opt => `<option value="${opt}">${opt}</option>`).join("")}
                                                                                                                                </select>
                                                                                                                            </div>`;
                            }).join("")}
                        </div>
                    </div>
                </div>`;
            paramContainer.appendChild(paramCard);
        }

        function setCoordinates(select, id, updateLabel = false) {
            const selected = select.options[select.selectedIndex];
            if (!selected.value) return;

            const [lat, lng] = selected.value.split(',');
            const name = selected.dataset.nama_lokasi;

            document.getElementById(`latitude_${id}`).value = lat;
            document.getElementById(`longitude_${id}`).value = lng;
            document.getElementById(`location_name_${id}`).value = name;

            if (updateLabel) {
                const label = document.getElementById(`loc_name_label_${id}`);
                if (label) label.innerText = name;
            }
        }

        function hitungKonversi() {
            const crispDiv = document.getElementById("crisp-result");
            crispDiv.innerHTML = "";

            for (let i = 1; i <= locationCount; i++) {
                const namaLokasi = document.getElementById(`location_name_${i}`).value || `Lokasi ${i}`;
                let html = `<div class="col-md-6 mb-3">
                    <div class="card border-success shadow">
                        <div class="card-header bg-success text-white">
                            <strong>Hasil Konversi Lokasi ${i}</strong> - ${namaLokasi}
                        </div>
                    <div class="card-body p-2">
                        <ul class="list-group list-group-flush">`;

                selectedParameters.forEach(p => {
                    const inputId = `ling_${i}_${p.replace(/\s+/g, '_')}`;
                    const selectedValue = document.getElementById(inputId)?.value;
                    const crisp = crispMap[selectedValue] || '-';
                    html += `
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        ${p}
                        <span class="badge badge-primary">${selectedValue} → <strong>${crisp}</strong></span>
                    </li>`;
                });

                html += `</ul></div></div></div>`;
                crispDiv.innerHTML += html;
            }
        }
        // Validasi sebelum submit
        document.getElementById('lokasi-form').addEventListener('submit', function(e) {
            let error = false;
            for (let i = 1; i <= locationCount; i++) {
                const lat = document.getElementById(`latitude_${i}`).value;
                const lng = document.getElementById(`longitude_${i}`).value;
                if (!lat || !lng || isNaN(lat) || isNaN(lng)) {
                    error = true;
                    break;
                }
            }

            if (error) {
                e.preventDefault();
                alert('⚠️ Anda harus memilih lokasi dengan koordinat yang valid (latitude & longitude)!');
            }
        });
    </script>
@endsection
