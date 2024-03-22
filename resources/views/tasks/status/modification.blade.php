@foreach($modification as $task)
<li class="task" draggable="true">
    <input type="hidden" name="id" value="{{ $task->id }}" id="id_{{ $task->id }}">
    <div class="card">
        <h4 class="fw-bold">
            @foreach($projects as $project)
            @if($project->id==$task->project_id)
            Project name :- {{$project->name}} @endif @endforeach
        </h4>
        <label class="form-check-label">
            Task name :- {{$task->title}}
        </label>
        <label class="form-check-label">
            @foreach($users as $user)
            @if($user->id==$task->assign_to) Assign To :- {{$user->name}}
            @endif @endforeach
        </label>
        <label class="form-check-label">
            <div class="task-description">
                @if(strlen($task->description) >= 10)
                <span class="truncated-description">{{ Illuminate\Support\Str::limit($task->description, 10) }}</span>
                <span class="full-description" style="display: none;">{{ $task->description }}</span>
                <button class="read-more btn btn-sm btn-link btn-fw">Read More</button>
                <button class="read-less btn btn-sm btn-link btn-fw" style="display: none;">Read Less</button>
                @else
                {{ $task->description }}
                @endif
            </div>
        </label>
        <div class="d-flex flex-row ">
            <a href="{{ url('images/' . $task->id) }}" class="btn btn-outline-light editbtn btn-sm mr-2 ">Edit/View Images</a>
            <a href="{{url('taskedit/' . $task->id) }}" class="btn btn-outline-secondary btn-sm">Edit</a>
        </div>
    </div>

</li>
@endforeach