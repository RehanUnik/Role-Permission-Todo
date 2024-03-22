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
                    <div class="d-flex justify-content-center">
                        <div class="col-md-6 ">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Create Role</h4>
                                    <form class="mt-2" action=" {{ route('addrole') }} " method="post">
                                        @csrf
                                        <div class="form-group">
                                            <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Role</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="role" placeholder="Enter role name" name="name">
                                                @if($errors->has('name'))
                                                <p class="text-danger">{{$errors->first('name')}}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-outline-dark ml-2">Submit</button>
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