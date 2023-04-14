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
            {{-- <div class="d-flex d-inline justify-content-center mb-3">
                <div class="me-2">Flow Repair : </div>
                <button class="rounded-pill bg-dark text-white text-center px-2 border-white" id="allinput">Register</button>
                <div class="px-2"><i class="fa-solid fa-arrow-right"></i></div>
                <button class="rounded-pill bg-secondary text-white text-center px-2 border-white"
                    id="waiting">Waiting</button>
                <div class="px-2"><i class="fa-solid fa-arrow-right"></i></div>
                <button class="rounded-pill bg-warning text-white text-center px-2 border-white" id="progress">On
                    Progress</button>
                <div class="px-2"><i class="fa-solid fa-arrow-right"></i></div>
                <button class="rounded-pill bg-info text-white text-center px-2 border-white" id="sealkit">Seal
                    Kit</button>
                <div class="px-2"><i class="fa-solid fa-arrow-right"></i></div>
                <button class="rounded-pill bg-primary text-white text-center px-2 border-white"
                    id="trial">Trial</button>
            </div> --}}
            <div class="table-responsive-sm">
                <table id="myTable" class="table table-striped nowrap overflow-auto display">
                    <thead>
                        <tr>
                            <th scope="col">Ticket No</th>
                            <th scope="col">Plan Start</th>
                            <th scope="col">Plan Finish</th>
                            <th scope="col">Spare Part</th>
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
                                <td>
                                    @if ($req->plan_start_repair == null)
                                        Belum Input
                                    @else
                                        {{ \Carbon\Carbon::parse($req->plan_start_repair)->format('d-M-Y') }}
                                    @endif
                                </td>
                                <td>
                                    @if ($req->plan_finish_repair == null)
                                        Belum Input
                                    @else
                                        {{ \Carbon\Carbon::parse($req->plan_finish_repair)->format('d-M-Y') }}
                                    @endif
                                </td>
                                <td>{{ $req->item_name }}</td>
                                <td>{{ $req->problem }}</td>
                                <td class="text-center"><span
                                        class="@if ($req->status_repair == 'Urgent') bg-danger text-white px-3 py-2 rounded-pill @endif">{{ $req->status_repair }}</span>
                                </td>
                                <td>{{ $req->section }}</td>
                                <td class="text-center d-flex d-inline justify-content-center">
                                    {{-- 
                                        <a class="rounded-pill btn btn-primary btn-sm col-7"
                                            href="{{ route('partrepair.waitingtable.show.form5', $req->id) }}">To
                                            Finish</a> --}}
                                    @can('Supervisor')
                                        <button type="button" class="btn btn-sm btn-success rounded-pill mx-2"
                                            data-bs-toggle="modal" data-bs-target="#modalapprove{{ $req->id }}">
                                            Approve
                                        </button>
                                    @endcan

                                    @can('ADMIN')
                                        <button type="button" class="btn btn-sm btn-success rounded-pill mx-2"
                                            data-bs-toggle="modal" data-bs-target="#modalapprove{{ $req->id }}">
                                            Approve
                                        </button>
                                    @endcan

                                    {{-- {{ Form::open(['method' => 'PUT', 'route' => ['partrepair.waitingapprove.update', $req->id]]) }} --}}
                                    <form action="{{ route('partrepair.waitingapprove.update'), $req->id }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <div class="modal fade" id="modalapprove{{ $req->id }}" tabindex="-1"
                                            aria-labelledby="modalapproveLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">


                                                    {{-- <input type="hidden" name="user" value="{{ Auth::user()->name }}"> --}}

                                                    <div class="modal-body">
                                                        <h1 class="modal-title fs-5 mb-1" id="modalapproveLabel">Konfirmasi
                                                            Approval
                                                        </h1>
                                                        <div class="form-group position-relative has-icon-left mb-4">
                                                            <input type="text" id="approval" name="approval"
                                                                class="form-control form-control-xl  @if ($errors->has('approval')) is-invalid @endif"
                                                                placeholder="Tulis siapa yang approve"
                                                                value="{{ old('approval') }}" required>
                                                            <div class="form-control-icon">

                                                                @if ($errors->has('approval'))
                                                                    <span class="help-block">
                                                                        <strong>{{ $errors->first('approval') }}</strong>
                                                                    </span>
                                                                @endif

                                                                <i class="bi bi-person-check"></i>
                                                            </div>
                                                        </div>

                                                        {{-- <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button> --}}
                                                        <button type="submit" class="btn btn-success">APPROVE</button>
                                    </form>
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
    {{-- {{ Form::open(['method' => 'DELETE', 'route' => ['partrepair.waitingapprove.destroy', $req->id]]) }} --}}
    <form action="{{ route('partrepair.waitingapprove.destroy'), $req->id }}" method="POST">
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

                        <input type="hidden" name="deleted_by" value="{{ Auth::user()->name }}">

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
            var table = $('#myTable').DataTable();

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
