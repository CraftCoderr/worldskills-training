<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class MainController extends Controller
{

    public function index() {

        return view('index', ['projects' => Project::all()]);
    }

}
