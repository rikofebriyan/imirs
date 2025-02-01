<div class="container-fluid justify-content-center py-0">

    <div class="table-responsive-sm card border mb-2 p-3">
        <form action="{{ route('partrepair.progresstrial.store') }}" method="POST">
            @csrf
            <input type="hidden" name="form_input_id" value="{{ $waitingrepair->id }}">
            <input type="hidden" name="master_spare_part_id" value="{{ $waitingrepair->item_id }}">
            <table id="myTable" class="table table-striped nowrap overflow-auto display">
                <thead>
                    <tr>
                        <th scope="col">Action</th>
                        <th scope="col">Item Pengecekan</th>
                        <th scope="col">Operation</th>
                        <th scope="col">Standard</th>
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
                        <input type="hidden" name="data[{{ $joi->id }}][unit_measurement]"
                            value="{{ $joi->unit_measurement }}">
                        <input type="hidden" name="data[{{ $joi->id }}][standard_pengecekan_id]"
                            value="{{ $joi->id }}">

                        <tr>
                            <td>
                                <button type="button"
                                    class="btn btn-primary @if ($waitingrepair->progress == 'Finish'  || $waitingrepair->progress == 'Scrap') disabled @endif"
                                    data-bs-toggle="modal" data-bs-target="#asu{{ $joi->id }}"
                                    style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size:
                                .75rem">
                                    Edit
                                </button>

                                <a href="{{ route('partrepair.progresstrial.delete', $joi->id) }}"
                                    class="btn btn-danger @if ($waitingrepair->progress == 'Finish'  || $waitingrepair->progress == 'Scrap') disabled @endif"
                                    style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem"
                                    onclick="return confirm('Yakin?')">Delete</a>
                            </td>
                            <td>{{ $joi->item_standard }}</td>
                            <td>{{ $joi->operation }}</td>
                            <td>{{ $joi->standard_pengecekan_min }}</td>
                            <td>{{ $joi->unit_measurement }}</td>
                            <td>
                                <input type="text" name="data[{{ $joi->id }}][actual_pengecekan]"
                                    id="actual_pengecekan{{ $joi->id }}" class="form-control" placeholder="Actual"
                                    value="{{ $joi->actual_pengecekan }}" required>
                            </td>
                            <td>
                                <select id="judgement{{ $joi->id }}" name="data[{{ $joi->id }}][judgement]"
                                    class="form-control @if ($joi->judgement == 'OK') bg-success text-white @elseif ($joi->judgement == 'NG') bg-warning @else '' @endif"
                                    required>
                                    <option value="" @if ($joi->judgement == null) disabled selected @endif>Choose ...</option>
                                    <option value="OK" @if ($joi->judgement == 'OK') selected @endif>OK</option>
                                    <option value="NG" @if ($joi->judgement == 'NG') selected @endif>NG</option>
                                </select>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center text-mute" colspan="8">Data post tidak tersedia</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="d-flex justify-content-end">
                @if ($loginUser->jabatan == 'ADMIN' || $loginUser->jabatan == 'RepairMan' || $loginUser->jabatan == 'Die Maintenance')
                    <button type="button"
                        class="btn btn-md btn-info me-1 @if ($waitingrepair->progress == 'Finish'  || $waitingrepair->progress == 'Scrap') disabled @endif"
                        data-bs-toggle="modal" data-bs-target="#modalAddPengecekan">
                        Tambah Item Pengecekan
                    </button>
                    <button id="judgeok" type="submit"
                        class="btn btn-md btn-primary @if ($waitingrepair->progress == 'Finish'  || $waitingrepair->progress == 'Scrap') disabled @endif">Save</button>
                @else
                    <button type="button" class="btn btn-md btn-info me-1 disabled">
                        Tambah Item Pengecekan
                    </button>
                    <button type="button" class="btn btn-md btn-secondary disabled">Save</button>
                    <span class="m-2"> Anda tidak punya hak akses untuk Edit Ticket</span>
                @endif
            </div>
        </form>
    </div>
