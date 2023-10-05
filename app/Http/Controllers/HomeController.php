<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Project;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $projects = Project::get();
        $tasks = Task::with('project')->orderBy('sort_order')
        ->when($request->project_id,function($q) use($request){
            return $q->where('project_id',$request->project_id);
        })->get();
        return view('task',compact('tasks','projects'));
    }

    public function create(Request $request)
    {
        $task = new Task();
        $projects = Project::get();
        return view('form',compact('task','projects'));
    }

    public function edit(Request $request,$id)
    {
        $task = Task::find($id);
        $projects = Project::get();
        return view('form',compact('task','projects'));
    }
    public function update(Request $request)
    {
        $task = Task::find($request->id);
        $message = 'Record update Successfully';
        if(!$task){
            $task = new Task();
            $message = 'Record saved Successfully';
            $task->sort_order = Task::max('sort_order')+1;
        }
        $task->name = $request->name;
        $task->project_id = $request->project_id;
        $task->save();
        return redirect()->route('tasks')->with('status',$message);
    }
    public function delete(Request $request,$id)
    {
        $task = Task::find($id);
        $task->delete();
        return redirect()->route('tasks')->with('status','Record deleted Successfully');
    }
    public function update_sort(Request $request)
    {
        $task = Task::find($request->id);
        $task->sort_order = $request->to;
        $task->save();

        $tasks = Task::with('project')->orderBy('sort_order')->where('sort_order','>=',$request->to)->whereNotIn('id',[$request->id])->get();
        $sort = $request->to;
        foreach ($tasks as $key => $row) {
             $sort =  $sort + 1;
            $row->sort_order =  $sort ;
            $row->save();
        }
        return response()->json(['status' => true]);
    }
}
