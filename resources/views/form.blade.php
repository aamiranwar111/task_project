@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Task</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('tasks.update') }}">
                        @csrf
                        <input type="hidden" name="id" value="{{$task->id}}">
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{$task->name}}" required autocomplete="name" autofocus>
                            </div>
                            
                        </div>
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">Select Project</label>
                            <div class="col-md-6">
                                <select name="project_id"  class="form-control" placeholder="Select Project" data-placeholder="Select Project" required>
                                    @foreach($projects as $key => $row)
                                        <option value="{{$row->id}}" {{$task->project_id == $row->id ? 'selected' : ''}}>{{$row->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                       

                        
                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ $task->id ? 'Update' : 'Save'}}
                                </button>
                                <a class="btn btn-sm btn-primary" href="{{ route('tasks') }}">Cancel</a>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
