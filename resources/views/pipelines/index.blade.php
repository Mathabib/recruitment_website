@extends('adminlte::page')

@section('title', 'List Applicants')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
<h1 class="m-0 text-dark">
    <b>List Applicants 
        @if(isset($jobTitle))
            - {{ $jobTitle }}
            @if(isset($stageName) && $request->has('job_id') && $request->has('status'))
                ({{ $stageName }})
            @endif
        @endif
    </b>
</h1>






    <!-- Filter Status Stage -->
  
    <!-- Kode untuk menampilkan stage -->
    <div class="status-boxes">
    <a href="{{ route('pipelines.index', ['stage' => null, 'education' => null, 'job_id' => $request->get('job_id')]) }}" class="status-box status-all {{ $request->get('stage') == 'all' ? 'active' : '' }}">
        <small>All</small>
    </a>
    <a href="{{ route('pipelines.index', ['status' => 'applied', 'education' => $request->get('education'), 'job_id' => $request->get('job_id')]) }}" class="status-box status-applied {{ $request->get('status') == 'applied' ? 'active' : '' }}">
        <p>{{ $statusCounts['applied'] }}</p>
        <small>Applied</small>
    </a>
    <a href="{{ route('pipelines.index', ['status' => 'interview', 'education' => $request->get('education'), 'job_id' => $request->get('job_id')]) }}" class="status-box status-interview {{ $request->get('status') == 'interview' ? 'active' : '' }}">
        <p>{{ $statusCounts['interview'] }}</p>
        <small>Interview</small>
    </a>
    <a href="{{ route('pipelines.index', ['status' => 'offer', 'education' => $request->get('education'), 'job_id' => $request->get('job_id')]) }}" class="status-box status-offer {{ $request->get('status') == 'offer' ? 'active' : '' }}">
        <p>{{ $statusCounts['offer'] }}</p>
        <small>Offer</small>
    </a>
    <a href="{{ route('pipelines.index', ['status' => 'accepted', 'education' => $request->get('education'), 'job_id' => $request->get('job_id')]) }}" class="status-box status-accepted {{ $request->get('status') == 'accepted' ? 'active' : '' }}">
        <p>{{ $statusCounts['accepted'] }}</p>
        <small>Accepted</small>
    </a>
    <a href="{{ route('pipelines.index', ['status' => 'bankcv', 'education' => $request->get('education'), 'job_id' => $request->get('job_id')]) }}" class="status-box status-bankcv {{ $request->get('status') == 'bankcv' ? 'active' : '' }}">
        <p>{{ $statusCounts['bankcv'] }}</p>
        <small>Bank CV</small>
    </a>
</div>





</div>
@stop



@section('content')
@if(session('success'))
    <div class="alert alert-success mb-0">
        {{ session('success') }}
    </div>
@endif

