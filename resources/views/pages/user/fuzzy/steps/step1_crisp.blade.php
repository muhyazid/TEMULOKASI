@extends('layouts.index')

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bs-stepper/dist/css/bs-stepper.min.css">
    <div class="container mt-4">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0">Proses Metode Fuzzy Tsukamoto</h4>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <!-- Stepper -->
                <div id="tsukamotoStepper" class="bs-stepper mb-4">
                    <div class="bs-stepper-header" role="tablist">
                        <div class="step" data-target="#step-1">
                            <button class="step-trigger" role="tab">
                                <span class="bs-stepper-circle">1</span>
                                <span class="bs-stepper-label">Nilai Crisp</span>
                            </button>
                        </div>
                        <div class="line"></div>
                        <div class="step" data-target="#step-2">
                            <button class="step-trigger" role="tab">
                                <span class="bs-stepper-circle">2</span>
                                <span class="bs-stepper-label">Fuzzifikasi</span>
                            </button>
                        </div>
                        <div class="line"></div>
                        <div class="step" data-target="#step-3">
                            <button class="step-trigger" role="tab">
                                <span class="bs-stepper-circle">3</span>
                                <span class="bs-stepper-label">Inferensi</span>
                            </button>
                        </div>
                        <div class="line"></div>
                        <div class="step" data-target="#step-4">
                            <button class="step-trigger" role="tab">
                                <span class="bs-stepper-circle">4</span>
                                <span class="bs-stepper-label">Defuzzifikasi</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Form pilih lokasi -->
                <form action="{{ route('fuzzy.konversi') }}" method="POST">
                    @csrf

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th><input type="checkbox" id="checkAll"></th>
                                    <th>#</th>
                                    <th>Nama Lokasi</th>
                                    <th>Latitude</th>
                                    <th>Longitude</th>
                                    <th>Tanggal Input</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($locations as $index => $location)
                                    <tr data-toggle="collapse" data-target="#detail-{{ $location->id }}"
                                        class="accordion-toggle">
                                        <td><input type="checkbox" name="selected_locations[]" value="{{ $location->id }}">
                                        </td>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $location->name }}</td>
                                        <td>{{ $location->latitude }}</td>
                                        <td>{{ $location->longitude }}</td>
                                        <td>{{ $location->created_at ? $location->created_at->format('d-m-Y') : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" class="hiddenRow">
                                            <div id="detail-{{ $location->id }}" class="collapse">
                                                <table class="table table-sm table-bordered">
                                                    <thead class="bg-light">
                                                        <tr>
                                                            <th>Parameter</th>
                                                            <th>Label Linguistik</th>
                                                            <th>Nilai Crisp</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($location->parameters as $param)
                                                            @php
                                                                $crisp = \App\Models\LinguistikNilai::where(
                                                                    'parameter_name',
                                                                    $param->parameter_name,
                                                                )
                                                                    ->where('label_linguistik', $param->value)
                                                                    ->first();
                                                            @endphp
                                                            <tr>
                                                                <td>{{ ucwords(str_replace('_', ' ', $param->parameter_name)) }}
                                                                </td>
                                                                <td>{{ $param->value }}</td>
                                                                <td>{{ $crisp->nilai_crisp ?? '-' }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary float-right">Lanjut Perhitungan</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bs-stepper/dist/js/bs-stepper.min.js"></script>
    <script>
        const stepper = new window.Stepper(document.querySelector('#tsukamotoStepper'));

        document.getElementById('checkAll').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('input[name="selected_locations[]"]');
            checkboxes.forEach(cb => cb.checked = this.checked);
        });
    </script>
@endsection
