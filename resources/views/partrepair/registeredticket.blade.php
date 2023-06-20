@extends('layouts.app')

@section('css')
@endsection
@section('content')
    <CENTER>
        <div class="container-fluid">
            <H2>ALL HISTORY TICKET</H2>
        </div>
    </CENTER>

    <div class="card border-0 shadow rounded overflow-auto">
        <div class="card-body">
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
                            <th class="text-center" scope="col">Progress</th>

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
                                        {{ $req->plan_start_repair }}
                                    @endif
                                </td>
                                <td>
                                    @if ($req->plan_finish_repair == null)
                                        Belum Input
                                    @else
                                        {{ $req->plan_finish_repair }}
                                    @endif
                                </td>
                                <td>{{ $req->item_name }}</td>
                                <td>{{ $req->problem }}</td>
                                <td class="text-center"><span
                                        class="@if ($req->status_repair == 'Urgent') bg-danger text-white px-3 py-2 rounded-pill @endif">{{ $req->status_repair }}</span>
                                </td>
                                <td class="d-flex justify-content-center">
                                    @if ($req->progress == 'Waiting')
                                        <div class="rounded-pill bg-secondary text-white text-center px-2 mx-1">
                                            {{ $req->progress }}</div>
                                    @elseif ($req->progress == 'On Progress')
                                        <div class="rounded-pill bg-warning text-white text-center px-2 mx-1">
                                            {{ $req->progress }}
                                        </div>
                                    @elseif ($req->progress == 'Seal Kit')
                                        <div class="rounded-pill bg-info text-white text-center px-2 mx-1">
                                            {{ $req->progress }}
                                        </div>
                                    @elseif ($req->progress == 'Trial')
                                        <div class="rounded-pill bg-primary text-white text-center px-2 mx-1">
                                            {{ $req->progress }}</div>
                                    @elseif ($req->progress == 'Finish')
                                        <div class="rounded-pill bg-success text-white text-center px-2 mx-1">
                                            {{ $req->progress }}</div>
                                    @elseif ($req->progress == 'Scrap')
                                        <div class="rounded-pill bg-danger text-white text-center px-2 mx-1">
                                            {{ $req->progress }}</div>
                                    @endif
                                </td>

                            </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="card border-0 shadow rounded col-3 mx-auto">
        <div class="card-header text-center">
            <h3><i class="fas fa-file-excel"></i> Export to Excel </h3>
        </div>
        <div class="card-body">
            <form action="{{ route('export') }}" method="post">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="start_date">Start Date:</label>
                    <input type="date" name="start_date" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="end_date">End Date:</label>
                    <input type="date" name="end_date" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Export to Excel</button>
            </form>
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
