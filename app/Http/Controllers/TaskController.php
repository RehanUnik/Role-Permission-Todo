<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search ?? "";
        $user = Auth::user();
        $users = User::all();
        $projects = Project::all();

        if ($user->roles->contains('name', 'projectmanager')) {

            $todos = Task::where('status', '=', 'todo')->get();
            $inprogress = Task::where('status', '=', 'inprogress')->get();
            $complete = Task::where('status', '=', 'complete')->get();
            $verified = Task::where('status', '=', 'verified')->get();
            $modification = Task::where('status', '=', 'modification')->get();

            return view('tasks.tasks', compact('todos', 'users', 'projects', 'inprogress', 'complete', 'verified', 'modification'));
        } else {
            $todos = Task::where('assign_to', $user->id)->where('status', '=', 'todo')->get();
            $inprogress = Task::where('assign_to', $user->id)->where('status', '=', 'inprogress')->get();
            $complete = Task::where('assign_to', $user->id)->where('status', '=', 'complete')->get();

            return view('tasks.tasks', compact('todos', 'users', 'projects', 'inprogress', 'complete'));
        }
    }

    public function create()
    {
        $projects = Project::all();
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'developer');
        })->get();
        return view('tasks.create', compact('projects', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:3',
            'developer_id' => 'required',
            'project_id' => 'required',
            'description' => 'required',
            "images" => "required",
            "images.*" => "required|image|mimes:jpg,jpeg,png,gif"
        ]);

        $imageData = [];
        if ($request->file('images')) {
            $files = $request->file('images');
            foreach ($files as $file) {
                $imageName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path() . '/task_images', $imageName);
                $imageData[] = $imageName;
            }
        }
        $images = json_encode($imageData);

        Task::create([
            'project_id' => $request->project_id,
            'assign_to' => $request->developer_id,
            'title' => $request->title,
            'description' => $request->description,
            'images' => $images,
        ]);

        return redirect()->route('tasks')->with('success', 'Task Created');
    }

    public function images($id)
    {
        $image = Task::find($id);
        $image = json_decode($image->images);
        return view('tasks.images', ['images' => $image, 'id' => $id]);
    }

    public function updateImage(Request $request, $id)
    {
        $request->validate([
            "images" => "required",
            "images.*" => "required|image|mimes:jpg,jpeg,png,gif"
        ]);

        $imageData = [];
        if ($request->file('images')) {
            $files = $request->file('images');
            foreach ($files as $file) {
                $imageName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path() . '/task_images', $imageName);
                $imageData[] = $imageName;
            }
        }

        $existingImage = Task::find($id);

        if ($existingImage) {

            $mergedImages = array_merge(json_decode($existingImage->images, true), $imageData);
            $updatedImages = json_encode($mergedImages);


            $existingImage->update([
                'images' => $updatedImages
            ]);

            return redirect()->back()->with('success', 'Data has been successfully updated!');
        }

        return redirect()->back()->with('error', 'Image not found!');
    }

    public function destroyImage($id, $imageName)
    {
        $image = Task::find($id);

        if ($image) {
            $imagePath = public_path('task_images/' . $imageName);

            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }

            // Remove the image name from the JSON-encoded array
            $imageData = json_decode($image->images, true);
            $imageData = array_diff($imageData, [$imageName]);
            $image->images = json_encode(array_values($imageData));
            $image->save();

            return redirect()->back()->with('success', 'Image has been successfully deleted!');
        }

        return redirect()->back()->with('error', 'Image not found!');
    }

    public function edit($id)
    {
        $task = Task::find($id);
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'developer');
        })->get();
        $projects = Project::all();
        return view('tasks.edit', compact('task', 'users', 'projects'));
    }

    public function update(Request $request, $id)
    {
        $task = Task::find($id);
        $request->validate([
            'title' => 'required|min:3',
            'developer_id' => 'required',
            'project_id' => 'required',
            'description' => 'required',
        ]);

        $task->project_id = $request->project_id;
        $task->assign_to = $request->developer_id;
        $task->title = $request->title;
        $task->description = $request->description;
        $result = $task->update();

        if ($result) {
        }
        return redirect('tasks')->with('success', 'Data has been successfully updated!');
    }

    public function getDevelopersByProject($projectId)
    {
        // Fetch developers assigned to the selected project
        $developers = User::whereHas('projects', function ($query) use ($projectId) {
            $query->where('project_id', $projectId);
        })->get();

        return response()->json($developers);
    }

    public function statusupdate(Request $request)
    {
        $task = Task::where('id', $request->id)->first();
        $oldStatus = $task->status;
        if (!$task) {
            return response()->json([
                'status' => 0,
                'error' => 'Task Not Found!'
            ], 404);
        }

        if ($task->status != $request->status) {
            Log::info('Requested Status: ' . $request->status);
            $task->status = $request->status;

            try {
                $result = $task->save();
                Log::info('Save Result: ' . $result);
            } catch (\Exception $e) {
                Log::error('Exception: ' . $e->getMessage());
                return response()->json([
                    'status' => 0,
                    'error' => 'Internal server error'
                ], 500);
            }

            if ($result && $oldStatus != $request->status) {
                TaskStatus::create([
                    'task_id' => $request->id,
                    'to_status' => $oldStatus,
                    'status_change_date' => Carbon::now(),
                    'from_status' => $request->status,
                    'modify_user_id' => Auth::user()->id,
                ]);
                return response()->json([
                    'status' => 1,
                    'success' => 'Status updated'
                ], 200);
            } else {
                return response()->json([
                    'status' => 0,
                    'error' => 'Internal server error'
                ], 500);
            }
        }
    }
}
