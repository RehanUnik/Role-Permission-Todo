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
                                                <select id="role" name="role" class="btn">
                                                    <option value="">Select Role</option>
                                                    @foreach($roles as $role)
                                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-5">
                                                <input type="search" name="search" placeholder="Search By Name" id="" class="form-control">
                                            </div>
                                            <button class="btn btn-outline-info mt-md-0 mt-3 ">Search</button>
                                        </form>
                                    </div>
                                    <div class="p-2">
                                        <a href="{{ route('createuser') }}" class="btn btn-outline-primary p-3 btn-block">Create User</a>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped text-center">
                                        <thead>
                                            <tr>
                                                <th>
                                                    Name
                                                </th>
                                                <th>
                                                    Email
                                                </th>
                                                <th>
                                                    Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($users as $user)
                                            <tr>
                                                <td>{{$user->name}}</td>
                                                <td>{{$user->email}}</td>
                                                <td>
                                                    <a href=" {{url('useredit/' . $user->id) }} " class="btn btn-outline-success btn-sm mr-3">Edit</a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="d-flex justify-content-center mt-3">
                                        <nav aria-label="Page navigation example">
                                            <ul class="pagination">
                                                <li class="page-item {{ $users->onFirstPage() ? 'disabled' : '' }}">
                                                    <a class="page-link  user-select-none" href="{{ $users->previousPageUrl() }}">Previous</a>
                                                </li>
                                                @for ($page = 1; $page <= $users->lastPage(); $page++)
                                                    <li class="page-item {{ $page === $users->currentPage() ? 'active' : '' }}">
                                                        <a class="page-link user-select-none" href="{{ $users->url($page) }}">{{ $page }}</a>
                                                    </li>
                                                    @endfor
                                                    <li class="page-item {{ $users->hasMorePages() ? '' : 'disabled' }}">
                                                        <a class="page-link user-select-none" href="{{ $users->nextPageUrl() }}">Next</a>
                                                    </li>
                                            </ul>
                                        </nav>
                                    </div>
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