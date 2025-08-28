@extends('adminlte::page')
@section('title', 'Detail Offering Letter')
@section('content_header')
@stop

@section('content')
<div class="container mt-4">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Detail Offering Letter</h4>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>Nomor Surat</th>
                    <td>{{ $offer->letter_number }}</td>
                </tr>
                <tr>
                    <th>Tanggal Surat</th>
                    <td>{{ \Carbon\Carbon::parse($offer->offer_date)->format('d M Y') }}</td>
                </tr>
                <tr>
                    <th>Tanggal Mulai Kerja</th>
                    <td>{{ $offer->join_date ? \Carbon\Carbon::parse($offer->join_date)->format('d M Y') : '-' }}</td>
                </tr>
                <tr>
                    <th>Nama Pelamar</th>
                    <td>{{ $offer->applicant->name ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Posisi / Jabatan</th>
                    <td>{{ $offer->job->job_name ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Gaji Pokok</th>
                    <td>Rp {{ number_format($offer->basic_salary, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Allowance (30% dari Basic)</th>
                    <td>Rp {{ number_format($offer->allowance, 0, ',', '.') }}</td>
                </tr>
                @if($offer->responsibility_allowance > 0)
                <tr>
                    <th>Tunjangan Tanggung Jawab</th>
                    <td>Rp {{ number_format($offer->responsibility_allowance, 0, ',', '.') }}</td>
                </tr>
                @endif
                <tr>
                    <th>Total Gaji</th>
                    <td><strong>Rp {{ number_format($offer->total_salary, 0, ',', '.') }}</strong></td>
                </tr>
                <tr>
                    <th>Durasi Kontrak</th>
                    <td>{{ $offer->contract_duration ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Catatan</th>
                    <td>{{ $offer->notes ?? '-' }}</td>
                </tr>
            </table>

            <div class="mt-4 d-flex justify-content-between align-items-center">
                <div>
                    
                    <form id="sendEmailForm" action="{{ route('offer_letters.send_email', $offer->id) }}" method="POST" class="d-inline me-2">
                        @csrf
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-envelope"></i> Send Email
                        </button>
                    </form>

                    <a href="{{ route('offer_letters.download', $offer->id) }}" class="btn btn-success me-2" target="_blank">
                        <i class="bi bi-download"></i> Download PDF
                    </a>

                    <a href="{{ route('offer_letters.edit', $offer->id) }}" class="btn btn-warning me-2">
                        <i class="bi bi-pencil-square"></i> Edit
                    </a>
                </div>

                <a href="{{ url()->previous() }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Modal Loading -->
<div class="modal fade" id="loadingModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-center p-4">
      <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
      <p class="mt-2">Sending email...</p>
    </div>
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    $('#sendEmailForm').on('submit', function(e) {
        e.preventDefault();

        var form = $(this);
        var url = form.attr('action');
        var data = form.serialize();

        // Tampilkan modal loading
        var loadingModal = new bootstrap.Modal(document.getElementById('loadingModal'));
        loadingModal.show();

        $.post(url, data, function(response) {
            loadingModal.hide();

            // Popup success
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: response.message || 'Offer letter sent successfully!',
            });
        }).fail(function(xhr) {
            loadingModal.hide();
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: xhr.responseJSON?.message || 'Failed to send email.',
            });
        });
    });
});
</script>
@endsection
