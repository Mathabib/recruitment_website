@extends('adminlte::page')
@section('title', 'Edit Offering Letter')
@section('content_header')
    <h1 class="m-0 text-dark">Edit Offering Letter</h1>
@stop

@section('content')
<div class="container">
    <form action="{{ route('offer_letters.update', $offer->id) }}" method="POST">
        @csrf
        @method('PUT')

        <input type="hidden" name="applicant_id" value="{{ $offer->applicant_id }}">

        <div class="mb-3">
            <label>No Surat</label>
            <input type="text" name="letter_number" class="form-control" 
                   value="{{ old('letter_number', $offer->letter_number) }}" required>
        </div>

        <div class="mb-3">
            <label>Job</label>
            <input type="text" class="form-control" 
                   value="{{ $offer->job->job_name }} ({{ ucfirst($offer->job->employee_type) }})" readonly>
            <input type="hidden" name="job_id" value="{{ $offer->job->id }}">
        </div>

        <div class="mb-3 {{ $offer->job->employee_type == 'contract' ? '' : 'd-none' }}" id="contract_duration_field">
            <label>Durasi Kontrak (bulan)</label>
            <input type="number" name="contract_duration" class="form-control" min="1"
                   value="{{ old('contract_duration', $offer->contract_duration) }}">
        </div>

        <div class="mb-3">
            <label>Tanggal Surat</label>
            <input type="date" name="offer_date" class="form-control"
                   value="{{ old('offer_date', $offer->offer_date) }}" required>
        </div>

        <div class="mb-3">
            <label>Tanggal Mulai Kerja</label>
            <input type="date" name="join_date" class="form-control"
                   value="{{ old('join_date', $offer->join_date) }}">
        </div>

        <div class="mb-3">
            <label>Gaji Pokok</label>
            <input type="number" name="basic_salary" class="form-control" 
                   value="{{ old('basic_salary', $offer->basic_salary) }}" required>
        </div>

        <div class="mb-3">
            <label>Tunjangan (30% dari Gaji Pokok)</label>
            <input type="number" id="allowance" class="form-control" 
                   value="{{ $offer->basic_salary * 0.3 }}" readonly>
        </div>

        <div class="mb-3">
            <label>Upah Responsibility (Opsional)</label>
            <input type="number" name="responsibility_allowance" class="form-control" 
                   value="{{ old('responsibility_allowance', $offer->responsibility_allowance) }}">
        </div>

        <div class="mb-3">
            <label>Total Gaji</label>
            <input type="number" id="total_salary" class="form-control" 
                   value="{{ $offer->basic_salary + ($offer->basic_salary*0.3) + ($offer->responsibility_allowance ?? 0) }}" readonly>
        </div>
       
        <div class="mb-3">
            <label>Catatan</label>
            <textarea name="notes" class="form-control">{{ old('notes', $offer->notes) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('offer_letters.show', $offer->id) }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection

@section('js')
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
