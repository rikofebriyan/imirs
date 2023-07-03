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

        <form action="{{ route('partrepair.waitingtable.store') }}" method="POST">
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

                                {{-- <div class="form-group">
                                    <label for="select2">Pilih Opsi:</label>
                                    <select class="form-control select2" id="select2" name="opsi" style="width: 100%;">
                                        <option value="">Pilih Opsi</option>
                                    </select>
                                </div> --}}

                                {{-- Pemilihan Storage Item --}}
                                <div class="mb-3 row">
                                    <label for="storage" class="col-sm-3 col-form-label">Warehouse <sup
                                            class="text-danger">*</sup></label>
                                    <div class="col-sm-9">
                                        <select class="form-select" id="storage" name="storage" required>
                                            <option value="" selected>Pilih ...</option>
                                            <option value="1">Maintenance Spare Part</option>
                                            <option value="2">Tool Center</option>
                                            <option value="3">Tool Room</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3 row" id="field2" style="display: none">
                                    <label for="code_part_repair" class="col-sm-3 col-form-label">Code Part
                                        Repair <sup class="text-danger">*</sup></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control mb-3" placeholder="Input Kode Part Repair"
                                            id="code_part_repair" name="code_part_repair">

                                        <div class="input-group">
                                            <input type="text" class="form-control disabledriko" id="number_of_repair"
                                                name="number_of_repair" placeholder="Number of Repair" readonly>
                                            <label for="number_of_repair" class="col-sm-3 col-form-label ms-3">Times</label>
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
                                            <select class="form-control select2" id="isiotomatis" name="item_name">
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
                                            <input type="text" class="form-control col-9 disabledriko" id="item_code"
                                                name="item_code" placeholder="Item Code" readonly required>
                                        </div>

                                        <div class="input-group">
                                            <label for="item_name" class="col-sm-3 col-form-label">Item Name <sup
                                                    class="text-danger">*</sup></label>
                                            <input type="text" class="form-control col-9 disabledriko" id="item_name"
                                                name="item_name" placeholder="Item Name" readonly required>
                                        </div>

                                        <div class="input-group">
                                            <label for="item_type" class="col-sm-3 col-form-label">Description <sup
                                                    class="text-danger">*</sup></label>
                                            <input type="text" class="form-control col-9 disabledriko"
                                                id="description" name="item_type" placeholder="Item Type" readonly
                                                required>
                                        </div>

                                        <div class="input-group">
                                            <label for="price" class="col-sm-3 col-form-label">Price <sup
                                                    class="text-danger">*</sup></label>
                                            <input type="text" class="form-control number col-9 disabledriko"
                                                id="price" name="price" placeholder="Price" readonly required>
                                        </div>

                                        <div class="input-group">
                                            <label for="qty" class="col-sm-3 col-form-label">Stock <sup
                                                    class="text-danger">*</sup></label>
                                            <input type="text" class="form-control number col-9 disabledriko"
                                                id="qty" name="stock_spare_part" placeholder="Stock" readonly
                                                required>
                                        </div>
                                    </div>

                                </div>

                                <div class="mb-3 row">
                                    <label for="maker" class="col-sm-3 col-form-label">Maker & Type <sup
                                            class="text-danger">*</sup></label>
                                    <div class="col">
                                        <select class="form-control choices" id="maker" name="maker" required>
                                            <option selected disabled>Maker ...</option>
                                            @foreach ($maker as $mak)
                                                <option value="{{ $mak->name }}">{{ $mak->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col">
                                        <select class="form-control choices" id="type_of_part" name="type_of_part"
                                            required>
                                            <option selected disabled>Type Of Part ...</option>
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

                                <div class="mb-3 row">
                                    <label for="problem" class="col-sm-3 col-form-label">Problem <sup
                                            class="text-danger">*</sup></label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" id="problem" name="problem" rows="4" placeholder="Input Detail Problem"
                                            required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card col border m-2">
                            <div class="p-3">
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
                                        <select class="form-control choices" id="nama_pic" name="nama_pic" required>
                                            <option value="" selected disabled>Pilih ...</option>
                                            @foreach ($user as $us)
                                                @if ($us->jabatan != 'ADMIN' || 'Supervisor')
                                                    <option value="{{ $us->name }}">{{ $us->name }} |
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
                                            <option selected disabled>Pilih ...</option>
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

                                <button type="submit" id="btnSubmitFormInput"
                                    class="btn btn-md btn-primary">Save</button>
                                <a href="{{ route('partrepair.waitingtable.index') }}"
                                    class="btn btn-md btn-secondary">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>
@endsection
@section('script')
    <script>
        function formChoice(x) {
            if (x == 0) {
                $('#field2').css('display', 'none');
                $('#code_part_repair').val('')
                $('#number_of_repair').val('')
                $('#field3').removeClass('d-none')

                $('#item_code').val('')
                $('#item_name').val('')
                $('#description').val('')

                $('#price').val('')
                $('#qty').val('')

                getMaker()
                getTypeOfPart()
                return
            } else {
                $('#field2').css('display', 'flex');
                $('#field3').addClass('d-none')

                $('#item_code').val('')
                $('#item_name').val('')
                $('#description').val('')

                $('#price').val('')
                $('#qty').val('')

                getMaker()
                getTypeOfPart()
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
                    $('#maker').append(`<option selected disabled>Maker ...</option>`)
                    $.each(result, function(id, value) {
                        $('#maker').append('<option value="' + value.id + '">' +
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
                            '<option value="" disabled selected>Choose</option>')
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
                            '<option value="" disabled selected>Choose</option>')
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

                            $('#price').val(result['dataPart'].price)
                            $('#qty').val(result['dataPart'].qty)

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

                            if (result['dataPart'].qty == 0) {
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
                        }
                    }
                });
            });

            $('#btnAutoMan').on('click', function() {
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

                    $('#btnAutoMan').text('Auto')
                    $('#qty').addClass('btn-primary')
                    $('#btnAutoMan').removeClass('btn-warning')
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

                    $('#btnAutoMan').text('Man')
                    $('#qty').removeClass('btn-primary')
                    $('#btnAutoMan').addClass('btn-warning')
                }
            });
        });
    </script>
@endsection
