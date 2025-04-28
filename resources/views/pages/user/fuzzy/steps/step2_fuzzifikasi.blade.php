<div class="alert alert-info">
    Silakan klik tombol di bawah untuk memproses fuzzyfikasi.
</div>

<form method="POST" action="{{ route('fuzzy.fuzzifikasi') }}">
    @csrf
    <button type="submit" class="btn btn-success">Proses Fuzzifikasi</button>
</form>
