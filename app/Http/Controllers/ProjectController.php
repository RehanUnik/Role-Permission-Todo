<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use App\Models\UserProject;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search ?? "";
        $users = User::all();
        $userProjects = UserProject::all();
        if ($search != "") {
            $projects = Project::where('name', 'LIKE', "%$search%")->paginate(5);
            return view('projects.projects', compact('projects', 'users', 'userProjects'));
        }
        $projects = Project::paginate(5);
        return view('projects.projects', compact('projects', 'users', 'userProjects'));
    }

    public function create()
    {

        return view('projects.create');
    }

    public function store(Request $request)
    {

        // Validate the form data
        $request->validate([
            'name' => 'required|string|unique:projects',
            'image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'user_emails' => 'required|string', // Assuming a comma-separated string of user emails
        ]);

        $userEmails = explode(',', $request->input('user_emails'));
        $userEmails = array_map('trim', $userEmails);

        // Attach the project to selected users
        $invalidEmails = [];
        $developerEmails = [];
        $projectManagerEmails = [];
        $dvEmails = [];

        foreach ($userEmails as $email) {
            try {
                $user = User::where('email', $email)->firstOrFail();

                if ($user->roles->contains('name', 'projectmanager')) {
                    $projectManagerEmails[] = $email;
                } elseif ($user->roles->contains('name', 'developer')) {
                    $developerEmails[] = $user;
                } else {
                    $dvEmails[] = $email;
                }
            } catch (ModelNotFoundException $e) {
                $invalidEmails[] = $email;
            }
        }

        if (!empty($invalidEmails)) {
            $errorMessage = 'Users not found with the following email(s): ' . implode(', ', $invalidEmails);
            return redirect()->route('createproject')->with('error', $errorMessage);
        }

        if (!empty($projectManagerEmails)) {
            $errorMessage = 'Project Managers cannot be assigned to projects: ' . implode(', ', $projectManagerEmails);
            return redirect()->route('createproject')->with('error', $errorMessage);
        }

        if (!empty($dvEmails)) {
            $errorMessage = 'Developers not found for the following email(s): ' . implode(', ', $dvEmails);
            return redirect()->route('createproject')->with('error', $errorMessage);
        }


        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('project_images'), $imageName);

        // Store the project
        $project = Project::create([
            'name' => $request->name,
            'image' => $imageName,
        ]);

        foreach ($developerEmails as $user) {
            UserProject::create([
                'user_id' => $user->id,
                'project_id' => $project->id,
            ]);
        }

        return redirect()->route('projects')->with('success', 'Project created successfully!');
    }

    public function edit($id)
    {
        $project = Project::find($id);
        $users = User::all();
        $userProjects = UserProject::where('project_id', $id)->get();

        return view('projects.edit', compact('project', 'users', 'userProjects'));
    }

    public function update(Request $request, $projectId)
    {
        // Validate the form data
        $request->validate([
            'name' => 'required|string|unique:projects,name,' . $projectId,
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'user_emails' => 'required|string', // Assuming a comma-separated string of user emails
        ]);

        $userEmails = explode(',', $request->input('user_emails'));
        $userEmails = array_map('trim', $userEmails);

        // Attach the project to selected users
        $invalidEmails = [];
        $developerEmails = [];
        $projectManagerEmails = [];
        $dvEmails = [];

        foreach ($userEmails as $email) {
            try {
                $user = User::where('email', $email)->firstOrFail();

                if ($user->roles->contains('name', 'projectmanager')) {
                    $projectManagerEmails[] = $email;
                } elseif ($user->roles->contains('name', 'developer')) {
                    $developerEmails[] = $user;
                } else {
                    $dvEmails[] = $email;
                }
            } catch (ModelNotFoundException $e) {
                $invalidEmails[] = $email;
            }
        }

        if (!empty($invalidEmails)) {
            $errorMessage = 'Users not found with the following email(s): ' . implode(', ', $invalidEmails);
            return redirect()->back()->with('error', $errorMessage);
        }

        if (!empty($projectManagerEmails)) {
            $errorMessage = 'Project Managers cannot be assigned to projects: ' . implode(', ', $projectManagerEmails);
            return redirect()->back()->with('error', $errorMessage);
        }

        if (!empty($dvEmails)) {
            $errorMessage = 'Developers not found for the following email(s): ' . implode(', ', $dvEmails);
            return redirect()->back()->with('error', $errorMessage);
        }

        $project = Project::findOrFail($projectId);
        $project->name = $request->name;

        if ($request->hasFile('image')) {
            if ($project->image) {
                $imagePath = public_path('project_images/' . $project->image);
                File::delete($imagePath);
            }
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('project_images'), $imageName);
            $project->image = $imageName;
        }

        $project->save();

        $project->users()->sync(collect($developerEmails)->pluck('id')->all());


        return redirect()->route('projects')->with('success', 'Project updated successfully!');
    }
}
