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
                        <div class="col-md-6 ">
                            <div class="card">
                                <div class="card-body">
                                    <form action="{{ route('addtask') }}" class="mt-2" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="form3Example5">Tile</label>
                                            <input type="text" id="form3Example5" class="form-control form-control-lg" placeholder="Enter title" name="title" value="{{ old('title') }}" />
                                            @if($errors->has('title'))
                                            <p class="text-danger">{{$errors->first('title')}}</p>
                                            @endif
                                        </div>


                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="form3Example3">Description</label>
                                            <textarea id="description" name="description" class="form-control form-control-lg" placeholder="Enter Description" value="{{ old('description') }}"></textarea>
                                            @if($errors->has('description'))
                                            <p class="text-danger">{{$errors->first('description')}}</p>
                                            @endif
                                        </div>

                                        <div class="form-outline mb-4">

                                            <div class="row gx-5">
                                                <div class="col">
                                                    <div class=""><label for="project">Select Project:</label>
                                                        <select id="project" name="project_id">
                                                            <option value="">Please select</option>
                                                            @foreach($projects as $project)
                                                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @if($errors->has('project_id'))
                                                        <p class="text-danger">{{$errors->first('project_id')}}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class=""> <label for="developer">Select Developer:</label>
                                                        <select id="developer" name="developer_id">
                                                            <option value="">Please select</option>

                                                        </select>
                                                        @if($errors->has('developer_id'))
                                                        <p class="text-danger">{{$errors->first('developer_id')}}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="form-outline mb-3">
                                            <label class="form-label" for="form3Example4">Images</label>
                                            <input type="file" id="images" name="images[]" accept="image/*" multiple>
                                            @if($errors->has('images'))
                                            <p class="text-danger">{{$errors->first('images')}}</p>
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
    <script>
        $(document).ready(function() {

            var projectSelect = $('#project');
            var developerSelect = $('#developer');


            projectSelect.change(function() {
                var projectId = $(this).val();


                developerSelect.empty();


                if (projectId) {

                    $.ajax({
                        url: "{{url( 'getDevelopersByProject')}}/" + projectId,
                        type: 'GET',
                        success: function(data) {

                            developerSelect.append('<option value=""> Please Select </option>');
                            $.each(data, function(index, user) {
                                developerSelect.append('<option value="' + user.id + '">' + user.name + '</option>');
                            });
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>