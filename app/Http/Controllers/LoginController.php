<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\Project;
use App\Models\Spec;
use App\Models\User;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{

    private function formOptions() {
        return ['specs' => Spec::all(), 'projects' => Project::all()];
    }

    public function register(Request $request, Hasher $hasher) {
        if ($request->method() == 'GET') {
            return view('register', $this->formOptions());
        }
        $messages = [
            'name.required' => 'Поле "Имя" должно быть зполнено',
            'surname.required' => 'Поле "Фамилия" должно быть зполнено',
            'spec.required' => 'Поле "Специализация" должно быть зполнено',
            'project.required' => 'Поле "Проект" должно быть зполнено',
            'email.required' => 'Поле "Email" должно быть зполнено',
            'password.required' => 'Поле "Пароль" должно быть зполнено'
        ];
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:1|max:255',
            'surname' => 'required|min:1|max:255',
            'spec' => 'required|exists:specs,id',
            'project' => 'required|exists:projects,id',
            'email' => 'required|unique:users|max:255',
            'password' => 'required|min:3|max:4096',
            'photo' => 'required'
        ], $messages);

        if ($validator->fails()) {
            $request->flash();
            return view('register', $this->formOptions())
                ->withErrors($validator);
        }
        $user = new User;
        $user->name = $request->name;
        $user->surname = $request->surname;
        $user->email = $request->email;
        $user->password = $hasher->make($request->password);
        $user->photo = $request->file('photo')->store('photos');

        $user->project()->associate(Project::find($request->project));
        $user->spec()->associate(Spec::find($request->spec));

        $user->save();

        Auth::login($user);

        return redirect(route('index'));
    }


    public function login(Request $request) {
        if ($request->method() == 'GET') {
            return view('login');
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended(route('index'));
        }

        return view('login', ['errors' => ['Неправильное имя пользователя или пароль']]);
    }

    public function logout(Request $request) {
        Auth::logout();
        return redirect(route('index'));
    }

}
