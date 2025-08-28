@extends('adminlte::page')

@section('title', 'List Major')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0 text-dark">
        <b> List Major {{isset($educationFilter) ? "in ".$educationFilter->name_education : ''}}
        </b>
    </h1>
</div>
@stop



@section('content')
<div class="row">
    <div class="col-12">
        <div class="card overflow-scroll">
            <div class="card-body pe-3">

                <div class="mb-3">
                <form action="{{ route('jurusan.index') }}" method="GET" class="row g-2 align-items-end">
                    <div class="col-md-4">
                        <label for="search" class="form-label">Keyword</label>
                        <input 
                            type="text" 
                            name="search" 
                            id="search" 
                            class="form-control" 
                            placeholder="Search Jurusan..." 
                            value="{{ request()->get('search') }}">
                    </div>

                    <div class="col-md-2">
                        <label for="search_by" class="form-label">Search by</label>
                        <select class="form-control" name="search_by" id="search_by">
                            <option value="education" {{ request()->get('search_by') == 'name_education' ? 'selected' : '' }}>Education</option>
                            <option value="name_jurusan" {{ request()->get('search_by') == 'name_jurusan' ? 'selected' : '' }}>Major</option>
                        </select>
                    </div>

                    <div class="col-md-1 d-flex">
                        <button type="submit" class="btn btn-outline-secondary mt-auto w-100">
                            <i class="fas fa-search"></i> Search
                        </button>
                    </div>
                </form>
    

                <div class="d-flex justify-content-between align-items-center mb-2">
                    {{-- @if(isset($jurusanFilter))
                        <a href="{{ route('educationMajorCreate', $educationFilter->id) }}" class="btn btn-primary">
                            <i class="fa fa-plus"></i> Create Major for {{$educationFilter->name_education}}
                        </a>
                    @else
                        <a href="{{ route('jurusan.create') }}" class="btn btn-primary">
                            <i class="fa fa-plus"></i> Create Major
                        </a>
                    @endif --}}
                </div>
                <!-- Search bar and filters -->

                <div class="table-wrapper">
                    <table class="table table-hover table-bordered table-striped" id="example2">
                        <thead>
                            <tr class="blue-gradient">
                                <th>No.</th>
                                <th>
                                    <span>Major</span>
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'job_asc']) }}"
                                    style="text-decoration: none; color: white;">
                                        &#9650;
                                    </a>
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'job_desc']) }}"
                                    style="text-decoration: none; color: white;">
                                        &#9660;
                                    </a>
                                </th>

                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            
                                
                                @if(@isset($jurusanFilter))
                                {{-- bagian yang filter per education --}}
                                @foreach($jurusanFilter as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->name_jurusan }}</td>
                                    <td>
                                        <a href="{{ route('jurusan.edit', $item->id) }}" class="fa fa-edit btn btn-success btn-xs">
                                            Edit
                                        </a>
                                        <a href="{{route('jurusan.destroy', $item->id)}}" onclick="notificationBeforeDelete(event, this)" class="btn btn-dark btn-xs"><i class="fa fa-trash">
                                                Delete
                                            </i>
                                        </a>
                                    </td>
                                </tr>
                                {{-- bagian yang semuanya  --}}
                                @endforeach
                                @else

                                @foreach($jurusan as $key => $j)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $j->education->name_education }} - {{ $j->name_jurusan }}</td>
                                    <td>
                                        <a href="{{ route('jurusan.edit', $j) }}" class="fa fa-edit btn btn-success btn-xs">
                                            Edit
                                        </a>
                                        <a href="{{route('jurusan.destroy', $j)}}" onclick="notificationBeforeDelete(event, this)" class="btn btn-dark btn-xs"><i class="fa fa-trash">
                                                Delete
                                            </i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach

                                @endif

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

<link rel="stylesheet" href="{{ asset('css/applicant.index.css') }}">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@push('js')

<form action="" id="delete-form" method="post">
    @method('delete')
    @csrf
</form>
<script>
    $('#example2').DataTable({
        "responsive": true,
    });

    function notificationBeforeDelete(event, el) {
        event.preventDefault();
        if (confirm('Apakah anda yakin akan menghapus data Jurusan ? ')) {
            $("#delete-form").attr('action', $(el).attr('href'));
            $("#delete-form").submit();
        }
    }
</script>

@endpush