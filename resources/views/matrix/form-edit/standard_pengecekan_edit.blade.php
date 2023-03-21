@extends('layouts.app')

@section('content')
    <CENTER>
        <div class="container-fluid">
            <H2>FORM EDIT STANDARD PENGECEKAN</H2>
        </div>
    </CENTER>

    <div class="card border-0 shadow rounded overflow-auto">
        <div class="card-body">
            <div class="container">
                <form action="{{ route('matrix.standard_pengecekan.edit', $data->id) }}" method="GET">
                    <input type="hidden" name="id" value="{{ $data->id }}">
                    <div class="form-group mt-2">
                        <label for="master_spare_part_id">Master Spare Part ID</label>
                        <select name="master_spare_part_id" id="master_spare_part_id"
                            class="form-control bg-secondary text-white">
                            <option value="" disabled>
                                choose
                            </option>
                            <option value="{{ $masterSparePart->id }}" selected>
                                {{ $masterSparePart->item_name }}
                            </option>
                        </select>
                    </div>

                    <div class="form-group mt-2">
                        <label for="item_pengecekan_id">Item Pengecekan ID</label>
                        <select name="item_pengecekan_id" id="item_pengecekan_id" class="form-control">
                            <option value="" disabled selected>
                                choose
                            </option>
                            @foreach ($itemPengecekan as $tabw)
                                <option value="{{ $tabw->id }}" @if ($data->item_pengecekan_id == $tabw->id) selected @endif>
                                    {{ $tabw->item_standard }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mt-2">
                        <label for="operation">operation</label>
                        <select class="form-select" name="operation" id="operation">
                            <option value="" disabled>Choose ...</option>
                            <option value="Equal" @if ($data->operation == 'Equal') selected @endif>Equal</option>
                            <option value="Less Than" @if ($data->operation == 'Less Than') selected @endif>Less Than</option>
                            <option value="Greater Than" @if ($data->operation == 'Greater Than') selected @endif>Greater Than
                            </option>
                            <option value="Between" @if ($data->operation == 'Between') selected @endif>Between</option>
                        </select>
                    </div>

                    <div id="standard_pengecekan_min_div" class="form-group mt-2">
                        <label for="standard_pengecekan_min">standard_pengecekan_min</label>
                        <input type="text" id="standard_pengecekan_min" name="standard_pengecekan_min"
                            class="form-control" value="{{ $data->standard_pengecekan_min }}">
                    </div>

                    <div id="standard_pengecekan_max_div" class="form-group mt-2">
                        <label for="standard_pengecekan_max">standard_pengecekan_max</label>
                        <input type="text" id="standard_pengecekan_max" name="standard_pengecekan_max"
                            class="form-control" value="{{ $data->standard_pengecekan_max }}">
                    </div>

                    <div class="form-group mt-2">
                        <label for="unit_measurement">unit_measurement</label>
                        <input type="text" id="unit_measurement" name="unit_measurement" class="form-control"
                            value="{{ $data->unit_measurement }}">
                    </div>

                    <div class="form-group mt-2">
                        <button type="submit" class="btn btn-primary">Perbarui Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            updateDiv()

            $('#operation').on('change', function() {
                updateDiv()
            });

            function updateDiv() {
                var operation = $('#operation option:selected').val()

                if (operation == 'Between') {
                    $('#standard_pengecekan_min_div').show()
                    $('#standard_pengecekan_max_div').show()
                } else if (operation == 'Less Than') {
                    $('#standard_pengecekan_min_div').hide()
                    $('#standard_pengecekan_max_div').show()
                } else if (operation == 'Greater Than') {
                    $('#standard_pengecekan_min_div').show()
                    $('#standard_pengecekan_max_div').hide()
                } else if (operation == 'Equal') {
                    $('#standard_pengecekan_min_div').show()
                    $('#standard_pengecekan_max_div').hide()
                } else {
                    $('#standard_pengecekan_min_div').hide()
                    $('#standard_pengecekan_max_div').hide()
                }
            }
        });
    </script>
@endsection
