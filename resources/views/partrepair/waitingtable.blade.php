@extends('layouts.app')

@section('css')
    {{-- <style>
        .dataTables_wrapper table {
            font-size: 14px;
        }
    </style> --}}
@endsection
@section('content')
    <div class="row">
        <div class="col-8 card border text-center mb-2 ">
            <h2 class="m-2">WAITING TABLE</h2>
        </div>
        <div class="col card border text-center mb-2 mx-2 d-flex justify-content-center">
            <div>Near Delay : <span class="badge rounded-pill border border-dark"
                    style="background-color: #FAFAD2; color:#FAFAD2">FFFFFF</span>
                Delay : <span class="badge rounded-pill border border-dark"
                    style="background-color: #FFCCCB; color:#FFCCCB">FFFFFF</span>
            </div>
        </div>
    </div>
    <div class="card border-0 shadow rounded overflow-auto">
        <div class="card-body">
            <div class="d-flex d-inline justify-content-center mb-3">
                <div class="me-2">Flow Repair : </div>
                <button class="rounded-pill bg-dark text-white text-center px-2 border-white"
                    id="allinput">Register</button>
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
            </div>
            <div class="table-responsive-sm">
                <table id="myTable" class="table table-striped nowrap overflow-auto display">
                    <thead>
                        <tr>
                            <th class="text-center" scope="col">Action</th>
                            <th class="text-center" scope="col">Progress</th>
                            <th scope="col">Ticket No</th>
                            <th scope="col">Plan Start</th>
                            <th scope="col">Plan Finish</th>
                            <th scope="col">Spare Part</th>
                            <th scope="col">Item Type</th>
                            <th scope="col">Place Repair</th>
                            <th scope="col">Problem</th>
                            <th class="text-center" scope="col">Status Repair</th>

                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($reqtzy as $req)
                            <tr>
                                <td class="text-center" style="min-width: 130px;">

                                    @if ($req->progress == 'Waiting')
                                        <a class="rounded-pill btn btn-primary btn-sm col-7"
                                            href="{{ route('partrepair.waitingtable.show', $req->id) }}">To Ticket</a>
                                    @elseif($req->progress == 'On Progress')
                                        <a class="rounded-pill btn btn-primary btn-sm col-7"
                                            href="{{ route('partrepair.waitingtable.show.form2', $req->id) }}">To
                                            Progress</a>
                                    @elseif($req->progress == 'Seal Kit')
                                        <a class="rounded-pill btn btn-primary btn-sm col-7"
                                            href="{{ route('partrepair.waitingtable.show.form3', $req->id) }}">To Seal
                                            Kit</a>
                                    @elseif($req->progress == 'Trial')
                                        <a class="rounded-pill btn btn-primary btn-sm col-7"
                                            href="{{ route('partrepair.waitingtable.show.form4', $req->id) }}">To
                                            Trial</a>
                                    @elseif($req->progress == 'Finish')
                                        <a class="rounded-pill btn btn-primary btn-sm col-7"
                                            href="{{ route('partrepair.waitingtable.show.form5', $req->id) }}">To
                                            Finish</a>
                                    @endif

                                    @if (Auth::user())
                                        @if (Auth::user()->jabatan == 'ADMIN' || 'Supervisor')
                                            <button type="button" class="rounded-pill btn btn-danger btn-sm"
                                                data-bs-toggle="modal" data-bs-target="#modaldelete{{ $req->id }}">
                                                Delete
                                            </button>
                                        @endif
                                    @endif
                                    <form action="{{ route('partrepair.waitingtable.destroy', $req->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        {{-- {{ Form::open(['method' => 'DELETE', 'route' => ['partrepair.waitingtable.destroy', $req->id]]) }} --}}
                                        <div class="modal fade" id="modaldelete{{ $req->id }}" tabindex="-1"
                                            aria-labelledby="modaldeleteLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="modaldeleteLabel">Yakin mau di
                                                            delete?
                                                        </h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">

                                                        <input type="hidden" name="deleted_by"
                                                            value="{{ Auth::user() ? Auth::user()->name : '' }}">

                                                        <div class="form-group position-relative has-icon-left mb-4">
                                                            <input type="text" id="reason" name="reason"
                                                                class="form-control form-control-xl" placeholder="reason"
                                                                value="{{ old('reason') }}" required>
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
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-danger">Delete</button>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </td>
                                <td>
                                    @if ($req->progress == 'Waiting')
                                        <div class="rounded-pill bg-secondary text-white text-center px-2 bg-opacity-50">
                                            {{ $req->progress }}</div>
                                    @elseif ($req->progress == 'On Progress')
                                        <div class="rounded-pill bg-warning text-white text-center px-2 bg-opacity-50">
                                            {{ $req->progress }}
                                        </div>
                                    @elseif ($req->progress == 'Seal Kit')
                                        <div class="rounded-pill bg-info text-white text-center px-2 bg-opacity-50">
                                            {{ $req->progress }}
                                        </div>
                                    @elseif ($req->progress == 'Trial')
                                        <div class="rounded-pill bg-primary text-white text-center px-2 bg-opacity-50">
                                            {{ $req->progress }}</div>
                                    @elseif ($req->progress == 'Finish')
                                        <div class="rounded-pill bg-success text-white text-center px-2 bg-opacity-50">
                                            {{ $req->progress }}</div>
                                    @endif

                                </td>

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
                                <td>{{ $req->item_type }}</td>
                                <td>{{ $req->place_of_repair }}</td>
                                <td>{{ $req->problem }}</td>
                                <td class="text-center"><span
                                        class="@if ($req->status_repair == 'Urgent') bg-danger text-white px-3 py-2 rounded-pill @endif">{{ $req->status_repair }}</span>
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
            $('#myTable').DataTable({
                order: [
                    [2, 'desc']
                ],

                "createdRow": function(row, data, dataIndex) {

                    var now = new Date().getTime();
                    var datestart = new Date(data[1]).getTime();
                    var dateplan = new Date(data[2]).getTime();
                    var diff = Math.floor((dateplan - now) / (1000 * 60 * 60 * 24));
                    if (diff < 0) {
                        $(row).css({
                            'background-color': '#FFCCCB',
                            'color': 'black'
                        });
                    } else if (diff <= 2) {
                        $(row).css({
                            'background-color': '#FAFAD2',
                            'color': 'black'
                        });
                    } else {
                        $(row);
                    }
                }

            });
        });
    </script>
    <script>
        $(document).ready(function() {
            var table = $('#myTable').DataTable();

            $('#allinput').click(function() {
                table.column(1).search('').draw();
            });
            $('#waiting').click(function() {
                table.column(1).search('waiting').draw();
            });
            $('#progress').click(function() {
                table.column(1).search('progress').draw();
            });
            $('#sealkit').click(function() {
                table.column(1).search('Seal Kit').draw();
            });
            $('#trial').click(function() {
                table.column(1).search('Trial').draw();
            });
            $('#finish').click(function() {
                table.column(1).search('Finish').draw();
            });

            var waiting = "{{ $progress }}";
            if (waiting == "waiting") {
                $('#waiting').click();
            }
            if (waiting == "progress") {
                table.column(1).search('^((?!waiting).)*$', true, false).draw();
            }

        });
    </script>
@endsection
