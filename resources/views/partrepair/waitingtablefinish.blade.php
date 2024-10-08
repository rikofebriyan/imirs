@extends('layouts.app')

@section('css')
@endsection
@section('content')
    <CENTER>
        <div class="container-fluid">
            <H2>FINISHED PART REPAIR</H2>
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
                            <th class="text-center" scope="col">Progress</th>
                            <th class="text-center" scope="col">Action</th>
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
                                <td>

                                    @if ($req->progress == 'Finish')
                                        <div class="rounded-pill bg-success text-white text-center px-2 bg-opacity-50">
                                            {{ $req->progress }}</div>
                                    @elseif($req->progress == 'Scrap')
                                        <div class="rounded-pill bg-danger text-white text-center px-2 bg-opacity-50">
                                            {{ $req->progress }}</div>
                                    @endif

                                </td>
                                <td class="text-center">
                                    @if ($req->progress == 'Scrap')
                                        <a class="rounded-pill btn btn-danger btn-sm col @if($loginUser->jabatan == '') disabled @endif"
                                            href="{{ route('partrepair.waitingtable.show', $req->id) }}" @if($loginUser->jabatan == '') aria-disabled="true" @endif>Detail</a>
                                    @elseif($req->progress == 'Finish')
                                        <a class="rounded-pill btn btn-success btn-sm col @if($loginUser->jabatan == '') disabled @endif"
                                            href="{{ route('partrepair.waitingtable.show', $req->id) }}" @if($loginUser->jabatan == '') aria-disabled="true" @endif>Detail</a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center text-mute" colspan="4">Data post tidak tersedia</td>
                            </tr>
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
            <form action="{{ route('export_finish') }}" method="post">
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