<div class="row">
    <div class="col-12">
        <div class="card ">
            <div class="card-body pe-3">


                <!-- Search bar and filters -->
                <!-- Filter Button -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <!-- Left side: Filter By and Sort By -->
                    <div class="d-flex align-items-center gap-3">

                    <a href="{{ route('pipelines.create') }}" class="btn btn-primary btn-extended" style="margin-top: -15px;">
                        <i class="fa fa-plus"></i>New Data
                    </a>

                    <!-- <a href="{{ route('export.applicant') }}" class="btn btn-success">Export to Excel</a> -->

       

                    <!-- Upload Form -->
                    <form action="{{ route('import.excel') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center gap-2">
                        @csrf
                        <div class="form-group mb-0">
                            <input type="file" name="file" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </form>


                        <!-- Filter Button -->
                        <button
                            type="button"
                            class="btn btn-primary me-0"
                            data-bs-toggle="modal"
                            data-bs-target="#filterModal"
                            style="min-width: 100px; margin-top: -15px;"
                            onclick="checkFilterConditions()">
                            <i class="fa fa-filter" aria-hidden="true"></i> Filter By
                        </button>

                        <!-- Sorting Dropdown -->
                        <form method="GET" action="{{ route('pipelines.index') }}" class="d-flex align-items-center">
                            <button type="button" class="btn btn-primary me-0 btn-no-animation" style="min-width: 100px;">
                                <i class="fa fa-filter" aria-hidden="true"></i> Sort By
                            </button>
                            <select name="sort" class="form-select ms-0" onchange="this.form.submit()" style="min-width: 150px;">
                                <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Newest to Oldest</option>
                                <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Oldest to Newest</option>
                                <option value="a_to_z" {{ request('sort') === 'a_to_z' ? 'selected' : '' }}>A to Z</option>
                                <option value="z_to_a" {{ request('sort') === 'z_to_a' ? 'selected' : '' }}>Z to A</option>
                            </select>

                            <!-- Menambahkan parameter lain ke URL -->
                            <input type="hidden" name="job_id" value="{{ request('job_id') }}">
                            <input type="hidden" name="status" value="{{ request('status') }}">
                        </form>



                    </div>

                    <div class="pagination">
                        <form method="GET" action="{{ route('pipelines.index') }}">
                            
                            <div class="d-flex flex-start gap-2">
                                <div>
                                    
                                    <select class="form-select" name="pagination" aria-label="Default select example">
                                        <option value="" {{ !request('pagination') ? 'selected' : '' }}>Pagination</option>
                                        <option value="5" {{ request('pagination') == '5' ? 'selected' : '' }}>5</option>
                                        <option value="10" {{ request('pagination') == '10' ? 'selected' : '' }}>10</option>
                                        <option value="50" {{ request('pagination') == '50' ? 'selected' : '' }}>50</option>
                                        <option value="100" {{ request('pagination') == '100' ? 'selected' : '' }}>100</option>
                                        <option value="all" {{ request('pagination') == 'all' ? 'selected' : '' }}>All</option>
                                      </select>    
                                </div>
                                <div>
                                    <button class="btn btn-primary" type="submit">apply</button>
                                </div>                                  
                            </div>
                        </form>
                        
                    </div>


                    <!-- Right side: Search Input -->
                    {{-- <div class="search-bar">
                        <form action="{{ route('pipelines.index') }}" method="GET" class="d-flex align-items-center gap-2">
                            <input type="text" name="search" class="form-control form-control-sm custom-search-input"
                                style="margin-left: 300px;" placeholder="Search..."
                                value="{{ request('search') }}" aria-label="Search Applicant">

                            <input type="hidden" name="job_id" value="{{ request('job_id') }}">
                            <input type="hidden" name="status" value="{{ request('status') }}">

                            <button type="submit" class="btn btn-secondary btn-sm">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div> --}}

                </div>
                <div>
                    @if(request('pagination') == 'all')
                        <h3>Applicant Total : {{ $applicants->count() }}</h3>
                    @else
                    <h3>Applicant Total : {{ $applicants->total() }}</h3>                    
                    @endif                    

                </div>

                <div class="search-bar">
                    <form action="{{ route('pipelines.index') }}" method="GET" class="d-flex align-items-end gap-2">
                        <div>
                            <label for="search">Keyword</label>
                            <input type="text" name="search" class="form-control custom-search-input"
                            style="" placeholder="Search Applicant"
                            value="{{ request('search') }}" aria-label="Search Applicant">
                        </div>
                        <div>
                            <label for="search_by">Search By</label>
                            <select style="width: 150px;" class="form-select" name="search_by" id="">
                                <option value="name" {{ request('search_by') == 'name' ? 'selected' : '' }}>Name</option>
                                <option value="job_name" {{ request('search_by') == 'job_name' ? 'selected' : '' }}>Job</option>
                            </select>
                        </div>
                        <input type="hidden" name="job_id" value="{{ request('job_id') }}">
                        <input type="hidden" name="status" value="{{ request('status') }}">

                        <button type="submit" class="btn btn-secondary btn-sm">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>


                <!-- Modal Filter -->
                <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="filterModalLabel">Filter Options</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('pipelines.index') }}" method="GET">
                                    <!-- Filter by Job ID (Hidden Field) -->
                                    <input type="hidden" name="job_id" value="">


                                    <!-- Filter by Education -->
                                    <div class="mb-3">
                                        <label for="education-dropdown" class="form-label">Education</label>
                                        <select name="education" class="form-select" id="education-dropdown">
                                            <option value="">Select Education</option>
                                            @foreach($educations as $education)
                                            <option value="{{ $education->id }}" {{ $request->get('education') == $education->id ? 'selected' : '' }}>
                                                {{ $education->name_education }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Filter by Major -->
                                    <div class="mb-3">
                                        <label for="jurusan-dropdown" class="form-label">Major</label>
                                        <select name="jurusan" class="form-select" id="jurusan-dropdown">
                                            <option value="">Select Major</option>
                                            @foreach($jurusans as $jurusan)
                                            <option value="{{ $jurusan->id }}" data-education-id="{{ $jurusan->education_id }}" {{ $request->get('jurusan') == $jurusan->id ? 'selected' : '' }}>
                                                {{ $jurusan->name_jurusan }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Filter by Recommendation -->
                                    <div class="mb-3">
                                        <label for="recommendation-dropdown" class="form-label">Recommendation</label>
                                        <select name="recommendation" class="form-select" id="recommendation-dropdown">
                                            <option value="">Select Recommendation</option>
                                            <option value="recommended" {{ request('recommendation') == 'recommended' ? 'selected' : '' }}>Recommended</option>
                                            <option value="not_recommended" {{ request('recommendation') == 'not_recommended' ? 'selected' : '' }}>Not Recommended</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="recommendation-dropdown" class="form-label">Job Position</label>
                                        <select name="job_filter" class="form-select" id="recommendation-dropdown">
                                            <option value="">Select job</option>
                                            @foreach ($jobs as $item)
                                                <option value="{{ $item->id }}" {{ request('job_filter') == $item->job_name ? 'selected' : '' }} >{{ $item->job_name }}</option>
                                            @endforeach
                                            {{-- <option value="recommended" {{ request('recommendation') == 'recommended' ? 'selected' : '' }}>Recommended</option>
                                            <option value="not_recommended" {{ request('recommendation') == 'not_recommended' ? 'selected' : '' }}>Not Recommended</option> --}}
                                        </select>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Apply Filters</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="table-wrapper">
                    <table class="table table-hover table-bordered table-striped" id="example2">
                        <thead>
                            <tr class="blue-gradient">
                                <th>No.</th>
                                <th>
                                    <span>Input Time</span>
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}"
                                    style="text-decoration: none; color: white;">
                                        &#9650;
                                    </a>
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'oldest']) }}"
                                    style="text-decoration: none; color: white;">
                                        &#9660;
                                    </a>
                                </th>
                                <th>
                                    <span>Name</span>
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'name_asc']) }}"
                                    style="text-decoration: none; color: white;">
                                        &#9650;
                                    </a>
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'name_desc']) }}"
                                    style="text-decoration: none; color: white;">
                                        &#9660;
                                    </a>
                                </th>
                                <th>
                                    <span>Education</span>
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'job_asc']) }}"
                                    style="text-decoration: none; color: white;">
                                        &#9650;
                                    </a>
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'job_desc']) }}"
                                    style="text-decoration: none; color: white;">
                                        &#9660;
                                    </a>
                                </th>
                                <th>                    
                                    <span>Job</span>
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'job_asc']) }}"
                                    style="text-decoration: none; color: white;">
                                        &#9650;
                                    </a>
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'job_desc']) }}"
                                    style="text-decoration: none; color: white;">
                                        &#9660;
                                    </a>
                                </th>

                                 @if(request('status') === 'offer')
                                    <th></th>
                                @endif

                                <th>
                                    <span>Move Stage</span>
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'status_asc']) }}"
                                    style="text-decoration: none; color: white;">
                                        &#9650;
                                    </a>
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'status_desc']) }}"
                                    style="text-decoration: none; color: white;">
                                        &#9660;
                                    </a>
                                </th>
                                <th></th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($applicants as $key => $applicant)
                            @if ( $applicant->type !== 'resindo')
                                <tr>
                                    {{-- <td>{{ $key + $applicants->firstItem() }}</td> --}}
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                       <div class="">
                                            <span>{{ \Carbon\Carbon::parse($applicant->created_at)->locale('id')->translatedFormat('l, d F Y') }}</span>
                                            |
                                            <span>{{ \Carbon\Carbon::parse($applicant->created_at)->format('H:i') }}</span>
                                       </div>
                                    </td>
                                    <td>
                                        <div style="display: flex; align-items: center; cursor: pointer;" onclick="showApplicantInfo({{ json_encode($applicant) }})">
                                            @if($applicant->photo_pass)
                                            <img src="{{ asset('storage/' . $applicant->photo_pass) }}" alt="Applicant Photo" style="width: 50px; height: 50px; object-fit: cover; margin-right: 10px;">
                                            @else
                                            <span style="width: 50px; height: 50px; display: inline-block; background-color: #f0f0f0; margin-right: 10px; border-radius: 50%;"></span>
                                            @endif
                                            <span>{{ $applicant->name }}</span>
                                        </div>
                                    </td>
                                    <td style="width: 180px;">{{ $applicant->education->name_education }} - {{ $applicant->jurusan->name_jurusan }}</td>
                                    <td>{{ $applicant->job->job_name }}</td>

                                  @if(request('status') === 'offer')
                                    @if($applicant->status === 'offer')
                                        <td>
                                            @if($applicant->offerLetter)
                                                {{-- Sudah ada offer letter --}}
                                                <a href="{{ route('offer_letters.show', $applicant->offerLetter->id) }}" 
                                                class="btn btn-sm btn-info">
                                                    View Offering Letter
                                                </a>
                                            @else
                                                {{-- Belum ada, tampilkan tombol create --}}
                                                <a href="{{ route('offer_letters.create', $applicant->id) }}" 
                                                class="btn btn-sm btn-warning">
                                                    Create Offering Letter
                                                </a>
                                            @endif
                                        </td>
                                    @else
                                        <td></td>
                                    @endif
                                @endif

                                    <td class="pipeline_stage">
                                        <div>
                                            <form action="{{ route('applicants.updateStatus', $applicant->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('PUT')
                                                <div class="dropdown">
                                                    <button class="btn btn-white dropdown-toggle btn-fixed-width" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        {{ ucfirst($applicant->status) ?: 'Pilih Status' }}
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <button type="submit" name="status" value="applied" class="dropdown-item">Applicant</button>
                                                        <button type="submit" name="status" value="interview" class="dropdown-item">Interview</button>
                                                        <button type="submit" name="status" value="offer" class="dropdown-item">Offer</button>
                                                        <button type="submit" name="status" value="accepted" class="dropdown-item">Accepted</button>
                                                        <!-- <button type="submit" name="status" value="rejected" class="dropdown-item">Rejected</button> -->
                                                        <button type="submit" name="status" value="bankcv" class="dropdown-item">Bank CV</button>

                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </td>
                                    
                                    <td>
                                        <div class="recommendation-remark" onclick="toggleDropdown(this)" style="position: relative;">
                                            <span class="selected-option" style="color: white; background-color: <?php echo $applicant->recommendation_status === 'recommended' ? 'green' : 'orange'; ?>;">
                                                <?php echo ucfirst(str_replace('_', ' ', $applicant->recommendation_status)); ?>
                                            </span>
                                            <div class="options" style="display: none; position: absolute; top: 100%; left: 0; right: 0; z-index: 1000;">
                                                <div class="option" data-value="recommended" onclick="updateRecommendation(this, <?php echo $applicant->id; ?>)" style="background-color: white; color: black;">
                                                    Recommended
                                                </div>
                                                <div class="option" data-value="not_recommended" onclick="updateRecommendation(this, <?php echo $applicant->id; ?>)" style="background-color: white; color: black;">
                                                    Not Recommended
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    
                                                                
                                    <td>
                                        <div class="action-icons">
                                            <!-- Edit button -->
                                            <a href="{{ route('pipelines.edit', $applicant->id) }}" class="action-icon" title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            <!-- Delete button -->
                                            <a href="#" class="action-icon"
                                                onclick="event.preventDefault(); 
                                                if (confirm('Are you sure you want to delete this item?')) {
                                                    document.getElementById('delete-form-{{ $applicant->id }}').submit();
                                                }" title="Delete">
                                                <i class="fa fa-trash"></i>
                                            </a>

                                            <!-- Hidden delete form -->
                                            <form id="delete-form-{{ $applicant->id }}" action="{{ route('pipelines.destroy', $applicant) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                    @if(request('pagination') != 'all')
                        <div class="d-flex justify-content-center">
                            {{ $applicants->links('pagination::bootstrap-4', ['class' => 'pagination-sm']) }}
                        </div>
                    @endif()
                </div>
        </div>
    </div>
