@extends('layouts.app')

@section('content')
    <CENTER>
        <div class="container-fluid">
            <H2>SUBCONT TABLE</H2>
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
                Add New Sub Cont
            </button>
            <div class="table-responsive-sm">
                <table id="myTable" class="table table-striped nowrap overflow-auto display">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">Email</th>
                            <th scope="col">Contact</th>
                            <th scope="col">created_at</th>
                            <th scope="col">updated_at</th>
                            <th scope="col">action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($reqtzy as $req)
                            <tr>
                                <td>{{ $req->id }}</td>
                                <td>{{ $req->name }}</td>
                                <td>{{ $req->alamat }}</td>
                                <td>{{ $req->email }}</td>
                                <td>{{ $req->contact }}</td>


                                <td>{{ $req->created_at }}</td>
                                <td>{{ $req->updated_at }}</td>
                                <td class="text-center d-flex d-inline">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn icon btn-primary btn-sm me-1" data-bs-toggle="modal"
                                        data-bs-target="#asu{{ $req->id }}">
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                    <form action="{{ route('subcont.update', $req->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <div class="modal fade" id="asu{{ $req->id }}" tabindex="-1"
                                            aria-labelledby="modalUpdateBarang" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Update Data</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">


                                                        {{-- FORM COLUMN 1 --}}
                                                        <div class="form-group mt-2">
                                                            <label for="name">Name</label>
                                                            <input type="text" id="name" name="name"
                                                                class="form-control" value="{{ $req->name }}" required>
                                                        </div>

                                                        {{-- FORM COLUMN 1 --}}
                                                        <div class="form-group mt-2">
                                                            <label for="alamat">Alamat</label>
                                                            <input type="text" id="alamat" name="alamat"
                                                                class="form-control" value="{{ $req->alamat }}" required>
                                                        </div>

                                                        {{-- FORM COLUMN 1 --}}
                                                        <div class="form-group mt-2">
                                                            <label for="email">Email</label>
                                                            <input type="email" id="email" name="email"
                                                                class="form-control" value="{{ $req->email }}" required>
                                                        </div>

                                                        {{-- FORM COLUMN 1 --}}
                                                        <div class="form-group mt-2">
                                                            <label for="contact">Contact</label>
                                                            <input type="text" id="contact" name="contact"
                                                                class="form-control" value="{{ $req->contact }}" required>
                                                        </div>



                                                        <button type="submit" class="btn btn-primary">Perbarui
                                                            Data</button>
                                                        <!--END FORM UPDATE BARANG-->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <form action="{{ route('subcont.destroy', $req->id) }}" method="POST"
                                        style="display: inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn icon btn-danger btn-sm" onclick="return confirm('Yakin?')"><i
                                                class="fa fa-trash"></i></button>
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

    <form action="{{ route('subcont.store') }}" method="POST">
        @csrf
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Sub Cont</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">


                        {{-- FORM COLUMN 1 --}}
                        <div class="form-group mt-2">
                            <label for="name">Nama Subcont</label>
                            <input type="text" id="name" name="name" class="form-control" required>
                        </div>

                        {{-- FORM COLUMN 1 --}}
                        <div class="form-group mt-2">
                            <label for="alamat">Alamat</label>
                            <input type="text" id="alamat" name="alamat" class="form-control" required>
                        </div>

                        {{-- FORM COLUMN 1 --}}
                        <div class="form-group mt-2">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>

                        {{-- FORM COLUMN 1 --}}
                        <div class="form-group mt-2">
                            <label for="contact">Contact</label>
                            <input type="text" id="contact" name="contact" class="form-control" required>
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
