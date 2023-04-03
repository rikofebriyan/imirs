<div class="container-fluid justify-content-center py-0">

    <div class="table-responsive-sm card border mb-2 p-3">
        {{-- {{ Form::open(['route' => 'partrepair.progresstrial.store', 'method' => 'POST']) }} --}}
        <form action="{{ route('partrepair.progresstrial.store') }}" method="POST">
            @csrf
            <input type="hidden" name="form_input_id" value="{{ $waitingrepair->id }}">
            <input type="hidden" name="master_spare_part_id" value="{{ $waitingrepair->item_id }}">
            <table id="myTable" class="table table-striped nowrap overflow-auto display">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Item Pengecekan</th>
                        <th scope="col">Operation</th>
                        <th scope="col">Standard Min</th>
                        <th scope="col">Standard Max</th>
                        <th scope="col">Unit Measurement</th>
                        <th scope="col">Actual</th>
                        <th scope="col">Judgement</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($join as $joi)
                        <input type="hidden" name="data[{{ $joi->id }}][id]" value="{{ $joi->id }}">
                        <input type="hidden" name="data[{{ $joi->id }}][form_input_id]"
                            value="{{ $waitingrepair->id }}">
                        <input type="hidden" name="data[{{ $joi->id }}][item_check_id]"
                            value="{{ $joi->item_check_id }}">
                        <input type="hidden" name="data[{{ $joi->id }}][operation]"
                            value="{{ $joi->operation }}">
                        <input type="hidden" name="data[{{ $joi->id }}][standard_pengecekan_min]"
                            value="{{ $joi->standard_pengecekan_min }}">
                        <input type="hidden" name="data[{{ $joi->id }}][standard_pengecekan_max]"
                            value="{{ $joi->standard_pengecekan_max }}">
                        <input type="hidden" name="data[{{ $joi->id }}][unit_measurement]"
                            value="{{ $joi->unit_measurement }}">
                        <input type="hidden" name="data[{{ $joi->id }}][standard_pengecekan_id]"
                            value="{{ $joi->id }}">

                        <tr>
                            <td>{{ $joi->id }}</td>
                            <td>{{ $joi->item_standard }}</td>
                            <td>{{ $joi->operation }}</td>
                            <td>{{ $joi->standard_pengecekan_min }}</td>
                            <td>{{ $joi->standard_pengecekan_max }}</td>
                            <td>{{ $joi->unit_measurement }}</td>
                            <td>
                                <input type="text" name="data[{{ $joi->id }}][actual_pengecekan]"
                                    id="actual_pengecekan{{ $joi->id }}" class="form-control" placeholder="Actual"
                                    value="{{ $joi->actual_pengecekan }}" required>
                            </td>
                            <td> <input type="text" name="data[{{ $joi->id }}][judgement]"
                                    id="judgement{{ $joi->id }}" class="form-control" placeholder="Judgement"
                                    value="{{ $joi->judgement }}" required>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center text-mute" colspan="8">Data post tidak tersedia</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <button id="judgeok" type="submit" class="btn btn-md btn-primary">Save</button>
        </form>
    </div>
</div>
<div class="row">
    <div class="col-9"></div>
    <div class="col d-grid gap-2 px-3">
        <button type="button" class="btn btn-md btn-success" data-bs-toggle="modal"
            data-bs-target="#modalAddPengecekan">
            ADD STANDARD PENGECEKAN
        </button>
    </div>
</div>
<!-- Modal -->

{{-- {{ Form::open(['route' => 'matrix.standard_pengecekan.store', 'method' => 'POST']) }} --}}
<form action="{{ route('standard_pengecekan.store') }}" method="POST">
    @csrf
    <div class="modal fade" id="modalAddPengecekan" tabindex="-1" aria-labelledby="modalAddPengecekanLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalAddPengecekanLabel">Add Item Pengecekan</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="form_input_id" value="{{ $waitingrepair->id }}">

                    <div class="form-group mt-2">
                        <label for="master_spare_part_id">Item Code</label>
                        <select name="master_spare_part_id" id="master_spare_part_id"
                            class="form-control bg-secondary text-white">
                            <option value="{{ $asu->item_id }}">{{ $asu->item_code }}
                            </option>
                        </select>
                    </div>

                    <div class="form-group mt-2">
                        <label for="master_spare_part_id">Part Name</label>
                        <input type="text" class="form-control bg-secondary text-white"
                            value="{{ $asu->item_name }}" disabled>
                    </div>

                    <div class="form-group mt-2">
                        <label for="master_spare_part_id">Part Type</label>
                        <input type="text" class="form-control bg-secondary text-white"
                            value="{{ $asu->item_type }}" disabled>
                    </div>

                    <div class="form-group mt-2">
                        <label for="item_check_id">Item Check</label>
                        <select name="item_check_id" id="item_check_id" class="form-control">
                            <option value="" disabled selected>
                                Choose ...
                            </option>
                            @foreach ($itemstandard as $tabw)
                                <option value="{{ $tabw->id }}">
                                    {{ $tabw->item_standard }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mt-2">
                        <label for="operation">Operation</label>
                        <select name="operation" id="operation" class="form-control">
                            <option value="" disabled selected>
                                Choose ...
                            </option>
                            <option value="Less Than">Less Than</option>
                            <option value="Greater Than">Greater Than</option>
                            <option value="Between">Between</option>
                            <option value="Equal">Equal</option>
                        </select>
                    </div>

                    <div id="standard_pengecekan_min_div" class="form-group mt-2">
                        <label for="standard_pengecekan_min">Standard Min</label>
                        <input type="text" id="standard_pengecekan_min" name="standard_pengecekan_min"
                            class="form-control" value="">
                    </div>

                    <div id="standard_pengecekan_max_div" class="form-group mt-2">
                        <label for="standard_pengecekan_max">Standard Max</label>
                        <input type="text" id="standard_pengecekan_max" name="standard_pengecekan_max"
                            class="form-control" value="">
                    </div>

                    <div class="form-group mt-2">
                        <label for="unit_measurement">Unit Measurement</label>
                        <input type="text" id="unit_measurement" name="unit_measurement" class="form-control"
                            value="">
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
