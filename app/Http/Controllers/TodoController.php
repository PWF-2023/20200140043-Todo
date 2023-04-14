<?php

namespace App\Http\Controllers;

use App\Models\Todo;

use Illuminate\Http\Request;
use function Pest\Laravel\get;

class TodoController extends Controller
{
    public function index()
    {
        $todos = Todo::where('user_id',auth()->user()->id)
        ->orderBy('is_complete','asc')
        ->orderBy('created_at','desc')
        ->get();

        return view('todo.index',compact('todos'));
    }

    public function store(Request $request, Todo $todo)
    {
        $request->validate([
            'title' => 'required|max:255',
        ]);

        // // Practical
        // $todo = new Todo;
        // $todo->title = $request->title;
        // $todo->user_id = auth()->user()->id;
        // $todo->save();

        // // Query Builder way
        // DB::table('todos')->insert([
        //     'title' => $request->title,
        //     'user_id' => auth()->user()->id,
        //     'created_at' => now(),
        //     'update_at' => now(),
        // ]);

        // Eloquent Way - Readable

        // $todo = Todo::create([
        //     'title' => ucfirst($request->title),
        //     'user_id' => auth()->user()->id,
        // ]);

        // Eloqvent way - Shortest
        $request->user()->todos()->create($request->all());
        // $request->user()->todos()->create([
        //     'title' => ucfirst($request->title),
        // ]);

        return redirect()->route('todo.index')->with('success', 'Todo create successfully');


    }

    public function create()
    {
        return view('todo.create');
    }

    public function edit()
    {
        return view('todo.edit');
    }
}
