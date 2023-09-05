@extends('layouts.app')

@section('css')
@endsection
@section('content')
    <CENTER>
        <div class="container-fluid">
            <H2>WAITING APPROVAL</H2>
        </div>
    </CENTER>

    <div class="card border-0 shadow rounded overflow-auto">
        <div class="card-body">
            <div class="table-responsive-sm">
                <table id="myTable" class="table table-striped nowrap overflow-auto display">
                    <thead>
                        <tr>
                            <th scope="col">Ticket No</th>
                            <th scope="col">Nama Requester</th>
                            <th scope="col">Name Part</th>
                            <th scope="col">Type Part</th>
                            <th scope="col">Problem</th>
                            <th class="text-center" scope="col">Status Repair</th>
                            <th class="text-center" scope="col">Section</th>
                            <th class="text-center" scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($reqtzy as $req)
                            <tr>
                                <td>{{ $req->reg_sp }}</td>
                                <td>{{ $req->nama_pic . ' ( ' . $req->jabatan . ' )' }}</td>
                                <td>{{ $req->item_name }}</td>
                                <td>{{ $req->item_type }}</td>
                                <td>{{ $req->problem }}</td>
                                <td class="text-center"><span
                                        class="@if ($req->status_repair == 'Urgent') bg-danger text-white px-3 py-2 rounded-pill @endif">{{ $req->status_repair }}</span>
                                </td>
                                <td>{{ $req->section }}</td>
                                <td class="d-flex d-inline justify-content-center">
                                    @can('AdminSupervisor')
                                        <form action="{{ route('partrepair.waitingapprove.update', $req->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" id="approval" name="approval" value="{{ $currentUser }}">
                                            <button type="submit" class="btn btn-sm btn-success rounded-pill mx-2">Approve</button>
                                        </form>
                                    @else
                                        <span class="rounded-pill bg-danger text-white text-center px-2 bg-opacity-50"> Not
                                            Authorized</span>
                                    @endcan
                                    <form action="{{ route('ticket', $req->reg_sp) }}" method="POST"
                                        style="display:inline">
                                        @csrf
                                        <input type="hidden" name="reg_sp" value="{{ $req->reg_sp }}">
                                        <button type="submit" class="btn icon btn-warning btn-sm rounded-pill mx-2">Cetak
                                            Tiket</button>
                                    </form>
                                    <button type="button" class="btn btn-sm btn-primary rounded-pill mx-2"
                                        data-bs-toggle="modal" data-bs-target="#modalemail{{ $req->id }}">
                                        Send Email
                                    </button>
            </div>
        </div>
    </div>
    @can('Supervisor')
        <button type="button" class="rounded-pill btn btn-danger btn-sm col-5" data-bs-toggle="modal"
            data-bs-target="#modaldelete{{ $req->id }}">
            Reject
        </button>
    @endcan
    @can('ADMIN')
        <button type="button" class="rounded-pill btn btn-danger btn-sm col-5" data-bs-toggle="modal"
            data-bs-target="#modaldelete{{ $req->id }}">
            Reject
        </button>
    @endcan
    <form action="{{ route('partrepair.waitingapprove.destroy', $req->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <div class="modal fade" id="modaldelete{{ $req->id }}" tabindex="-1" aria-labelledby="modaldeleteLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modaldeleteLabel">Alasan Reject?
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <input type="hidden" name="deleted_by" value="{{ $loginUser->name }}">

                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" id="reason" name="reason" class="form-control form-control-xl"
                                placeholder="Tulis alasan reject disini" value="{{ old('reason') }}">
                            <div class="form-control-icon">

                                @if ($errors->has('reason'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('reason') }}</strong>
                                    </span>
                                @endif

                                <i class="bi bi-c-circle"></i>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form action="{{ route('sendemail', $req->id) }}" method="POST">
        @csrf
        <div class="modal fade" id="modalemail{{ $req->id }}" tabindex="-1" aria-labelledby="modalemailLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-body">
                        <h1 class="modal-title fs-5 mb-1" id="modalemailLabel">Alamat Tujuan Email
                        </h1>
                        <div class="form-group position-relative has-icon-left mb-4">

                            <input type="hidden" name="reg_sp" value="{{ $req->reg_sp }}">
                            <input type="hidden" name="nama_requester" value="{{ $req->nama_pic }}">
                            <input type="hidden" name="spare_part" value="{{ $req->item_name }}">
                            <input type="hidden" name="problem" value="{{ $req->problem }}">
                            <input type="hidden" name="section" value="{{ $req->section }}">

                            <select class="form-control choices" id="email" name="email" required>
                                <option value="" selected disabled>Pilih ...</option>
                                @foreach ($user as $us)
                                    @if ($us->jabatan = 'ADMIN' || 'Supervisor')
                                        <option value="{{ $us->email }}">{{ $us->name }} |
                                            {{ $us->email }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>

                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif

                        </div>
                        <input type="hidden" name="reg_sp" value="{{ $req->reg_sp }}">
                        <button type="submit" class="btn icon btn-warning btn-sm rounded-pill mx-2">Send Email</button>
                    </div>
                </div>
            </div>
        </div>
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
    @if ($message = Session::get('success'))
        <script>
            Toastify({
                text: "{{ $message }}",
                duration: 2500,
                close: true,
                gravity: "top",
                position: "center",
                backgroundColor: "#4fbe87",
            }).showToast()
        </script>
    @endif

    <script>
        $(document).ready(function() {
            var table = $('#myTable').DataTable({
                order: [[0, 'desc']],
            });

            $('#allinput').click(function() {
                table.column(6).search('').draw();
            });
            $('#waiting').click(function() {
                table.column(6).search('waiting').draw();
            });
            $('#progress').click(function() {
                table.column(6).search('progress').draw();
            });
            $('#sealkit').click(function() {
                table.column(6).search('Seal Kit').draw();
            });
            $('#trial').click(function() {
                table.column(6).search('Trial').draw();
            });
            $('#finish').click(function() {
                table.column(6).search('Finish').draw();
            });
        });
    </script>
@endsection
