<?php

namespace App\Http\Controllers;

use App\Models\Message;
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

        return redirect(route('index'));
    }

    public function showThread(Request $request, $id) {
        $thread = Thread::find($id);
        if (!$thread) {
            return redirect(route('index'));
        }

        return view('thread', ['thread' => [
            'id' => $thread->id,
            'title' => $thread->title,
            'text' => $thread->text,
            'photo' => $thread->user->photo,
            'name' => $thread->user->fullname(),
            'date' => $thread->created_at
        ]]);
    }

    public function createMessage(Request $request, $id) {
        $thread = Thread::find($id);

        $message = new Message;
        $message->text = $request->text;
        $message->date = new \DateTime();
        $message->thread()->associate($thread);
        $message->user()->associate(Auth::user());
        $message->save();

        return new JsonResponse([
            'id' => $message->id,
            'photo' => $message->user->photo,
            'name' => $message->user->fullname(),
            'text' => $message->text,
            'date' => $message->created_at,
            'changed' => $message->changed,
            'owned' => true
        ]);
    }

    public function updateMessage(Request $request, $id, $msg) {
        $message = Message::find($msg);
        $message->text = $request->text;
        $message->changed = true;
        $message->save();

        return new JsonResponse([
            'id' => $message->id,
            'photo' => $message->user->photo,
            'name' => $message->user->fullname(),
            'text' => $message->text,
            'date' => $message->created_at,
            'changed' => $message->changed,
            'owned' => true
        ]);
    }

    public function loadMessages(Request $request, $id) {
        $thread = Thread::find($id);
        $messages = $thread->messages()->with('user')->get();
        $mapped = [];
        foreach ($messages as $message) {
            $mapped []= [
                'id' => $message->id,
                'photo' => $message->user->photo,
                'name' => $message->user->fullname(),
                'text' => $message->text,
                'date' => $message->created_at,
                'changed' => $message->changed,
                'owned' => ($message->user->id === Auth::user()->id)
            ];
        }
        return new JsonResponse($mapped);
    }

}