</div>
</div>
<!-- Modal for applicant information -->
<div class="modal fade" id="applicantInfoModal" tabindex="-1" role="dialog" aria-labelledby="applicantInfoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #007bff, #0056b3);">
                <h5 class="modal-title" id="applicantInfoModalLabel">Applicant Information</h5>
                <!-- Close button for Bootstrap 5 -->
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <img id="applicant-photo" src="" alt="Applicant Photo" class="img-fluid rounded" style="width: 200px; height: 300px;">
                    </div>
                    <div class="col-md-8">
                        <h5 id="applicant-name"></h5>
                        <p><strong>Email:</strong> <span id="applicant-email"></span></p>
                        <p><strong>Phone:</strong> <span id="applicant-number"></span></p>
                        <p><strong>Address:</strong> <span id="applicant-address"></span></p>
                        <p><strong>Job:</strong> <span id="applicant-job"></span></p>
                        <!-- <p><strong>Skills:</strong> <span id="applicant-skills"></span></p> -->
                        <p><strong>Salary Expectation:</strong> Rp.<span id="applicant-salary"></span></p>
                        <textarea id="applicant-notes" placeholder="Add notes here..." style="width: 100%; height: 100px;" disabled></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="save-notes-button" onclick="saveNotes()" class="btn btn-primary">Save Notes</button>
                <button id="edit-notes-button" onclick="editNotes()" class="btn btn-secondary" style="display: none;">Edit</button>
                <button onclick="deleteNotes()" class="btn btn-danger">Delete Notes</button>
                <a id="download-cv" href="#" class="btn btn-success">Download CV</a>
                <a id="download-cv2" href="#" class="btn btn-success">Download CV RESINDO</a>
                <a id="download-summary" href="#" class="btn btn-success">Download SUMMARY RESINDO</a>
                 <!-- @if($applicant->status === 'offer')
                <a href="{{ route('offer_letters.create', $applicant->id) }}" class="btn btn-warning">
                    Create Offering Letter
                </a>
                @endif -->
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

            </div>

        </div>
    </div>
