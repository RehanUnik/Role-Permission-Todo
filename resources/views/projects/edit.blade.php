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
                                    <h4 class="card-title">Edit Project</h4>
                                    <form action="{{ url('updateproject/'.$project->id) }}" class="mt-2" method="post" enctype="multipart/form-data">
                                        @csrf
                                        @method('put')
                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="form3Example5">Name</label>
                                            <input type="text" id="form3Example5" class="form-control form-control-lg" placeholder="Enter name" name="name" value="{{ $project->name }}" />
                                            @if($errors->has('name'))
                                            <p class="text-danger">{{$errors->first('name')}}</p>
                                            @endif
                                        </div>

                                        <div class="form-outline mb-4">
                                            <div class="row gx-5">
                                                <div class="col">
                                                    <div class="p-3">
                                                        <label for="image">Project Old Image:</label>
                                                        <img src="{{ old('image', asset('project_images/' . $project->image)) }}" alt="ITEM_NAME Image" height="80" width="100">
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="p-3"><label for="image">Project Image:</label>
                                                        <input type="file" name="image">
                                                        @if($errors->has('image'))
                                                        <p class="text-danger">{{$errors->first('image')}}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-outline mb-4">
                                            <label for="user_emails">Assign to Users (comma-separated emails):</label>
                                            @php
                                            $emailArray = [];
                                            @endphp

                                            @foreach($userProjects as $userProject)
                                            @if($userProject->project_id === $project->id)
                                            @php
                                            $emailArray[] = $userProject->user->email;
                                            @endphp
                                            @endif
                                            @endforeach

                                            <input type="text" value="{{ implode(', ', $emailArray) }}" class="form-control form-control-lg" name="user_emails" placeholder="Enter E-mail of developers to assign project">
                                            @if($errors->has('user_emails'))
                                            <p class="text-danger">{{$errors->first('user_emails')}}</p>
                                            @endif
                                        </div>

                                        <div class="text-center text-lg-start mt-4 pt-2 res-pos div-tab">
                                            <button type="submit" class="btn btn-outline-dark">Save</button>
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