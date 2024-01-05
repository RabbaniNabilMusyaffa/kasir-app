@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    Data Category
                </div>
                @if (Session::has('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <span class="alert-icon"><i class="ni ni-like-2"></i></span>
                    <span class="alert-text"><strong>{{Session::get('message')}}!</strong></span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true"></span>
                    </button>
                </div>
                @endif
                <div class="card-body">
                    <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Name</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                           @foreach ($data as $category)
                        <tr>
                          <td>{{$loop->iteration }}</td>
                        <td>{{$category -> name }}</td>

                        <td class="text-center align-middle" >
                            <form action="{{ route ('delete-category', $category->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <a class="btn btn-warning" role="button" onclick="edit({{$category->id}}) ">
                                    <i class="fas fa-edit"></i>
                                    Edit
                                 </a>
                                <button id="deleteButton" class="btn btn-danger"  role="button">
                                <i class="fas fa-trash"></i>
                                    Delete
                                </button>
                            </form>
                        </td>
                        </tr>
                    @endforeach
                    </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="mb-4">
                        {{$data->links('pagination::bootstrap-5')}}
                    </div>
                </div>
                </div>
            </div>
        </div>
        <div class="col-md-5" id="Form">
            <div class="card">
                <div class="card-header">
                   <span id="Judul">Tambah Category</span>
                </div>
                <div class="card-body">
                    <form id="createjir" action="{{route('Send-category')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="name" class="form-label required"> Name : </label>
                                        <input type="text" name="name" id="name" placeholder="Name" class="form-control" required
                                            autoComplete="off" />
                                    </div>
                                </div>

                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-success ">
                                    <i class="fas fa-save"></i>
                                    Simpan
                                </button>
                                <button type="reset" class="btn btn-danger" onclick="batal()">
                                    <i class="fas fa-save"></i>
                                    Reset
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
     function edit(a) {
        document.getElementById("Judul").innerHTML="Edit Category";
            $.get('/edit-category/' + a, function (data) {
                $('#name').val(data.name);
                var action = '{{route("update-category", ":id") }}';
                action = action.replace(":id", data.id);
                $("#createjir").attr("action", action);
                $("input[name='_method']").val("PUT");
            })
        }
    function batal(){
        document.getElementById("Judul").innerHTML = "Tambah Category";
            var action = '{{route("Send-category", ":id") }}';
            $("#createjir").attr("action", action);
            $('#name').val("");
    }
</script>

@endsection