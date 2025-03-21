@extends('layouts.app')


@section('content')
    <div class="container-fluid">
        <div class="card border text-center mb-2">
            <h3 class="m-2">SPAREPART REPAIR REQUEST FORM</h3>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('partrepair.waitingtable.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="container-fluid justify-content-center py-0">
                <div class="container-fluid">
                    <div class="row gx-3">
                        <div class="card col border m-2">
                            <div class="p-3">
                                <input type="hidden" name="id" value="">

                                <div class="mb-3 row">
                                    <label for="tanggal" class="col-sm-3 col-form-label">Date Created <sup
                                            class="text-danger">*</sup></label>
                                    <div class="col-sm-9">
                                        <input type="datetime-local" class="form-control" id="tanggal" name="date"
                                            value="{{ Carbon\Carbon::now() }}" required>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="parts_from" class="col-sm-3 col-form-label">Apakah part pernah di
                                        repair?</label>
                                    <div class="col-sm-9 col-form-label">
                                        <div class="form-check-inline">
                                            <input class="form-check-input" type="radio" name="part_from"
                                                id="flexRadioDefault1" onclick="formChoice(0)" value="Belum Pernah Repair"
                                                checked>
                                            <label class="form-check-label" for="flexRadioDefault1">
                                                Belum Pernah Repair
                                            </label>
                                        </div>

                                        <div class="form-check-inline">
                                            <input class="form-check-input" type="radio" name="part_from"
                                                id="flexRadioDefault2" onclick="formChoice(1)" value="Pernah Repair">
                                            <label class="form-check-label" for="flexRadioDefault2">
                                                Pernah di Repair
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                {{-- Pemilihan Storage Item --}}
                                <div class="mb-3 row" id="storageDiv">
                                    <label for="storage" class="col-sm-3 col-form-label">Warehouse</label>
                                    <div class="col-sm-9">
                                        <select class="form-select" id="storage" name="storage">
                                            <option value="" selected>Pilih ...</option>
                                            <option value="1">Maintenance Spare Part</option>
                                            <option value="2">Tool Center</option>
                                            <option value="3">Tool Room</option>
                                            <option value="4">Maintenance Dies</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3 row" id="field2">
                                    <label for="code_part_repair" class="col-sm-3 col-form-label">Code Part
                                        Repair <sup class="text-danger">*</sup></label>
                                    <div class="col-sm-9">
                                        {{-- <input type="text" class="form-control mb-3" placeholder="Input Kode Part Repair"
                                            id="code_part_repair" name="code_part_repair"> --}}
                                        <select class="form-select" name="code_part_repair" id="code_part_repair">
                                            <option value="0" selected>Pilih ...</option>
                                            @foreach ($finishRepair as $data)
                                                <option value="{{ $data->code_part_repair }}">
                                                    {{ $data->code_part_repair }}|{{ $data->f_item_name }}|{{ $data->f_item_type }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <div class="input-group mt-4">
                                            <input type="text" class="form-control disabledriko" id="number_of_repair"
                                                name="number_of_repair" placeholder="Number of Repair" readonly>
                                            <label for="number_of_repair" class="col-sm-3 col-form-label ms-3">Times</label>
                                            <button id="btnAutoMan2" type="button"
                                                class="btn btn-primary ms-1">Auto</button>
                                            <div id="number_of_repairFeedback" class="invalid-feedback">
                                                Part Has Been Repaired Over 5 Times. Please Scrap!
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="item_code" class="col-sm-3 col-form-label">Spare Part</label>
                                    <div class="col-sm-9">
                                        <div id="field3" class="mb-3 d-flex">
                                            <select class="form-control" id="isiotomatis" name="item_name">
                                            </select>

                                            <button id="btnAutoMan" type="button"
                                                class="btn btn-primary ms-1">Auto</button>
                                        </div>

                                        <div class="input-group">
                                            <input type="hidden" class="form-control" name="item_id" id="item_id">
                                        </div>

                                        <div class="input-group">
                                            <label for="item_code" class="col-sm-3 col-form-label">Item Code <sup
                                                    class="text-danger">*</sup></label>
                                            <input type="text" class="form-control col-9 disabledriko rounded-1"
                                                id="item_code" name="item_code" placeholder="Item Code" readonly
                                                required>
                                        </div>

                                        <div class="input-group">
                                            <label for="item_name" class="col-sm-3 col-form-label">Item Name <sup
                                                    class="text-danger">*</sup></label>
                                            <input type="text" class="form-control col-9 disabledriko rounded-1"
                                                id="item_name" name="item_name" placeholder="Item Name" readonly
                                                required>
                                        </div>

                                        <div class="input-group">
                                            <label for="item_type" class="col-sm-3 col-form-label">Description <sup
                                                    class="text-danger">*</sup></label>
                                            <input type="text" class="form-control col-9 disabledriko rounded-1"
                                                id="description" name="item_type" placeholder="Item Type" readonly
                                                required>
                                        </div>

                                        <div class="input-group">
                                            <label for="price" class="col-sm-3 col-form-label">Price <sup
                                                    class="text-danger">*</sup></label>
                                            <input type="text" class="form-control number col-9 disabledriko rounded-1"
                                                id="price" name="price" placeholder="Price" readonly required>
                                        </div>

                                        <div class="input-group">
                                            <label for="qty" class="col-sm-3 col-form-label">Stock <sup
                                                    class="text-danger">*</sup></label>
                                            <input type="text" class="form-control number col-9 disabledriko rounded-1"
                                                id="qty" name="stock_spare_part" placeholder="Stock" readonly
                                                required>
                                        </div>
                                    </div>

                                </div>

                                <div class="mb-3 row">
                                    <label for="maker" class="col-sm-3 col-form-label">Maker & Type <sup
                                            class="text-danger">*</sup></label>
                                    <div class="col">
                                        <select class="form-control" id="maker" name="maker" required>
                                            <option value="" selected disabled>Maker ...</option>
                                            @foreach ($maker as $mak)
                                                <option value="{{ $mak->name }}">{{ $mak->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col">
                                        <select class="form-control" id="type_of_part" name="type_of_part" required>
                                            <option value="" selected disabled>Type Of Part ...</option>
                                            <option value="1">Mechanic</option>
                                            <option value="2">Hydraulic</option>
                                            <option value="3">Pneumatic</option>
                                            <option value="4">Electric</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="serial_number" class="col-sm-3 col-form-label">Serial Number</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="serial_number"
                                            name="serial_number" placeholder="(Kosongkan bila tidak ada serial number)">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card col border m-2">
                            <div class="p-3">
                                <div id="jenisPenggantian_div" class="mb-3 row">
                                    <label for="jenisPenggantian" class="col-sm-3 col-form-label">Jenis Penggantian <sup
                                            class="text-danger">*</sup></label>
                                    <div class="col-sm-9">
                                        <select class="form-select" id="jenisPenggantian" name="jenisPenggantian"
                                            required>
                                            <option value="" selected disabled>Pilih ...</option>
                                            <option value="Non MTBF">Non MTBF</option>
                                            <option value="MTBF">MTBF</option>
                                        </select>
                                    </div>
                                </div>

                                <div id="mauRekondisi_div" class="mb-3 row">
                                    <label for="mauRekondisi" class="col-sm-3 col-form-label">Mau Rekondisi <sup
                                            class="text-danger">*</sup></label>
                                    <div class="col-sm-9">
                                        <select class="form-select" id="mauRekondisi" name="mauRekondisi">
                                            <option value="" selected disabled>Pilih ...</option>
                                            <option value="Non Rekondisi">Non Rekondisi</option>
                                            <option value="Rekondisi">Rekondisi</option>
                                        </select>
                                    </div>
                                </div>

                                <div id="ReconditionSheet_div" class="mb-3 row">
                                    <label for="ReconditionSheet" class="col-sm-3 col-form-label">Recondition Sheet <sup
                                            class="text-danger">*</sup></label>
                                    <div class="col-sm-9">
                                        <input type="file" class="form-control" id="ReconditionSheet"
                                            name="ReconditionSheet" placeholder="Upload Recondition Sheet">
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="problem" class="col-sm-3 col-form-label">Problem <sup
                                            class="text-danger">*</sup></label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" id="problem" name="problem" rows="4" placeholder="Input Detail Problem"
                                            required></textarea>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="section" class="col-sm-3 col-form-label">Section <sup
                                            class="text-danger">*</sup></label>
                                    <div class="col-sm-9">
                                        <select class="form-select" id="section" name="section" required>
                                            <option selected disabled>Pilih ...</option>
                                            @foreach ($section as $sec)
                                                <option value="{{ $sec->id }}">{{ $sec->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="line" class="col-sm-3 col-form-label">Line <sup
                                            class="text-danger">*</sup></label>
                                    <div class="col-sm-9">
                                        <select class="form-select" id="lineline" name="line" required>
                                            <option value="" disabled selected>Pilih ...</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="machine" class="col-sm-3 col-form-label">Machine <sup
                                            class="text-danger">*</sup></label>
                                    <div class="col-sm-9">
                                        <select class="form-select" id="machine" name="machine" required>
                                            <option selected disabled>Pilih ...</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="nama_pic" class="col-sm-3 col-form-label">PIC User <sup
                                            class="text-danger">*</sup></label>
                                    <div class="col-sm-9">
                                        <select class="form-control" id="nama_pic" name="nama_pic" required>
                                            <option value="" selected disabled>Pilih ...</option>
                                            @foreach ($user as $us)
                                                @if ($us->jabatan != 'ADMIN' || 'Supervisor')
                                                    <option value="{{ $us->name }}">{{ $us->name }}
                                                        ({{ $us->jabatan }})
                                                        |
                                                        {{ $us->NPK }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="status_repair" class="col-sm-3 col-form-label">Status Repair <sup
                                            class="text-danger">*</sup></label>
                                    <div class="col-sm-9">
                                        <select class="form-control" id="status_repair" name="status_repair" required>
                                            <option value="" selected disabled>Pilih ...</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Urgent">Urgent</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="reg_sp" class="col-sm-3 col-form-label">Ticket Number <sup
                                            class="text-danger">*</sup></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control disabledriko" id="reg_sp"
                                            name="reg_sp" value="{{ $ticket }}" readonly required>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="progress" class="col-sm-3 col-form-label">Progress <sup
                                            class="text-danger">*</sup></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control disabledriko" id="progress"
                                            name="progress" value="Waiting" readonly required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid justify-content-center py-0">
                <div class="container-fluid">
                    <div class="card border text-center mb-2">
                        <div id="standardPengecekan_div" class="row">
                            <div class="col-9">
                                <h3 class="m-2">STANDARD</h3>
                            </div>
                            <div class="col-3">
                                <button id="importDataStandard" type="button" class="btn btn-primary m-2">Import
                                    Standard</button>
                            </div>
                        </div>

                        <div id="standardPengecekanform_div" class="row gx-3">
                            <div class="card col border m-2">
                                <table id="myTable" class="table table-striped nowrap overflow-scroll display">
                                    <thead>
                                        <tr>
                                            {{-- <th scope="col">Action</th> --}}
                                            <th scope="col">Check</th>
                                            <th scope="col">Item Pengecekan</th>
                                            <th scope="col">Unit Measurement</th>
                                            <th scope="col">Operation</th>
                                            <th scope="col">Standard</th>
                                        </tr>
                                    </thead>
                                    <tbody id="myTable_body">
                                        @forelse ($itemstandard as $tabw)
                                            <tr>
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value=""
                                                            id="standard{{ $tabw->id }}checkbox"
                                                            name="standard[{{ $tabw->id }}][checkbox]">
                                                        <input class="form-check-input" type="hidden" value="0"
                                                            id="standard{{ $tabw->id }}checkboxhidden"
                                                            name="standard[{{ $tabw->id }}][checkbox]" disabled>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="hidden"
                                                        name="standard[{{ $tabw->id }}][item_check_id]"
                                                        value="{{ $tabw->id }}">
                                                    <input type="text" class="form-control disabledriko"
                                                        name="standard[{{ $tabw->id }}][item_standard]"
                                                        id="" value="{{ $tabw->item_standard }}" readonly>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control disabledriko"
                                                        name="standard[{{ $tabw->id }}][unit_measurement]"
                                                        id="standard{{ $tabw->id }}unit_measurement"
                                                        value="{{ $tabw->unit_measurement }}" readonly>
                                                </td>
                                                <td>
                                                    <select name="standard[{{ $tabw->id }}][operation]"
                                                        id="standard{{ $tabw->id }}operation"
                                                        class="form-control disabledriko" readonly>
                                                        <option value="" selected>Choose ...</option>
                                                        <option value="Min">Min</option>
                                                        <option value="Max">Max</option>
                                                        <option value="Between">Between</option>
                                                        <option value="Equal">Equal</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control disabledriko"
                                                        name="standard[{{ $tabw->id }}][standard_pengecekan_min]"
                                                        id="standard{{ $tabw->id }}standard_pengecekan_min" readonly>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td class="text-center text-mute" colspan="6">Data post tidak tersedia
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="mt-2 mb-5">
                            @if ($loginUser->jabatan != null)
                                <button type="submit" id="btnSubmitFormInput" class="btn btn-md btn-primary">Save
                                    Ticket</button>
                                <a href="{{ route('partrepair.waitingtable.index') }}"
                                    class="btn btn-md btn-secondary">Back</a>
                            @else
                                <button type="submit" id="btnSubmitFormInput" class="btn btn-md btn-primary"
                                    disabled>Save
                                    Ticket</button>
                                <button href="{{ route('partrepair.waitingtable.index') }}"
                                    class="btn btn-md btn-secondary" disabled>Back</button>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>

    <div class="modal fade" id="modalAddPengecekan" tabindex="-1" aria-labelledby="modalAddPengecekanLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalAddPengecekanLabel">Add Item Pengecekan</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="form_input_id" value="">

                    <div class="form-group mt-2">
                        <label for="item_check_id">Item Check</label>
                        <select name="item_check_id" id="item_check_id" class="form-control">
                            <option value="" disabled selected>
                                Choose ...
                            </option>
                            @foreach ($itemstandard as $tabw)
                                <option value="{{ $tabw->id }}">{{ $tabw->item_standard }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mt-2">
                        <label for="operation">Operation</label>
                        <select name="operation" id="operation" class="form-control">
                            <option value="" disabled selected>Choose ...</option>
                            <option value="Min">Min</option>
                            <option value="Max">Max</option>
                            <option value="Between">Between</option>
                            <option value="Equal">Equal</option>
                        </select>
                    </div>

                    <div id="standard_pengecekan_min_div" class="form-group mt-2">
                        <label for="standard_pengecekan_min">Standard</label>
                        <input type="text" id="standard_pengecekan_min" name="standard_pengecekan_min"
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
@endsection

@section('script')
    <script>
        function formChoice(x) {
            if (x == 0) {
                $('#field2').addClass('d-none');
                $('#code_part_repair').val(0).trigger('change')
                $('#number_of_repair').val('')
                $('#field3').removeClass('d-none')

                $('#storageDiv').removeClass('d-none')

                $('#item_code').val('')
                $('#item_name').val('')
                $('#description').val('')

                $('#price').val('')
                $('#qty').val('')

                getMaker()
                // getTypeOfPart()
                return
            } else {
                $('#field2').removeClass('d-none');
                $('#field3').addClass('d-none')

                $('#storageDiv').addClass('d-none')

                $('#item_code').val('')
                $('#item_name').val('')
                $('#description').val('')

                $('#price').val('')
                $('#qty').val('')

                getMaker()
                // getTypeOfPart()
                return;
            }
        }

        function getMaker() {
            $.ajax({
                type: 'GET',
                url: "{{ route('get-maker') }}",
                dataType: 'JSON',
                success: function(result) {
                    $('#maker').empty()
                    $('#maker').append(`<option value="" selected disabled>Maker ...</option>`)
                    $.each(result, function(id, value) {
                        $('#maker').append('<option value="' + value.name + '">' +
                            value.name + '</option>');
                    });
                }
            });
        }

        function getTypeOfPart() {
            $.ajax({
                type: 'GET',
                url: "{{ route('get-type-of-part') }}",
                dataType: 'JSON',
                success: function(result) {
                    $('#type_of_part').empty()
                    $('#type_of_part').append(
                        `<option selected disabled>Type Of Part ...</option>`)
                    $.each(result, function(id, value) {
                        $('#type_of_part').append('<option value="' + id + '">' +
                            value + '</option>');
                    });
                }
            });
        }
    </script>
    <script type="text/javascript">
        $(document).ready(function() {

            $(document).on('select2:open', () => {
                document.querySelector('.select2-search__field').focus();
            });

            $('#section').select2()
            $('#lineline').select2()
            $('#machine').select2()

            // Javascript select2 via ajax (pertama)
            $('#isiotomatis').select2({
                placeholder: 'Cari Spare Part',
                ajax: {
                    url: "{{ route('get-storage') }}",
                    dataType: 'json',
                    data: function(params) {
                        var idstorage = $('#storage option:selected').val();
                        return {
                            storageId: idstorage,
                            itemName: params
                                .term // Mengirim nilai pencarian ke endpoint controller sebagai itemName
                        };
                    },
                    processResults: function(result) {
                        if (result.status.status == 'error') {
                            alert(result.status.message)
                            $('#isiotomatis').select2('data', {
                                id: null,
                                text: null
                            })
                            $('#storage').focus()
                        } else {
                            var options = result.data.map(function(item) {
                                var combinedText = item.itemName + ' | ' + item.ItemCode +
                                    ' | ' +
                                    item.description;
                                return {
                                    id: item.itemName,
                                    item_code: item.ItemCode,
                                    description: item.description,
                                    price: item.Price,
                                    stock: item.Stock,
                                    text: combinedText
                                };
                            });

                            return {
                                results: options
                            };
                        }
                    },

                    cache: true
                },
                minimumInputLength: 2, // Jumlah minimum karakter yang diperlukan sebelum pencarian dimulai
                dropdownAutoWidth: true // Mengaktifkan lebar dropdown otomatis
            }).on('select2:select', function(e) {
                var selectedItem = e.params.data;

                $('#item_name').val(selectedItem.id);
                $('#item_code').val(selectedItem.item_code);
                $('#description').val(selectedItem.description);
                $('#price').val(selectedItem.price);
                $('#qty').val(selectedItem.stock);

                if (selectedItem.stock == 0) {
                    $('#status_repair').empty()
                    $('#status_repair').append(`
                            <option disabled>Pilih ...</option>
                            <option value="Normal">Normal</option>
                            <option value="Urgent" selected>Urgent</option>
                        `)
                } else {
                    $('#status_repair').empty()
                    $('#status_repair').append(`
                            <option disabled>Pilih ...</option>
                            <option value="Normal" selected>Normal</option>
                            <option value="Urgent">Urgent</option>
                        `)
                }

            });

            $('#section').on('change', function() {
                var sectionId = $('#section option:selected').val()
                $.ajax({
                    type: 'GET',
                    url: "{{ route('get-line') }}" + '/?sectionId=' + sectionId,
                    dataType: 'JSON',
                    success: function(result) {
                        $('#lineline').empty()
                        $('#lineline').append(
                            '<option value="" disabled selected>Pilih ...</option>')
                        $.each(result, function(index, value) {
                            $('#lineline').append('<option value="' + value.id + '">' +
                                value.name + '</option>');
                        });
                    }
                });
            });

            $('#storage').on('change', function() {
                // Mengosongkan nilai select2 dan input fields
                $('#isiotomatis').val(null).trigger('change');
                $('#item_name').val('');
                $('#item_code').val('');
                $('#description').val('');
                $('#price').val('');
                $('#qty').val('');
            });


        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#lineline').on('change', function() {
                var lineId = $('#lineline option:selected').val()
                $.ajax({
                    type: 'GET',
                    url: "{{ route('get-machine') }}" + '/?lineId=' + lineId,
                    dataType: 'JSON',
                    success: function(result) {
                        $('#machine').empty()
                        $('#machine').append(
                            '<option value="" disabled selected>Pilih ...</option>')
                        $.each(result, function(id, value) {
                            $('#machine').append('<option value="' + value + '">' +
                                value + '</option>');
                        });
                    }
                });
            });

            $('#code_part_repair').on('input', function() {
                var codePartRepair = $('#code_part_repair').val()
                $.ajax({
                    type: 'GET',
                    url: "{{ route('get-number-of-repair') }}" + '/?codePartRepair=' +
                        codePartRepair,
                    dataType: 'JSON',
                    success: function(result) {
                        $('#number_of_repair').val(result['finishRepair'])
                        if (result['finishRepair'] > 5) {
                            $('#number_of_repair').addClass('is-invalid')
                            $('#btnSubmitFormInput').prop('disabled', true)
                        } else {
                            $('#number_of_repair').removeClass('is-invalid')
                            $('#btnSubmitFormInput').prop('disabled', false)

                            $('#item_code').val(result['dataRepair'].item_code)
                            $('#item_name').val(result['dataRepair'].item_name)
                            $('#description').val(result['dataRepair'].item_type)

                            $('#price').val(result['dataRepair'].price)
                            $('#qty').val(result['dataRepair'].stock_spare_part)

                            $('#maker').empty()
                            $('#type_of_part').empty()
                            $('#maker').append(`<option disabled>Maker ...</option>`)
                            $('#type_of_part').append(
                                `<option disabled>Type Of Part ...</option>`)

                            $.each(result['maker'], function(id, data) {
                                if (data.id == result['dataRepair'].maker) {
                                    selected = 'selected'
                                } else {
                                    selected = ''
                                }
                                $('#maker').append(`<option value="${data.id}" ` +
                                    selected + `>${data.name}</option>`)
                            });

                            $.each(result['typeOfPart'], function(id, part) {
                                if (part == result['dataRepair'].type_of_part) {
                                    selected = 'selected'
                                } else {
                                    selected = ''
                                }
                                $('#type_of_part').append(`<option value="${id}" ` +
                                    selected + `>${part}</option>`)
                            });
                        }
                    }
                });
            });

            $('#btnAutoMan, #btnAutoMan2').on('click', function() {
                var mode = $(this).text()
                if (mode == 'Man') {
                    // Mode Auto
                    // Javascript select2 via ajax (kedua)
                    $('#isiotomatis').select2({
                        disabled: false,
                        placeholder: 'Cari Spare Part',
                        ajax: {
                            url: "{{ route('get-storage') }}",
                            dataType: 'json',
                            data: function(params) {
                                var idstorage = $('#storage option:selected').val();
                                return {
                                    storageId: idstorage,
                                    itemName: params
                                        .term // Mengirim nilai pencarian ke endpoint controller sebagai itemName
                                };
                            },
                            processResults: function(result) {
                                if (result.status.status == 'error') {
                                    alert(result.status.message)
                                    $('#isiotomatis').select2('data', {
                                        id: null,
                                        text: null
                                    })
                                    $('#storage').focus()
                                } else {
                                    var options = result.data.map(function(item) {
                                        var combinedText = item.itemName + ' | ' + item
                                            .ItemCode + ' | ' +
                                            item.description;
                                        return {
                                            id: item.itemName,
                                            item_code: item.ItemCode,
                                            description: item.description,
                                            price: item.Price,
                                            stock: item.Stock,
                                            text: combinedText
                                        };
                                    });

                                    return {
                                        results: options
                                    };
                                }
                            },

                            cache: true
                        },
                        minimumInputLength: 2, // Jumlah minimum karakter yang diperlukan sebelum pencarian dimulai
                        dropdownAutoWidth: true // Mengaktifkan lebar dropdown otomatis
                    });

                    $('#item_code').addClass('disabledriko')
                    $('#item_code').prop('readonly', true)

                    $('#item_name').addClass('disabledriko')
                    $('#item_name').prop('readonly', true)

                    $('#description').addClass('disabledriko')
                    $('#description').prop('readonly', true)

                    $('#price').addClass('disabledriko')
                    $('#price').prop('readonly', true)

                    $('#qty').addClass('disabledriko')
                    $('#qty').prop('readonly', true)
                    $('#qty').addClass('btn-primary')

                    $('#btnAutoMan').text('Auto')
                    $('#btnAutoMan').removeClass('btn-warning')
                    $('#btnAutoMan2').text('Auto')
                    $('#btnAutoMan2').removeClass('btn-warning')
                } else if (mode == 'Auto') {

                    // Mode Manual
                    $('#isiotomatis').addClass('disabledriko')
                    $('#isiotomatis').select2({
                        disabled: true
                    })

                    $('#item_code').removeClass('disabledriko')
                    $('#item_code').prop('readonly', false)

                    $('#item_name').removeClass('disabledriko')
                    $('#item_name').prop('readonly', false)

                    $('#description').removeClass('disabledriko')
                    $('#description').prop('readonly', false)

                    $('#price').removeClass('disabledriko')
                    $('#price').prop('readonly', false)

                    $('#qty').removeClass('disabledriko')
                    $('#qty').prop('readonly', false)
                    $('#qty').removeClass('btn-primary')

                    $('#btnAutoMan').text('Man')
                    $('#btnAutoMan').addClass('btn-warning')
                    $('#btnAutoMan2').text('Man')
                    $('#btnAutoMan2').addClass('btn-warning')
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // $('#myTable').DataTable();
            $('#nama_pic').select2();
            $('#maker').select2();
            $('#type_of_part').select2();
            $('#code_part_repair').select2();
            formChoice(0);
            $('#mauRekondisi_div').hide();
            $('#ReconditionSheet_div').hide();
            checkCheckbox();

            $('#item_check_id').on('change', function() {
                var itemCheck = $(this).val()

                $.ajax({
                    type: 'GET',
                    url: "{{ route('get-unit-measurement') }}" + '/?id=' + itemCheck,
                    success: function(result) {
                        console.log(result)
                        $('#unit_measurement').val(result.unit_measurement)
                    }
                });
            });

            $('#jenisPenggantian').on('change', function() {
                var jenisPenggantian = $(this).val()

                if (jenisPenggantian == 'MTBF') {
                    $('#mauRekondisi_div').show()
                    $('#mauRekondisi').prop('required', true)
                } else {
                    $('#mauRekondisi').prop('required', false)
                    $('#mauRekondisi_div').hide()
                }
            });

            $('#mauRekondisi').on('change', function() {
                var mauRekondisi = $(this).val()

                if (mauRekondisi == 'Non Rekondisi') {
                    $('#ReconditionSheet_div').show();
                    $('#ReconditionSheet').prop('required', true)
                } else {
                    $('#ReconditionSheet_div').hide();
                    $('#ReconditionSheet').prop('required', false)
                }
            });

            @forelse ($itemstandard as $tabw)
                $('#standard{{ $tabw->id }}checkbox').on('change', function() {
                    if ($(this).is(":checked")) {
                        checkCheckbox()
                    } else {
                        checkCheckbox()
                    }
                });
            @empty
            @endforelse

            function checkCheckbox() {
                var i = 0;
                @foreach ($itemstandard as $tabw)
                    if ($('#standard{{ $tabw->id }}checkbox').is(':checked')) {
                        i++;
                        $('#standard{{ $tabw->id }}checkbox').val('1')
                        $('#standard{{ $tabw->id }}checkboxhidden').prop('disabled', true)

                        $('#standard{{ $tabw->id }}unit_measurement').prop('readonly', false)
                        $('#standard{{ $tabw->id }}unit_measurement').removeClass('disabledriko')

                        $('#standard{{ $tabw->id }}operation').prop('readonly', false)
                        $('#standard{{ $tabw->id }}operation').removeClass('disabledriko')

                        $('#standard{{ $tabw->id }}standard_pengecekan_min').prop('readonly', false)
                        $('#standard{{ $tabw->id }}standard_pengecekan_min').removeClass(
                            'disabledriko')
                    } else {
                        $('#standard{{ $tabw->id }}checkbox').val('0')
                        $('#standard{{ $tabw->id }}checkboxhidden').prop('disabled', false)

                        $('#standard{{ $tabw->id }}unit_measurement').prop('readonly', true)
                        $('#standard{{ $tabw->id }}unit_measurement').addClass('disabledriko')

                        $('#standard{{ $tabw->id }}operation').prop('readonly', true)
                        $('#standard{{ $tabw->id }}operation').addClass('disabledriko')

                        $('#standard{{ $tabw->id }}standard_pengecekan_min').prop('readonly', true)
                        $('#standard{{ $tabw->id }}standard_pengecekan_min').addClass('disabledriko')
                    }
                @endforeach

                var totalDataStandard = {{ $itemstandard->count() }};

                if (i == 0) {
                    $('#btnSubmitFormInput').addClass('disabled')
                } else {
                    $('#btnSubmitFormInput').removeClass('disabled')
                }
            }

            $('#importDataStandard').on('click', function() {
                var itemCode = $('#item_code').val();

                if (itemCode != '') {
                    $.ajax({
                        type: 'GET',
                        url: "{{ route('get-standard-pengecekan') }}" + '/?itemCode=' + itemCode,
                        dataType: 'JSON',
                        success: function(result) {
                            console.log(result)
                            if (result.status == 'success') {
                                $('#myTable_body').empty()

                                $.each(result.data, function(index, x) {
                                    if (x.operation == 'Min') {
                                        var optionMin = 'selected';
                                    } else {
                                        var optionMin = '';
                                    }
                                    if (x.operation == 'Max') {
                                        var optionMax = 'selected';
                                    } else {
                                        var optionMax = '';
                                    }
                                    if (x.operation == 'Between') {
                                        var optionBetween = 'selected';
                                    } else {
                                        var optionBetween = '';
                                    }
                                    if (x.operation == 'Equal') {
                                        var optionEqual = 'selected';
                                    } else {
                                        var optionEqual = '';
                                    }

                                    if (x.operation != null || x
                                        .standard_pengecekan_min != null) {
                                        $('#myTable_body').append(`
                                            <tr>
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value=""
                                                            id="standard${index}checkbox"
                                                            name="standard[${index}][checkbox]" checked>
                                                        <input class="form-check-input" type="hidden" value="0"
                                                            id="standard${index}checkboxhidden"
                                                            name="standard[${index}][checkbox]" disabled>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="hidden"
                                                        name="standard[${index}][item_check_id]"
                                                        value="${index}">
                                                    <input type="text" class="form-control disabledriko"
                                                        name="standard[${index}][item_standard]"
                                                        id="" value="${x.item_standard}" readonly>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control disabledriko"
                                                        name="standard[${index}][unit_measurement]"
                                                        id="standard${index}unit_measurement"
                                                        value="${x.unit_measurement}">
                                                </td>
                                                <td>
                                                    <select name="standard[${index}][operation]"
                                                        id="standard${index}operation"
                                                        class="form-control disabledriko" readonly>
                                                        <option value="">Choose ...</option>
                                                        <option value="Min" ${optionMin}>Min</option>
                                                        <option value="Max" ${optionMax}>Max</option>
                                                        <option value="Between" ${optionBetween}>Between</option>
                                                        <option value="Equal" ${optionEqual}>Equal</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control disabledriko"
                                                        name="standard[${index}][standard_pengecekan_min]"
                                                        id="standard${index}standard_pengecekan_min" value="${x.standard_pengecekan_min}">
                                                </td>
                                            </tr>
                                        `);

                                        checkCheckbox()
                                    } else {
                                        $('#myTable_body').append(`
                                            <tr>
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value=""
                                                            id="standard${index}checkbox"
                                                            name="standard[${index}][checkbox]">
                                                        <input class="form-check-input" type="hidden" value="0"
                                                            id="standard${index}checkboxhidden"
                                                            name="standard[${index}][checkbox]">
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="hidden"
                                                        name="standard[${index}][item_check_id]"
                                                        value="${index}">
                                                    <input type="text" class="form-control disabledriko"
                                                        name="standard[${index}][item_standard]"
                                                        id="" value="${x.item_standard}" readonly>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control disabledriko"
                                                        name="standard[${index}][unit_measurement]"
                                                        id="standard${index}unit_measurement"
                                                        value="${x.unit_measurement}" readonly>
                                                </td>
                                                <td>
                                                    <select name="standard[${index}][operation]"
                                                        id="standard${index}operation"
                                                        class="form-control disabledriko" readonly>
                                                        <option value="" selected>Choose ...</option>
                                                        <option value="Min">Min</option>
                                                        <option value="Max">Max</option>
                                                        <option value="Between">Between</option>
                                                        <option value="Equal">Equal</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control disabledriko"
                                                        name="standard[${index}][standard_pengecekan_min]"
                                                        id="standard${index}standard_pengecekan_min" readonly>
                                                </td>
                                            </tr>
                                        `);
                                    }

                                    $(`#standard` + index + `checkbox`).on(
                                        'change',
                                        function() {
                                            if ($(this).is(":checked")) {
                                                checkCheckbox()
                                            } else {
                                                checkCheckbox()
                                            }
                                        });
                                });
                            } else {
                                alert('Data Tidak Ditemukan')

                                $('#myTable_body').empty()
                                $.each(result.data, function(index, x) {
                                    $('#myTable_body').append(`
                                            <tr>
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value=""
                                                            id="standard${x.id}checkbox"
                                                            name="standard[${x.id}][checkbox]">
                                                        <input class="form-check-input" type="hidden" value="0"
                                                            id="standard${x.id}checkboxhidden"
                                                            name="standard[${x.id}][checkbox]">
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="hidden"
                                                        name="standard[${x.id}][item_check_id]"
                                                        value="${x.id}">
                                                    <input type="text" class="form-control disabledriko"
                                                        name="standard[${x.id}][item_standard]"
                                                        id="" value="${x.item_standard}" readonly>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control disabledriko"
                                                        name="standard[${x.id}][unit_measurement]"
                                                        id="standard${x.id}unit_measurement"
                                                        value="${x.unit_measurement}" readonly>
                                                </td>
                                                <td>
                                                    <select name="standard[${x.id}][operation]"
                                                        id="standard${x.id}operation"
                                                        class="form-control disabledriko" readonly>
                                                        <option value="" selected>Choose ...</option>
                                                        <option value="Min">Min</option>
                                                        <option value="Max">Max</option>
                                                        <option value="Between">Between</option>
                                                        <option value="Equal">Equal</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control disabledriko"
                                                        name="standard[${x.id}][standard_pengecekan_min]"
                                                        id="standard${x.id}standard_pengecekan_min" readonly>
                                                </td>
                                            </tr>
                                        `);

                                    $(`#standard` + x.id + `checkbox`).on(
                                        'change',
                                        function() {
                                            if ($(this).is(":checked")) {
                                                checkCheckbox()
                                            } else {
                                                checkCheckbox()
                                            }
                                        });
                                });
                            }
                        },
                    });
                } else {
                    alert('Item Code Belum Diisi!!!');
                }
            });

        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            var jabatan = "{{ $userLogin->jabatan }}"

            if (jabatan == 'Die Maintenance') {
                $('#jenisPenggantian_div').addClass('d-none')
                $('#standardPengecekan_div').addClass('d-none')
                $('#standardPengecekanform_div').addClass('d-none')
                $('#btnSubmitFormInput').removeClass('disabled')
                $('#jenisPenggantian').prop('required', false)
            } else {
                $('#jenisPenggantian_div').removeClass('d-none')
                $('#standardPengecekan_div').removeClass('d-none')
                $('#standardPengecekanform_div').removeClass('d-none')
                $('#btnSubmitFormInput').addClass('disabled')
                $('#jenisPenggantian').prop('required', true)
            }
        });
    </script>
@endsection
