@extends('layouts.app')


@section('content')
    <div class="container-fluid">
        <div class="card border m-0">
            <div class="card-header py-2">
                <center>
                    <h3 class="card-title mb-0 p-0">FORM SPARE PART REPAIR</h3>
                </center>
            </div>
            <div class="card-content">
                <div class="card-body py-2">
                    <div class="list-group list-group-horizontal-sm my-1 py-0 text-center" role="tablist">
                        <a class="list-group-item list-group-item-action" id="list-sunday-list"
                            href="{{ route('partrepair.waitingtable.show', $waitingrepair->id) }}">Repair Ticket</a>
                        <a class="list-group-item list-group-item-action" id="list-monday-list"
                            href="{{ route('partrepair.waitingtable.show.form2', $waitingrepair->id) }}">Progress
                            Repair</a>
                        <a class="list-group-item list-group-item-action active" id="list-tuesday-list"
                            href="{{ route('partrepair.waitingtable.show.form3', $waitingrepair->id) }}">Seal Kit</a>
                        <a class="list-group-item list-group-item-action" id="list-4-list"
                            href="{{ route('partrepair.waitingtable.show.form4', $waitingrepair->id) }}">Trial</a>
                        <a class="list-group-item list-group-item-action" id="list-5-list"
                            href="{{ route('partrepair.waitingtable.show.form5', $waitingrepair->id) }}">Finish Repair</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-content text-justify py-2">
            <div class="tab-pane fade" id="list-sunday" role="tabpanel" aria-labelledby="list-sunday-list">
                {{-- @include('partrepair.form1') --}}
            </div>
            <div class="tab-pane fade" id="list-monday" role="tabpanel" aria-labelledby="list-monday-list">
                {{-- @include('partrepair.form2') --}}
            </div>
            <div class="tab-pane fade show active" id="list-tuesday" role="tabpanel" aria-labelledby="list-tuesday-list">
                @include('partrepair.form3')
            </div>
            <div class="tab-pane fade" id="list-4" role="tabpanel" aria-labelledby="list-4-list">
                {{-- @include('partrepair.form4') --}}
            </div>
            <div class="tab-pane fade" id="list-5" role="tabpanel" aria-labelledby="list-5-list">
                {{-- @include('partrepair.form5') --}}
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $(document).on('select2:open', () => {
                document.querySelector('.select2-search__field').focus();
            });

            // Javascript select2 via ajax (pertama)
            $('#isiotomatis2').select2({
                dropdownParent: $('#exampleModal'),
                placeholder: 'Cari Spare Part',
                width: '100%',
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
                            $('#isiotomatis2').select2('data', {
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

                            totalPrice()

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

            });

            // Mengosongkan nilai select2 dan input fields
            $('#storage').on('change', function() {
                $('#isiotomatis2').val(null).trigger('change');
                $('#item_name').val('');
                $('#item_code').val('');
                $('#description').val('');
                $('#price').val('');
                $('#qty').val('');
            });
        });

        $('#btnAutoMan').on('click', function() {
            var mode = $(this).text()
            if (mode == 'Man') {
                // Mode Auto
                $('#isiotomatis2').removeClass('disabledriko')

                // Javascript select2 via ajax (kedua)
                $('#isiotomatis2').select2({
                    dropdownParent: $('#exampleModal'),
                    placeholder: 'Cari Spare Part',
                    width: '100%',
                    disabled: false,
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
                                $('#isiotomatis2').select2('data', {
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
                $('#isiotomatis2').addClass('disabledriko')
                $('#isiotomatis2').select2({
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

    </script>

    <script>
        $('#price, #qty2').keyup(function() {
            totalPrice()
        });

        function totalPrice() {
            var price2 = parseFloat($('#price').val()) || 0;
            var qty2 = parseInt($('#qty2').val()) || 0;
            $('#total_price').val(price2 * qty2);
        }

        @foreach ($progresspemakaian as $req)
            $('#qty3{{ $req->id }}').on('input', function() {
                console.log('qty3'+{{ $req->id }})
                var price2 = parseFloat($('#price3{{ $req->id }}').val()) || 0;
                var qty2 = parseInt($('#qty3{{ $req->id }}').val()) || 0;
                $('#total_price2{{ $req->id }}').val(price2 * qty2);
            });
        @endforeach

    </script>

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
            $('#operation').on('change', function() {
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
            });

            function asuasu() {
                alert('ok');
            }
        });

        $(document).ready(function() {
            $('#ya').click(function() {
                $('#field3').css('display', 'flex');
                $('#fieldrepair').addClass("d-none");
                $('#fieldsealkit').removeClass("disabled");
            });
        });

        $(document).ready(function() {
            $('#tidak').click(function() {
                $('#field3').css('display', 'none');
                $('#fieldrepair').removeClass("d-none");
                $('#fieldsealkit').addClass("disabled");
            });
        });
    </script>

    <script>
        $('#status_partbaru').change(function() {
            var val = $(this).val();
            if (val === "Not Ready") {
                $('#notready').show();
            } else
                $('#notready').hide();
        });

        $('.status_partbaru_update').change(function() {
            var val = $(this).val();
            if (val === "Not Ready") {
                $('.status_partbaru_update_div').removeClass('d-none');
            } else
                $('.status_partbaru_update_div').addClass('d-none')
        });
    </script>

    <script>
        $('#judgement_scrap').change(function() {
            var val = $(this).val();
            if (val === "Scrap") {
                $('#scrap').show(),
                    $('#saveit').hide()
            } else
                $('#scrap').hide(),
                $('#saveit').show()
        });
    </script>

    <script>
        function categorycodeajax() {
            var category = $("#categorycodejs").val();
            $.ajax({
                type: 'GET',
                url: "{{ route('get-category') }}" + '/?category=' + category,
                // dataType: 'JSON',
                success: function(data) {
                    if (data.number == undefined) {
                        var code = 0;
                    } else {
                        var code = data.number;
                    };

                    x = (parseInt(code) + 1);
                    realcode = x.toString().padStart(3, '0');
                    $('#code_part_repair2').val(category + realcode);
                    $('#number').val(realcode);
                }
            });
        }
    </script>
@endsection
