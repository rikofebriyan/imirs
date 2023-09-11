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
                        <a class="list-group-item list-group-item-action active" id="list-sunday-list"
                            href="{{ route('partrepair.waitingtable.show', $waitingrepair->id) }}">Repair Ticket</a>
                        <a class="list-group-item list-group-item-action" id="list-monday-list"
                            href="{{ route('partrepair.waitingtable.show.form2', $waitingrepair->id) }}">Progress
                            Repair</a>
                        <a class="list-group-item list-group-item-action" id="list-tuesday-list"
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
            <div class="tab-pane fade show active" id="list-sunday" role="tabpanel" aria-labelledby="list-sunday-list">
                @include('partrepair.form1')
            </div>
            <div class="tab-pane fade" id="list-monday" role="tabpanel" aria-labelledby="list-monday-list">
                {{-- @include('partrepair.form2') --}}
            </div>
            <div class="tab-pane fade" id="list-tuesday" role="tabpanel" aria-labelledby="list-tuesday-list">
                {{-- @include('partrepair.form3') --}}
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
        function isi_otomatis() {
            var labour_id = $("#isiotomatis").val();
            var total_time_repair = $('#selisih').val()
            $.ajax({
                type: 'GET',
                url: "{{ route('get-labour') }}",
                data: "labour_id=" + labour_id,
                dataType: 'JSON',
                success: function(data) {
                    if (total_time_repair > 0 && data > 0) {
                        labourCost = total_time_repair * data

                        $('#labour_cost').val(labourCost);
                    }
                }
            });
        }

        function isi_otomatis_part() {
            var item_name = $("#isiotomatis2").val();
            $.ajax({
                type: 'GET',
                url: "{{ route('ajax') }}" + '/?item_name=' + item_name,
                dataType: 'JSON',
                success: function(data) {
                    $('#item_name2').val(data.item_name);
                    $('#item_code2').val(data.item_code);
                    $('#description2').val(data.description);
                    $('#price2').val(data.price);
                }
            });
        }

        function isi_otomatis_part2() {
            var item_name = $("#isiotomatis3").val();
            $.ajax({
                type: 'GET',
                url: "{{ route('ajax') }}" + '/?item_name=' + item_name,
                dataType: 'JSON',
                success: function(data) {
                    $('#item_name3').val(data.item_name);
                    $('#item_code3').val(data.item_code);
                    $('#description3').val(data.description);
                    $('#price3').val(data.price);
                }
            });
        }



        function isi_otomatis_subcont() {
            $.ajax({
                type: 'GET',
                url: "{{ route('get-subcont') }}",
                dataType: 'JSON',
                success: function(data) {
                    $('#subcont_name').empty()
                    $('#subcont_name').append(`<option value="" selected>Pilih ...</option>`)
                    $.each(data, function(id, value) {
                        $('#subcont_name').append(
                            `<option value="${value.id}">${value.name}</option>`)
                    });
                }
            });
        }
    </script>

    <script>
        $(function() {
            $("#datepicker2").datepicker();
            $("#datepicker").datepicker();
        });

        window.onload = function() {
            $('#datepicker2').on('change', function() {
                var dob = new Date(datepicker.value);
                var today = new Date(datepicker2.value);
                var age = ((today - dob) / (60 * 60 * 1000)).toFixed(1);
                $('#selisih').val(age);

                isi_otomatis()
            });
        }
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

@endsection
