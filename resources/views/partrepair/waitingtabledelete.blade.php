@extends('layouts.app')

@section('css')
@endsection
@section('content')
    <CENTER>
        <div class="container-fluid">
            <H2>DELETED PART REPAIR</H2>
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
                            <th scope="col">Name Part</th>
                            <th scope="col">Type Part</th>
                            <th scope="col">Problem</th>
                            <th class="text-center" scope="col">Status Repair</th>
                            <th scope="col">Reason</th>
                            <th scope="col">Deleted By</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($reqtzy as $req)
                            <tr>
                                <td>{{ $req->reg_sp }}</td>
                                <td>{{ Carbon\Carbon::parse($req->plan_start_repair)->format('Y-m-d') }}</td>
                                <td>{{ Carbon\Carbon::parse($req->plan_finish_repair)->format('Y-m-d') }}</td>
                                <td>{{ $req->item_name }}</td>
                                <td>{{ $req->item_type }}</td>
                                <td>{{ $req->problem }}</td>
                                <td>{{ $req->status_repair }}</td>
                                <td>{{ $req->reason }}</td>
                                <td>{{ $req->deleted_by }}</td>

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
            $('#myTable').DataTable({
                order: [
                    [0, 'desc']
                ],

            });
        });
    </script>
    <script>
        $(document).ready(function() {
            var table = $('#myTable').DataTable();

            $('#allinput').click(function() {
                table.column(7).search('').draw();
            });
            $('#waiting').click(function() {
                table.column(7).search('waiting').draw();
            });
            $('#progress').click(function() {
                table.column(7).search('progress').draw();
            });
            $('#sealkit').click(function() {
                table.column(7).search('Seal Kit').draw();
            });
            $('#trial').click(function() {
                table.column(7).search('Trial').draw();
            });
            $('#finish').click(function() {
                table.column(7).search('Finish').draw();
            });
        });
    </script>
@endsection
