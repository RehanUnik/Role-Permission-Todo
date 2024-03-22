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
                                    <form action="{{ url('updatetask/'.$task->id) }}" class="mt-2" method="post" enctype="multipart/form-data">
                                        @csrf
                                        @method('put')
                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="form3Example5">Tile</label>
                                            <input type="text" id="form3Example5" class="form-control form-control-lg" placeholder="Enter title" name="title" value="{{ $task->title }}" />
                                            @if($errors->has('title'))
                                            <p class="text-danger">{{$errors->first('title')}}</p>
                                            @endif
                                        </div>


                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="form3Example3">Description</label>
                                            <textarea id="description" name="description" class="form-control form-control-lg" placeholder="Enter Description">{{ $task->description }}</textarea>
                                            @if($errors->has('description'))
                                            <p class="text-danger">{{$errors->first('description')}}</p>
                                            @endif
                                        </div>

                                        <div class="form-outline mb-4">
                                            <div class="row gx-5">
                                                <div class="col">
                                                    <div class=""><label for="project">Select Project:</label>
                                                        <select id="project" name="project_id">
                                                            @foreach($projects as $project)
                                                            <option value="{{ $project->id }}" {{ $project->id == $task->project_id ? 'selected' : '' }}>
                                                                {{ $project->name }}
                                                            </option>
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

                                                        </select>
                                                        @if($errors->has('developer_id'))
                                                        <p class="text-danger">{{$errors->first('developer_id')}}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-center text-lg-start mt-4 pt-2 res-pos div-tab">
                                            <button type="submit" class="btn btn-outline-dark">Update</button>
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
            var selectedDeveloperId = <?php echo $task->assign_to  ?>;

            console.log(selectedDeveloperId);


            projectSelect.change(function() {
                var projectId = $(this).val();
                developerSelect.empty();

                if (projectId) {
                    $.ajax({
                        url: "{{ url('getDevelopersByProject') }}/" + projectId,
                        type: 'GET',
                        success: function(data) {
                            $.each(data, function(index, user) {
                                var selected = (user.id == selectedDeveloperId) ? 'selected' : '';
                                developerSelect.append('<option value="' + user.id + '" ' + selected + '>' + user.name + '</option>');
                            });

                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                }
            });

            // Trigger the change event on page load if project is pre-selected
            projectSelect.trigger('change');
        });
    </script>
</body>

</html>