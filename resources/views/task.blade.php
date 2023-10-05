@extends('layouts.app')

@section('content')

<style type="text/css">
    .grab {
  cursor: grab;
}

.grabbed {
  box-shadow: 0 0 13px #000;
}

.grabCursor,
.grabCursor * {
  cursor: grabbing !important;
}
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                      <div class="container mt-5">
                        <div class="row mb-3">
                            <label for="name" class="col-md-2 col-form-label text-md-end">Select Project</label>
                            <div class="col-md-8">
                                <form action="" method="get" id="filter">
                                    <select name="project_id" id="project_id"  class="form-control" placeholder="Select Project" data-placeholder="Select Project" >
                                        <option value="">All</option>
                                        @foreach($projects as $key => $row)
                                            <option value="{{$row->id}}" {{$row->id == request()->project_id ? 'selected' : ''}}>{{$row->name}}</option>
                                        @endforeach
                                    </select>
                                </form>
                            </div>
                            <div class="col-md-2 ">
                              <a class="btn btn-sm btn-success" href="{{ route('tasks.create') }}">Add Task</a>
                            </div>
                        </div>
                        <div class="row">
                            <table class="table table-bordered table-striped table-hover datatable">
                              <tr>
                                <th></th>
                                <th>#</th>
                                <th>Task Title</th>
                                <th>Project Name</th>
                                <th>Sort Order</th>
                                <th>Created Date</th>
                                <th>Action</th>
                              </tr>
                              @foreach ($tasks as $key => $row)
                                <tr data-id="{{$row->id}}">
                                    <td class="grab" >&#9776;</td>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $row->name }}</td>
                                    <td>{{ $row->project->name ?? '' }}</td>
                                    <td>{{ $row->sort_order }}</td>
                                    <td>{{ $row->created_at ? date('Y-m-d',strtotime($row->created_at)) : ''  }}</td>
                                    <td><a href="{{ route('tasks.edit', $row->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                        <form action="{{ route('tasks.destroy', $row->id) }}" method="post">
                                          @csrf
                                          <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                  </tr>
                              @endforeach
                            </table>
                        </div>
                      </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section("script")
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
     $(document).on('change', '#project_id', function() {
        $('#filter').submit();
    });

    $(".grab").mousedown(function(e) {
      var tr = $(e.target).closest("TR"),
        si = tr.index(),
        sy = e.pageY,
        b = $(document.body),
        drag;
      if (si == 0) return;
      b.addClass("grabCursor").css("userSelect", "none");
      tr.addClass("grabbed");

      function move(e) {
        if (!drag && Math.abs(e.pageY - sy) < 10) return;
        drag = true;
        tr.siblings().each(function() {
          var s = $(this),
            i = s.index(),
            y = s.offset().top;
          if (i >= 0 && e.pageY >= y && e.pageY < y + s.outerHeight()) {
            if (i < tr.index())
              tr.insertAfter(s);
            else
              tr.insertBefore(s);
            return false;
          }
        });
      }

      function up(e) {
        if (drag && si != tr.index()) {
          drag = false;
          console.log(si,tr.index(),tr.data('id'));
            $.ajax({
                url:"{{ route('tasks.update_sort') }}",
                type:'POST',
                data:{from:si,to:tr.index(),id:tr.data('id'),'_token':"{{ csrf_token() }}"},
                success:function(res){
                    window.location.reload();
                },
                error: function(xhr, status, error) {
                }

            })

        }
        $(document).unbind("mousemove", move).unbind("mouseup", up);
        b.removeClass("grabCursor").css("userSelect", "none");
        tr.removeClass("grabbed");
      }
      $(document).mousemove(move).mouseup(up);
    });


</script>
@stop
