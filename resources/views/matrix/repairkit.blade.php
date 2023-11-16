@extends('layouts.app')

@section('content')
    <CENTER>
        <div class="container-fluid">
            <H2>REPAIR KIT TABLE</H2>
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
                            <th scope="col">ID</th>
                            <th scope="col">Item Code</th>
                            <th scope="col">Item Name</th>
                            <th scope="col">Description</th>
                            <th scope="col">Maker</th>
                            <th scope="col">Qty</th>
                            <th scope="col">created_at</th>
                            <th scope="col">updated_at</th>
                            <th scope="col">action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($join as $req)
                            <tr>
                                <td>{{ $req->id }}</td>
                                <td>{{ $req->item_code }}</td>
                                <td>{{ $req->item_name }}</td>
                                <td>{{ $req->description }}</td>
                                <td>{{ $req->maker_name }}</td>
                                <td>{{ $req->qty }}</td>
                                <td>{{ $req->created_at->format('d-m-Y H:i:s') }}</td>
                                <td>{{ $req->updated_at->format('d-m-Y H:i:s') }}</td>
                                <td class="text-center d-flex d-inline">
                                    <form action="{{ route('repair_kit.destroy', $req->id) }}" method="POST"
                                        style="display:inline">
                                        <button type="submit" class="btn icon btn-danger btn-sm"><i
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
    <form action="{{ route('repair_kit.store') }}" method="POST">
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Section</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group mt-2">
                            <label for="master_spare_part_id">Spare Part</label>
                            <select class="form-select form-select-isiotomatis2" id="isiotomatis2"
                                name="master_spare_part_id" onchange="isi_otomatis_part()" required>
                                <option value="" selected></option>
                                @foreach ($tab2 as $tab)
                                    <option data-custom-properties="{{ $tab->item_code }}"
                                        value="{{ $tab->code_item_description }}">
                                        {{ $tab->item_code }} |
                                        {{ $tab->item_name }} | {{ $tab->description }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="input-group">
                            <input type="hidden" class="form-control bg-secondary text-white" id="item_id2"
                                name="master_spare_part_id" placeholder="Item Name" readonly>
                        </div>

                        <div class="form-group mt-2">
                            <label for="item_code">item_code</label>
                            <input type="text" id="item_code2" name="item_code"
                                class="form-control bg-secondary text-white" value="" required readonly>
                        </div>
                        <div class="form-group mt-2">
                            <label for="item_name">item_name</label>
                            <input type="text" id="item_name2" name="item_name"
                                class="form-control bg-secondary text-white" value="" required readonly>
                        </div>
                        <div class="form-group mt-2">
                            <label for="description">description</label>
                            <input type="text" id="description2" name="description"
                                class="form-control bg-secondary text-white" value="" required readonly>
                        </div>
                        <div class="form-group mt-2">
                            <label for="maker">Maker</label>
                            <select name="maker" id="maker" class="form-control choices">
                                <option value="" disabled selected>
                                    choose
                                </option>
                                @foreach ($tab3 as $tabw)
                                    <option value="{{ $tabw->id }}">
                                        {{ $tabw->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mt-2">
                            <label for="qty">qty</label>
                            <input type="text" id="qty" name="qty" class="form-control" value=""
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
    <script type="text/javascript">
        $('#isiotomatis2').select2({
            dropdownParent: $('#exampleModal'),
            width: '100%',
        });

        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });

        function isi_otomatis_part() {
            $.ajax({
                type: 'GET',
                url: "{{ route('ajax') }}",
                data: {
                    item_name: $('#isiotomatis2').find(':selected').data('custom-properties'),
                },
                dataType: 'JSON',
                success: function(data) {
                    $('#description2').val(data.description);
                    $('#item_code2').val(data.item_code);
                    $('#item_name2').val(data.item_name);
                    $('#item_id2').val(data.id);
                }
            });
        }
    </script>
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
