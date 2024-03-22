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
                    <div class="d-flex justify-content-center">
                        <div class="col-md-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    @if(Session::has('error'))
                                    <div class="mt-2 alert alert-danger alert-dismissible fade show" role="alert">
                                        <strong>{{Session::get('error')}}</strong>
                                        <button type="button" class="close" onclick="hidemodal()">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    @endif
                                    <h4 class="card-title">Create Project</h4>
                                    <form action="{{ route('addproject') }}" class="mt-2" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="form3Example5">Name</label>
                                            <input type="text" id="form3Example5" class="form-control form-control-lg" placeholder="Enter Project name" name="name" value="{{ old('name') }}" />
                                            @if($errors->has('name'))
                                            <p class="text-danger">{{$errors->first('name')}}</p>
                                            @endif
                                        </div>

                                        <div class="form-outline mb-4">
                                            <label for="image">Project Image:</label>
                                            <input type="file" name="image">
                                            @if($errors->has('image'))
                                            <p class="text-danger">{{$errors->first('image')}}</p>
                                            @endif
                                        </div>

                                        <div class="form-outline mb-4">
                                            <label for="user_emails">Assign to Users (comma-separated emails):</label>
                                            <input type="text" class="form-control form-control-lg" name="user_emails" placeholder="Enter E-mail of developers to assign project">
                                            @if($errors->has('user_emails'))
                                            <p class="text-danger">{{$errors->first('user_emails')}}</p>
                                            @endif
                                        </div>

                                        <div class="text-center text-lg-start mt-4 pt-2 res-pos div-tab">
                                            <button type="submit" class="btn btn-outline-dark">Add</button>
                                        </div>

                                    </form>
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