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
                    @if(Session::has('error'))
                    <div class="mt-2 alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>{{Session::get('error')}}</strong>
                        <button type="button" class="close" onclick="hidemodal()">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                    <div class="d-flex justify-content-center">
                        <div class="col-md-10 ">
                            <div class="card">
                                <div class="card-body">
                                    <form action="{{ url('uploadimg/'.$id) }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        @method('put')
                                        <div class="modal-header">
                                            <h4 class="modal-title">Add Image</h4>
                                        </div>
                                        @if (session('success'))
                                        <div class="alert alert-success">{{ session('success') }}<button type="button" class="close" onclick="hidemodal()">
                                                <span aria-hidden="true">&times;</span>
                                            </button></div>
                                        @endif
                                        <div class="modal-body">
                                            @if($errors->any())
                                            <ul class="alert alert-danger">
                                                @foreach($errors->all() as $error)
                                                <li>{{$error}}</li>
                                                @endforeach
                                            </ul>
                                            @endif
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="Image">Image</label>
                                                            <input type="file" class="form-control" name="images[]" multiple>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-outline-primary add_department" id="add_department">Submit</button>
                                        </div>
                                    </form>
                                    <div class="row">
                                        @foreach($images as $image)
                                        <div class="col-md-4 col-sm-6 mb-3">
                                            <div class="card text-center">
                                                <div class="d-flex justify-content-center align-items-center" style="height: 200px;">
                                                    <img src="{{ asset('task_images/' . $image) }}" alt="" class="card-img-top img-fluid mx-auto" style="max-height: 100%; max-width: 100%; object-fit: contain;">
                                                </div>
                                                <div class="card-body">
                                                    <a href="{{url('deleteimg/' . $id . '/' . $image)}}" onclick="return confirm('Are you sure you want to delete this item?')" class="btn btn-outline-danger btn-block">Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
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