@extends('layouts.app')

@section('css')
@endsection
@section('content')
    <CENTER>
        <div class="container-fluid">
            <H2>STOCKOUT TABLE</H2>
        </div>
    </CENTER>

    <div class="row">
        <div class="card border-0 shadow rounded overflow-auto col m-2">
            <div class="card-body">
                <div class="table-responsive-sm">
                    <table id="myTable" class="table table-striped nowrap overflow-auto display text-sm">
                        <thead>
                            <tr>
                                <th scope="col">Tiket No</th>
                                <th scope="col">Actual Finish</th>
                                <th scope="col">Nama Spare Part</th>
                                <th scope="col">Item Code</th>
                                <th scope="col">Item Description</th>
                                <th class="text-center" scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($reqtzy as $req)
                                <tr>
                                    <td>{{ substr($req->reg_sp, -6, 6) }}</td>
                                    <td>{{ Carbon\Carbon::parse($req->date)->format('Y-m-d') }}</td>
                                    <td>{{ $req->item_name }}</td>
                                    <td>{{ $req->item_code }}</td>
                                    <td>{{ $req->item_type }}</td>
                                    <td class="text-center">


                                        <button type="button" class="rounded-pill btn btn-primary btn-sm col"
                                            data-bs-toggle="modal" data-bs-target="#modaldelete{{ $req->waitingrepairid }}">
                                            Stock Out
                                        </button>
                                        <form action="{{ route('partrepair.stockout.store') }}" method="POST">
                                            @csrf
                                            <div class="modal fade" id="modaldelete{{ $req->waitingrepairid }}"
                                                tabindex="-1" aria-labelledby="modaldeleteLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="modaldeleteLabel">Form Stock
                                                                Out
                                                            </h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <input type="hidden" name="form_input_id"
                                                                value="{{ $req->waitingrepairid }}">

                                                            <div class="form-group position-relative has-icon-left mb-4">
                                                                <input type="text" id="pic" name="pic"
                                                                    class="form-control form-control-xl" placeholder="pic"
                                                                    value="{{ old('pic') }}">
                                                                <div class="form-control-icon">

                                                                    @if ($errors->has('pic'))
                                                                        <span class="help-block">
                                                                            <strong>{{ $errors->first('pic') }}</strong>
                                                                        </span>
                                                                    @endif

                                                                    <i class="bi bi-person-circle"></i>
                                                                </div>
                                                            </div>

                                                            <div class="form-group position-relative has-icon-left mb-4">
                                                                <input type="date" id="tanggalstockout"
                                                                    name="tanggalstockout"
                                                                    class="form-control form-control-xl"
                                                                    placeholder="Tanggal Stock Out"
                                                                    value="{{ old('tanggalstockout') }}">
                                                                <div class="form-control-icon">

                                                                    @if ($errors->has('tanggalstockout'))
                                                                        <span class="help-block">
                                                                            <strong>{{ $errors->first('tanggalstockout') }}</strong>
                                                                        </span>
                                                                    @endif

                                                                    <i class="bi bi-calendar-week"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Stock
                                                                Out</button>
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
                "autoWidth": true,
                "lengthMenu": [
                    [25, 50, 100, -1],
                    [25, 50, 100, "All"]
                ],
            });
        </script>
    @endsection
