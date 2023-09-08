@extends('layouts.app')



@section('content')
    <CENTER>
        <div class="container-fluid">
            <H2>LINE TABLE</H2>
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
                Add New
            </button>
            <div class="table-responsive-sm">
                <table id="myTable" class="table table-striped nowrap overflow-auto display">
                    <thead>
                        <tr>
                            <th scope="col">id</th>
                            <th scope="col">BU</th>
                            <th scope="col">Section</th>
                            <th scope="col">Name</th>
                            <th scope="col">created_at</th>
                            <th scope="col">updated_at</th>
                            <th scope="col">action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($join as $req)
                            <tr>
                                <td>{{ $req->id }}</td>
                                <td>T {{ $req->bu }}</td>
                                <td>{{ $req->section }}</td>
                                <td>{{ $req->name }}</td>
                                <td>{{ $req->created_at }}</td>
                                <td>{{ $req->updated_at }}</td>
                                <td class="text-center d-flex d-inline">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn icon btn-primary btn-sm me-1" data-bs-toggle="modal"
                                        data-bs-target="#asu{{ $req->id }}">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <form action="{{ route('line.update', $req->id) }}" method="POST">
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
                                                            <label for="bu">BU</label>
                                                            <input type="text" id="bu" name="bu"
                                                                class="form-control text-center"
                                                                value="{{ $req->bu }}" required>
                                                        </div>
                                                        <div class="form-group mt-2">
                                                            <label for="section_id">Section</label>
                                                            <select name="section_id" id="section_id"
                                                                class="form-control choices">
                                                                <option value="" disabled selected>
                                                                    choose
                                                                </option>
                                                                @foreach ($sectzy as $sec)
                                                                    <option value="{{ $sec->id }}"
                                                                        @if ($req->section_id == $sec->id) selected @endif>
                                                                        {{ $sec->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group mt-2">
                                                            <label for="name">Name</label>
                                                            <input type="text" id="name" name="name"
                                                                class="form-control text-center"
                                                                value="{{ $req->name }}" required>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary">Perbarui
                                                            Data</button>
                                                        <!--END FORM UPDATE BARANG-->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <form action="{{ route('line.destroy', $req->id) }}" method="POST"
                                        style="display:inline">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn icon btn-danger btn-sm" onclick="return confirm('Yakin?')"><i
                                                class="bi bi-trash3"></i></button>
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
    <form action="{{ route('line.store') }}" method="POST">
        @csrf

        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Line</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group mt-2">
                            <label for="bu">BU</label>
                            <input type="text" id="bu" name="bu" class="form-control text-center"
                                value="" required>
                        </div>
                        <div class="form-group mt-2">
                            <label for="section_id">Section</label>
                            <select name="section_id" id="section_id" class="form-control choices">
                                <option value="" disabled selected>
                                    choose
                                </option>
                                @foreach ($sectzy as $sec)
                                    <option value="{{ $sec->id }}">{{ $sec->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mt-2">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" class="form-control text-center"
                                required>
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
                    [0, 'asc']
                ],
            });
        });

        $('#exampleModal').on("shown.bs.modal", function() {
            $(this).find(".form-control:first").focus();
        });
    </script>
@endsection