</div>

<!-- Modal update -->
@forelse ($join as $joi)
    <div class="modal fade" id="asu{{ $joi->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalAddPengecekanLabel">Edit Item Pengecekan</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form action="{{ route('partrepair.progresstrial.update', $joi->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $joi->id }}">

                        <div class="form-group mt-2">
                            <label for="item_check_id">Item Check</label>
                            <select name="item_check_id" id="item_check_id" class="form-control" required>
                                <option value="" disabled>
                                    Choose ...
                                </option>
                                @foreach ($itemstandard as $tabw)
                                    <option value="{{ $tabw->id }}"
                                        @if ($tabw->id == $joi->standard_pengecekan_id) selected @endif>
                                        {{ $tabw->item_standard }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mt-2">
                            <label for="operation">Operation</label>
                            <select name="operation" id="operation" class="form-control" required>
                                <option value="" disabled>
                                    Choose ...
                                </option>
                                <option value="Min" @if ($joi->operation == 'Min') selected @endif>Min</option>
                                <option value="Max" @if ($joi->operation == 'Max') selected @endif>Max</option>
                                <option value="Between" @if ($joi->operation == 'Between') selected @endif>Between
                                </option>
                                <option value="Equal" @if ($joi->operation == 'Equal') selected @endif>Equal
                                </option>
                            </select>
                        </div>

                        <div id="standard_pengecekan_min_div" class="form-group mt-2">
                            <label for="standard_pengecekan_min">Standard</label>
                            <input type="text" id="standard_pengecekan_min" name="standard_pengecekan_min"
                                class="form-control" value="{{ $joi->standard_pengecekan_min }}" required>
                        </div>

                        <div class="form-group mt-2">
                            <label for="unit_measurement">Unit Measurement</label>
                            <input type="text" id="unit_measurement" name="unit_measurement" class="form-control"
                                value="{{ $joi->unit_measurement }}">
                        </div>

                        <button type="submit" class="btn btn-primary">Perbarui Data</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach

<!-- Modal Add-->
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
                            class="form-control disabledriko">
                            <option value="{{ $asu->item_id }}">{{ $asu->item_code }}
                            </option>
                        </select>
                    </div>

                    <div class="form-group mt-2">
                        <label for="master_spare_part_id">Part Name</label>
                        <input type="text" class="form-control disabledriko" value="{{ $asu->item_name }}"
                            disabled>
                    </div>

                    <div class="form-group mt-2">
                        <label for="master_spare_part_id">Part Type</label>
                        <input type="text" class="form-control disabledriko" value="{{ $asu->item_type }}"
                            disabled>
                    </div>

                    <div class="form-group mt-2">
                        <label for="item_check_id">Item Check</label>
                        <select name="item_check_id" id="item_check_id" class="form-control" required>
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
                        <select name="operation" id="operation" class="form-control" required>
                            <option value="" disabled selected>
                                Choose ...
                            </option>
                            <option value="Min">Min</option>
                            <option value="Max">Max</option>
                            <option value="Between">Between</option>
                            <option value="Equal">Equal</option>
                        </select>
                    </div>

                    <div id="standard_pengecekan_min_div" class="form-group mt-2">
                        <label for="standard_pengecekan_min">Standard</label>
                        <input type="text" id="standard_pengecekan_min" name="standard_pengecekan_min"
                            class="form-control" value="" required>
                    </div>

                    <div class="form-group mt-2">
                        <label for="unit_measurement">Unit Measurement</label>
                        <input type="text" id="unit_measurement" name="unit_measurement" class="form-control"
                            value="">
                    </div>

                </div>
                @if ($loginUser->jabatan == 'ADMIN' || $loginUser->jabatan == 'RepairMan' || $loginUser->jabatan == 'Die Maintenance')
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                @else
                    <div class="modal-footer">
                        <a class="btn btn-secondary disabled" data-bs-dismiss="modal">Close</a>
                        <a class="btn btn-secondary disabled">Save</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</form>
