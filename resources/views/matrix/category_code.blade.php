@extends('layouts.app')

@section('content')
    <CENTER>
        <div class="container-fluid">
            <H2>CATEGORY CODE TABLE</H2>
        </div>
    </CENTER>
    @if ($message = Session::get('success'))
        <h6 class="alert alert-success">
            {{ $message }}
        </h6>
    @endif

    <div class="card border-0 shadow rounded overflow-auto">
        <div class="card-body">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-md btn-success mb-3 float-right" data-bs-toggle="modal"
                data-bs-target="#exampleModal">
                Add New Category
            </button>
            <div class="table-responsive-sm">
                <table id="myTable" class="table table-striped nowrap overflow-auto display">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Category</th>
                            <th scope="col">Category Code</th>
                            <th scope="col">created_at</th>
                            <th scope="col">updated_at</th>
                            <th scope="col">action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($reqtzy as $req)
                            <tr>
                                <td>{{ $req->id }}</td>
                                <td>{{ $req->category }}</td>
                                <td>{{ $req->category_code }}</td>


                                <td>{{ $req->created_at->format('d-m-Y H:i:s') }}</td>
                                <td>{{ $req->updated_at->format('d-m-Y H:i:s') }}</td>
                                <td class="text-center d-flex d-inline">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn icon btn-primary btn-sm me-1" data-bs-toggle="modal"
                                        data-bs-target="#asu{{ $req->id }}">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <form action="{{ route('category_code.update', $req->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <div class="modal fade" id="asu{{ $req->id }}" tabindex="-1"
                                            aria-labelledby="modalUpdateBarang" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Update Barang</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group mt-2">
                                                            <label for="category">Category</label>
                                                            <input type="text" id="category" name="category"
                                                                class="form-control" value="{{ $req->category }}" required>
                                                        </div>
                                                        <div class="form-group mt-2">
                                                            <label for="category_code">Category Code</label>
                                                            <input type="text" id="category_code" name="category_code"
                                                                class="form-control" value="{{ $req->category_code }}"
                                                                required>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary">Perbarui
                                                            Data</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                    <form action="{{ route('category_code.destroy', $req->id) }}" method="POST"
                                        style="display:inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn icon btn-danger btn-sm">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>

                                </td>
                            </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <form action="{{ route('category_code.store') }}" method="POST">
        @csrf
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Category</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mt-2">
                            <label for="category">Category</label>
                            <input type="text" id="category" name="category" class="form-control" required>
                        </div>
                        <div class="form-group mt-2">
                            <label for="category_code">Category Code</label>
                            <input type="text" id="category_code" name="category_code" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                order: [
                    [0, 'desc']
                ],
            });
        });

        $('#exampleModal').on("shown.bs.modal", function() {
            $(this).find(".form-control:first").focus();
        });
    </script>
@endsection
