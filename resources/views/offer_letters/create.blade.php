@extends('adminlte::page')
@section('title', 'Create Major')
@section('content_header')
    <h1 class="m-0 text-dark">Create Offering Letters</h1>
@stop
@section('content')
<div class="container">
    <form action="{{ route('offer_letters.store') }}" method="POST">
        @csrf
        <input type="hidden" name="applicant_id" value="{{ $applicant->id }}">

        <div class="mb-3">
            <label>No Surat</label>
            <input type="text" name="letter_number" class="form-control" required>
        </div>

       <div class="mb-3">
            <label>Job</label>
            <input type="text" class="form-control" value="{{ $applicant->job->job_name }} ({{ ucfirst($applicant->job->employee_type) }})" readonly>
            <input type="hidden" name="job_id" value="{{ $applicant->job->id }}">
        </div>

        <div class="mb-3 d-none" id="contract_duration_field">
            <label>Durasi Kontrak (bulan)</label>
            <input type="number" name="contract_duration" class="form-control" min="1">
        </div>


        <div class="mb-3">
            <label>Tanggal Surat</label>
            <input type="date" name="offer_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Tanggal Mulai Kerja</label>
            <input type="date" name="join_date" class="form-control">
        </div>

        <div class="mb-3">
            <label>Gaji Pokok</label>
            <input type="number" name="basic_salary" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Tunjangan (30% dari Gaji Pokok)</label>
            <input type="number" id="allowance" class="form-control" readonly>
        </div>

        <div class="mb-3">
            <label>Upah Responsibility (Opsional)</label>
            <input type="number" name="responsibility_allowance" class="form-control" placeholder="Isi jika ada, kosongkan jika tidak">
        </div>

        <div class="mb-3">
            <label>Total Gaji</label>
            <input type="number" id="total_salary" class="form-control" readonly>
        </div>
       
        <div class="mb-3">
            <label>Catatan</label>
            <textarea name="notes" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection

@section('js')
<script>
    document.getElementById('job_id').addEventListener('change', function () {
        let selected = this.options[this.selectedIndex];
        let type = selected.getAttribute('data-type');
        if (type === 'contract') {
            document.getElementById('contract_duration_field').style.display = 'block';
        } else {
            document.getElementById('contract_duration_field').style.display = 'none';
        }
    });
</script>

<script>
    const basicInput   = document.querySelector('input[name="basic_salary"]');
    const responsibilityInput = document.querySelector('input[name="responsibility_allowance"]');
    const allowanceEl  = document.getElementById('allowance');
    const totalEl      = document.getElementById('total_salary');

    function hitungTotal() {
        const basic = parseFloat(basicInput.value) || 0;
        const responsibility = parseFloat(responsibilityInput.value) || 0;
        const allowance = basic * 0.3;
        const total = basic + allowance + responsibility;

        allowanceEl.value = allowance;
        totalEl.value = total;
    }

    basicInput.addEventListener('input', hitungTotal);
    responsibilityInput.addEventListener('input', hitungTotal);
</script>
@endsection