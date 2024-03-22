<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Skydash Admin</title>
    @include('csslink')
</head>

<body>
    <div class="container-scroller">
        <x-header />
        <div class="container-fluid page-body-wrapper">
            <x-sidebar />
            <div class="main-panel">
                <div class="content-wrapper">
                    @if(Session::has('success'))
                    <div class="mt-2 alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>{{Session::get('success')}}</strong>
                        <button type="button" class="close" onclick="hidemodal()">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-column flex-md-row">
                                    <div class="p-2 flex-grow-1">
                                        <form action="" class="d-flex justify-content-start flex-column flex-md-row">
                                            <div class="col-md-5">
                                                <input type="search" name="search" placeholder="Search By Project Name" id="" class="form-control">
                                            </div>
                                            <button class="btn btn-outline-info mt-md-0 mt-3">Search</button>
                                        </form>
                                    </div>
                                    <div class="p-2">
                                        <a href="{{ route('createproject') }}" class="btn btn-outline-primary btn-block">Create Project</a>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover text-center mt-2">
                                        <thead>
                                            <tr>
                                                <th>
                                                    Image
                                                </th>
                                                <th>
                                                    Project
                                                </th>
                                                <th>
                                                    Developers
                                                </th>
                                                <th>
                                                    Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($projects as $project)
                                            <tr>
                                                <td><img src="{{ old('image', asset('project_images/' . $project->image)) }}" alt="ITEM_NAME Image" class="rounded-circle mb-3 border border-5 mx-auto" height="50" width="50"></td>
                                                <td>{{$project->name}}</td>
                                                <td>
                                                    @php
                                                    $nameArray = [];
                                                    @endphp

                                                    @foreach($userProjects as $userProject)
                                                    @if($userProject->project_id === $project->id)
                                                    @php
                                                    $nameArray[] = $userProject->user->name;
                                                    @endphp
                                                    @endif
                                                    @endforeach

                                                    {{ implode(', ', $nameArray) }}
                                                </td>
                                                <td>
                                                    <a href=" {{url('projectedit/' . $project->id) }} " class="btn btn-outline-success btn-sm mr-3">Edit</a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-center mt-3">
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination">
                                            <li class="page-item {{ $projects->onFirstPage() ? 'disabled' : '' }}">
                                                <a class="page-link  user-select-none" href="{{ $projects->previousPageUrl() }}">Previous</a>
                                            </li>
                                            @for ($page = 1; $page <= $projects->lastPage(); $page++)
                                                <li class="page-item {{ $page === $projects->currentPage() ? 'active' : '' }}">
                                                    <a class="page-link user-select-none" href="{{ $projects->url($page) }}">{{ $page }}</a>
                                                </li>
                                                @endfor
                                                <li class="page-item {{ $projects->hasMorePages() ? '' : 'disabled' }}">
                                                    <a class="page-link user-select-none" href="{{ $projects->nextPageUrl() }}">Next</a>
                                                </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <x-footersd />


            </div>

        </div>

    </div>
    @include('jslinks')
</body>

</html>