</div>

@stop

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/applicant.index.css') }}">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


@push('js')
<script>
    $(document).ready(function() {
        $('#example2').DataTable({
            "responsive": true,
        });

        $('#applicantInfoModal').on('hidden.bs.modal', function() {
            $('#applicant-notes').prop('disabled', true);
            $('#save-notes-button').hide();
            $('#edit-notes-button').show();
        });
    });

    let currentApplicantId = null;

    function showApplicantInfo(applicant) {

        let formatted_salary = new Intl.NumberFormat('id-ID').format(applicant.salary_expectation);
        $('#applicant-photo').attr('src', applicant.photo_pass ? "{{ asset('storage/') }}/" + applicant.photo_pass : 'https://via.placeholder.com/100');
        $('#applicant-name').text(applicant.name);
        $('#applicant-email').text(applicant.email);
        $('#applicant-number').text(applicant.number);
        $('#applicant-address').text(applicant.address);
        $('#applicant-job').text(applicant.job ? applicant.job.job_name : 'N/A');
        $('#applicant-salary').text(formatted_salary);
        $('#download-cv').attr('href', "{{ url('/pipelines') }}/" + applicant.id + "/pdf").attr('target', '_blank');
        $('#download-cv2').attr('href', "{{ url('/pipelines') }}/" + applicant.id + "/pdf2").attr('target', '_blank');
        $('#download-summary').attr('href', "{{ url('/pipelines') }}/" + applicant.id + "/summary").attr('target', '_blank');

        currentApplicantId = applicant.id;


        fetch('/getnotes/' + currentApplicantId)
            .then(response => {
                if (!response.ok) {
                    // throw new Error('ada kesalahan');
                    console.log('error')
                }
                return response.json();
            })
            .then(data => {
                const savedNotes = data.notes;
                const notes = data.notes;
                console.log(notes);
                $('#applicant-notes').val(savedNotes ? savedNotes : '');

                if (savedNotes) {
                    $('#applicant-notes').prop('disabled', true);
                    $('#save-notes-button').hide();
                    $('#edit-notes-button').show();
                } else {
                    $('#applicant-notes').prop('disabled', false);
                    $('#save-notes-button').show();
                    $('#edit-notes-button').hide();
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
            });

        $('#applicantInfoModal').modal('show');
    }



    function saveNotes() {
        if (currentApplicantId) {
            const notes = $('#applicant-notes').val();

            $.ajax({
                url: "{{ route('save.notes') }}",
                type: "POST",
                data: {
                    applicant_id: currentApplicantId,
                    notes: notes,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    alert(response.message);
                    $('#applicant-notes').prop('disabled', true);
                    $('#save-notes-button').hide();
                    $('#edit-notes-button').show();
                },
                error: function(xhr) {
                    console.error(xhr.responseText); // Log the error response for debugging
                    alert('Error saving notes: ' + xhr.statusText);
                }
            });

        }
    }

    function editNotes() {
        $('#applicant-notes').prop('disabled', false);
        $('#edit-notes-button').hide();
        $('#save-notes-button').show();
    }

    function deleteNotes() {
        if (currentApplicantId) {
            $.ajax({
                url: "{{ route('delete.notes') }}",
                type: "POST",
                data: {
                    applicant_id: currentApplicantId,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    alert(response.message);

                    $('#applicant-notes').val('');
                    $('#applicant-notes').prop('disabled', false);
                    $('#save-notes-button').show();
                    $('#edit-notes-button').hide();
                },
                error: function(xhr) {
                    console.error(xhr.responseText); // Log the error response for debugging
                    alert('Error deleting notes: ' + xhr.statusText);
                }
            });
        }
    }
</script>



<script>
    // $(document).ready(function() {

    //     $('#education-dropdown').change(function() {
    //         var selectedEducationId = $(this).val();


    //         $('#jurusan-dropdown option').each(function() {
    //             if ($(this).data('education-id') == selectedEducationId || selectedEducationId == '') {
    //                 $(this).show();
    //             } else {
    //                 $(this).hide();
    //             }
    //         });


    //         if (selectedEducationId == '') {
    //             $('#jurusan-dropdown').val('').change();
    //         }
    //     });
    // });
    $(document).ready(function() {
        $('#jurusan-dropdown option').each(function(){
            $(this).hide();
        })
        $('#education-dropdown').val('');
        $('#jurusan-dropdown').val('');
        $('#recomendation-dropdown').val('');
        $('#education-dropdown').on('change click', function(){
            var selectedEducationId = $(this).val();
                $('#jurusan-dropdown option').each(function() {
                    if ($(this).data('education-id') == selectedEducationId || selectedEducationId == '') {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });


                if (selectedEducationId == '') {
                    $('#jurusan-dropdown').val('').change();
                }
        })
});
</script>
<script>
    $(document).ready(function() {

        $('.filter-stage').click(function() {
            var selectedStage = $(this).data('stage');


            $('.applicant-card').each(function() {
                var applicantStage = $(this).data('stage');

                if (selectedStage === '' || applicantStage === selectedStage) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
    });
</script>


<script>
    function toggleDropdown(element) {
        const options = element.querySelector('.options');
        options.style.display = options.style.display === 'none' ? 'block' : 'none';
    }

    function updateRecommendation(optionElement, applicantId) {
        const recommendation = optionElement.getAttribute('data-value');

        $.ajax({
            url: '{{ route("applicant.recommend") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                recommendation_status: recommendation,
                id: applicantId
            },
            success: function(response) {
                console.log(response.message);
                updateRemarkDisplay(optionElement, recommendation); // Update display
            },
            error: function(xhr) {
                console.error(xhr.responseText);
            }
        });
    }

    function updateRemarkDisplay(optionElement, recommendation) {
        const remark = optionElement.closest('.recommendation-remark');
        const selectedOption = remark.querySelector('.selected-option');

        selectedOption.innerText = optionElement.innerText; // Update displayed text
        selectedOption.style.backgroundColor = recommendation === 'recommended' ? 'green' : 'orange'; // Update background color
        selectedOption.style.color = 'white'; // Update text color
        remark.querySelector('.options').style.display = 'none'; // Hide options after selection
    }
</script>


<script>
    function filterNotRecommended() {
        const applicants = document.querySelectorAll('.applicant');
        applicants.forEach(applicant => {
            if (applicant.getAttribute('data-status') === 'not_recommended') {
                applicant.style.display = 'block'; // Tampilkan yang tidak direkomendasikan
            } else {
                applicant.style.display = 'none'; // Sembunyikan yang direkomendasikan
            }
        });
    }

    function filterRecommended() {
        const applicants = document.querySelectorAll('.applicant');
        applicants.forEach(applicant => {
            if (applicant.getAttribute('data-status') === 'recommended') {
                applicant.style.display = 'block'; // Tampilkan yang direkomendasikan
            } else {
                applicant.style.display = 'none'; // Sembunyikan yang tidak direkomendasikan
            }
        });
    }
</script>

<script>
    function checkFilterConditions() {
        const urlParams = new URLSearchParams(window.location.search);
        const jobId = urlParams.get('job_id');
        const status = urlParams.get('status');

        // Periksa jika ada job_id atau status
        if (jobId || status) {
            if (jobId) {
                document.querySelector('#filterModal [name="job_id"]').value = jobId;
            }
            if (status) {
                document.querySelector('#filterModal [name="status"]').value = status;
            }
        }
    }
</script>





@endpush