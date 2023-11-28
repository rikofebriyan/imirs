@extends('layouts.app')

@section('content')
    <CENTER>
        <div class="container-fluid">
            <H2>USER TABLE</H2>
        </div>
    </CENTER>
    @if ($message = Session::get('success'))
        <h6 class="alert alert-success">
            {{ $message }}
        </h6>
    @endif

    <div class="card border-0 shadow rounded overflow-auto">
        <div class="card-body">
            <div class="table-responsive-sm">
                <table id="myTable" class="table table-striped nowrap overflow-auto display">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">NPK</th>
                            <th scope="col">Jabatan</th>
                            <th scope="col">Email</th>
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
                                <td>{{ $req->NPK }}</td>
                                <td>{{ $req->jabatan }}</td>
                                <td>{{ $req->email }}</td>


                                <td>{{ $req->created_at }}</td>
                                <td>{{ $req->updated_at }}</td>
                                <td class="text-center d-flex d-inline">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn icon btn-primary btn-sm me-1" data-bs-toggle="modal"
                                        data-bs-target="#asu{{ $req->id }}">
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                    <form action="{{ route('user.update', $req->id) }}" method="POST">
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
                                                        <div class="form-group mt-2">
                                                            <label for="name">Name</label>
                                                            <input type="text" id="name" name="name"
                                                                class="form-control text-center"
                                                                value="{{ $req->name }}" required>
                                                        </div>
                                                        <div class="form-group mt-2">
                                                            <label for="NPK">NPK</label>
                                                            <input type="text" id="NPK" name="NPK"
                                                                class="form-control text-center"
                                                                value="{{ $req->NPK }}" required>
                                                        </div>
                                                        <div class="form-group mt-2">
                                                            <label for="jabatan">Jabatan</label>
                                                            <select class="form-control choices" id="jabatan"
                                                                name="jabatan" required>

                                                                <option value="ADMIN"
                                                                    @if ($req->jabatan == 'ADMIN') selected @endif>ADMIN
                                                                </option>
                                                                <option value="Maintenance"
                                                                    @if ($req->jabatan == 'Maintenance') selected @endif>
                                                                    Maintenance
                                                                </option>
                                                                <option value="RepairMan"
                                                                    @if ($req->jabatan == 'RepairMan') selected @endif>
                                                                    RepairMan
                                                                </option>
                                                                <option value="Supervisor"
                                                                    @if ($req->jabatan == 'Supervisor') selected @endif>
                                                                    Supervisor
                                                                </option>
                                                            </select>
                                                        </div>

                                                        <div class="form-group mt-2">
                                                            <label for="email">Email</label>
                                                            <input type="email" id="email" name="email"
                                                                class="form-control text-center"
                                                                value="{{ $req->email }}" required>
                                                        </div>
                                                        <div class="form-group mt-2">
                                                            <input type="hidden" id="password" name="password"
                                                                class="form-control text-center"
                                                                value="{{ $req->password }}" required>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary">Perbarui
                                                            Data</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <form action="{{ route('user.destroy', $req->id) }}" method="POST"
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
    </script>
@endsection
