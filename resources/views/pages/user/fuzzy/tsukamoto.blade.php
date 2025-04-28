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
                <div id="tsukamotoStepper" class="bs-stepper">
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

                    <div class="bs-stepper-content">
                        <!-- STEP 1: NILAI CRISP -->
                        <div id="step-1" class="content" role="tabpanel">
                            @include('pages.user.fuzzy.steps.step1_crisp')
                            <div class="mt-3">
                                <button class="btn btn-success float-right" onclick="stepper.next()">Lanjut</button>
                            </div>
                        </div>

                        <!-- STEP 2: FUZZIFIKASI -->
                        <div id="step-2" class="content" role="tabpanel">
                            @include('pages.user.fuzzy.steps.step2_fuzzifikasi')
                            <div class="mt-3">
                                <button class="btn btn-secondary" onclick="stepper.previous()">Kembali</button>
                                <button class="btn btn-success float-right" onclick="stepper.next()">Lanjut</button>
                            </div>
                        </div>

                        <!-- STEP 3: INFERENSI -->
                        <div id="step-3" class="content" role="tabpanel">
                            @include('pages.user.fuzzy.steps.step3_inferensi')
                            <div class="mt-3">
                                <button class="btn btn-secondary" onclick="stepper.previous()">Kembali</button>
                                <button class="btn btn-success float-right" onclick="stepper.next()">Lanjut</button>
                            </div>
                        </div>

                        <!-- STEP 4: DEFUZZIFIKASI -->
                        <div id="step-4" class="content" role="tabpanel">
                            @include('pages.user.fuzzy.steps.step4_defuzzifikasi')
                            <div class="mt-3">
                                <button class="btn btn-secondary" onclick="stepper.previous()">Kembali</button>
                                <button class="btn btn-primary float-right">Simpan / Selesai</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bs-stepper/dist/js/bs-stepper.min.js"></script>
    <script>
        const stepper = new window.Stepper(document.querySelector('#tsukamotoStepper'));
    </script>
@endsection
