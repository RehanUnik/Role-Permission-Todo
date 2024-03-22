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
                                    <h4 class="card-title">Edit User</h4>
                                    <form action="{{ url('userupdate/'.$user->id) }}" method="post">
                                        @csrf
                                        @method('put')
                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="form3Example5">Name</label>
                                            <input type="text" id="form3Example5" class="form-control form-control-lg" placeholder="Enter name" name="name" value="{{ $user->name }}" />
                                            @if($errors->has('name'))
                                            <p class="text-danger">{{$errors->first('name')}}</p>
                                            @endif
                                        </div>

                                        <!-- Email input -->
                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="form3Example3">Email address</label>
                                            <input type="email" id="form3Example3" class="form-control form-control-lg" placeholder="Enter a valid email address" name="email" value="{{ $user->email }}" />
                                            @if($errors->has('email'))
                                            <p class="text-danger">{{$errors->first('email')}}</p>
                                            @endif
                                        </div>

                                        <!-- Password input -->
                                        <div class="form-outline mb-3">
                                            <label class="form-label" for="form3Example4">Password</label>
                                            <input type="password" id="form3Example4" class="form-control form-control-lg" placeholder="Enter password" name="password" />
                                            @if($errors->has('password'))
                                            <p class="text-danger">{{$errors->first('password')}}</p>
                                            @endif
                                        </div>

                                        <div class="form-outline mb-3">
                                            <label class="form-label" for="form3Example6">Confirm Password</label>
                                            <input type="password" id="form3Example6" class="form-control form-control-lg" placeholder="Confirm password" name="password_confirmation" />
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Role</label> <br>

                                            @foreach($allRoles as $role)
                                            <input type="checkbox" class="mr-2" name="roles[]" value="{{ $role->name }}" {{ in_array($role->id, $userRoles->pluck('id')->toArray()) ? 'checked' : '' }}>{{ $role->name }} <br>
                                            @endforeach


                                        </div>

                                        <div class="text-center text-lg-start mt-4 pt-2 res-pos div-tab">
                                            <button type="submit" class="btn btn-outline-primary">Update</button>
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