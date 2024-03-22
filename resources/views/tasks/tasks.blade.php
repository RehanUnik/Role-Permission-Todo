<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Skydash Admin</title>

    @include('csslink')
    <style>
        @media (min-width: 768px) and (max-width: 1024px) {
            .col-md-6 {
                -ms-flex: 0 0 50%;
                flex: 0 0 50%;
                max-width: 50%;
            }
        }
    </style>
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
                    <div id="success_message" class="mt-2">
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-12 mt-3 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <h4 class="card-title">To Do Lists</h4>
                                        <a href="{{ route('createtask') }}" class="btn text-primary bg-transparent" style="font-weight: bold; font-size: 16px;padding: 0rem 0rem !important;">
                                            <i class="fa-regular fa-square-plus"></i> To Do
                                        </a>

                                    </div>

                                    <div class="list-wrapper pt-2 swim-lane pr-2" data-status="todo">
                                        <ul class="d-flex flex-column-reverse todo-list todo-list-custom ">
                                            @include('tasks.status.todo')
                                        </ul>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12 mt-3 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">IN Progress Lists</h4>
                                    <div class="list-wrapper pt-2  swim-lane pr-2" data-status="inprogress">
                                        <ul class="d-flex flex-column-reverse todo-list todo-list-custom">
                                            @include('tasks.status.inprogress')
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12 mt-3 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Completed Lists</h4>
                                    <div class="list-wrapper pt-2 swim-lane pr-2" data-status="complete">
                                        <ul class="d-flex flex-column-reverse todo-list todo-list-custom ">
                                            @include('tasks.status.complete')
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if(Auth::user()->roles->contains('name', 'projectmanager'))
                        <div class="col-lg-3 col-md-6 col-sm-12 mt-3 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Modification Lists</h4>
                                    <div class="list-wrapper pt-2 swim-lane pr-2" data-status="modification">
                                        <ul class="d-flex flex-column-reverse todo-list todo-list-custom ">
                                            @include('tasks.status.modification')
                                        </ul>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12 mt-3 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Verified Lists</h4>
                                    <div class="list-wrapper pt-2 swim-lane pr-2" data-status="verified">
                                        <ul class="d-flex flex-column-reverse todo-list todo-list-custom ">
                                            @include('tasks.status.verified')
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <x-footersd />


            </div>

        </div>

    </div>
    @include('jslinks')
    <script src="{{ asset('drag.js') }}"></script>
    <script src="{{ asset('moreless.js') }}"></script>

</body>

</html>