<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Section;
use App\Models\Spec;
use App\Models\Task;
use App\Models\Thread;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ForumController extends Controller
{
    public function createSection(Request $request) {

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:1|max:255',
            'project' => 'required|exists:projects,id'
        ]);

        if ($validator->fails()) {
            return new JsonResponse(['error' => 'error']);
        }

        $project = Project::find($request->project);

        $section = new Section;
        $section->name = $request->name;
        $section->project()->associate($project);
        $section->save();

//        $project->sections()->save($section);

        return redirect(route('index'));
    }

    public function createTask(Request $request) {

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:1|max:255',
            'start' => 'required|date',
            'end' => 'required|date',
            'spec' => 'required|exists:specs,id',
            'section' => 'required|exists:sections,id'
        ]);

        if ($validator->fails()) {
            return new JsonResponse(['error' => $validator->errors()->all()]);
        }

        $section = Section::find($request->section);

        $task = new Task;
        $task->name = $request->name;
        $task->start = $request->start;
        $task->end = $request->end;
        $task->spec()->associate(Spec::find($request->spec));
        $task->section()->associate($section);
        $task->save();

//        $section->tasks()->save($section);

        return redirect(route('index'));
    }

    public function createThread(Request $request) {
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:1|max:255',
            'text' => 'required',
            'type' => 'required',
            'task' => 'required|exists:tasks,id'
        ]);

        if ($validator->fails()) {
            return new JsonResponse(['error' => $validator->errors()->all()]);
        }

        $task = Task::find($request->task);

        $thread = new Thread;
        $thread->title = $request->title;
        $thread->text = $request->text;
        $thread->type = $request->type;
        $thread->task()->associate($task);
        $thread->user()->associate(Auth::user());
        $thread->save();

//        $section->tasks()->save($section);

        return redirect(route('index'));
    }

}
