@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/timeline.css') }}">
    <style>
        .apexcharts-toolbar {
            position: absolute;
            right: auto;
            left: 10px;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-7 card border text-center mb-2 ">
            <h3 class="m-2">GANTT CHART SCHEDULE REPAIR</h3>
        </div>
        <div class="col card border text-center mb-2  d-flex d-inline justify-content-center">
            <div>Delay : <span class="badge rounded-pill border border-dark"
                    style="background-color: #FF6d78; color:#FF6d78">FFFFFF</span>
                On Schedule : <span class="badge rounded-pill border border-dark"
                    style="background-color: #58bdff; color:#58bdff">FFFFFF</span>
                Re-Schedule : <span class="badge rounded-pill border border-dark"
                    style="background-color: #aa9958; color:#aa9958">FFFFFF</span>
            </div>
        </div>
    </div>

    <div class="row m-1" style="transition: width 0.5s">
        <div class="card col border" style="transition: width 0.5s;">
            <div id="gantt" class="m-2" style="transition: width 0.5s">
            </div>
        </div>
        <div class="card col-4 border mx-2 small" id="asu"
            style="display: none; transition:width 0.5s; min-height:1000px; position: fixed; right:0; top:0;">
            <div class="p-3">
                <div class="row d-flex justify-content-between align-items-center">
                    <div class="col d-flex justify-content-between">
                        <a href="#" type="button" id="hideshow" class="btn icon icon-left btn-light border"><i
                                data-feather="x"></i>
                            Hide</a>
                    </div>
                    <div class="col d-flex justify-content-between align-items-center">
                        <h4 class="m-0">Repair Details</h4>
                    </div>
                </div>

                <hr class="m-2">

                <div class="card">
                    <div class="flex-parent">
                        <div class="input-flex-container">
                            <input type="radio" name="timeline-dot" data-description="1910" id="waiting">
                            <div class="dot-info" data-description="1910">
                                <span class="year">Waiting</span>
                            </div>
                            <input type="radio" name="timeline-dot" data-description="1920" id="progress2">
                            <div class="dot-info" data-description="1920">
                                <span class="year">Progress</span>
                            </div>
                            <input type="radio" name="timeline-dot" data-description="1930" id="sealkit">
                            <div class="dot-info" data-description="1930">
                                <span class="year">Order</span>
                            </div>
                            <input type="radio" name="timeline-dot" data-description="1940" id="trial">
                            <div class="dot-info" data-description="1940">
                                <span class="year">Trial</span>
                            </div>
                            <input type="radio" name="timeline-dot" data-description="1950" id="finish">
                            <div class="dot-info" data-description="1950">
                                <span class="year">Finish</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <label for="disabledInput" class="col-sm-3 col-form-label p-1">No. Ticket</label>
                    <p class="col-sm-9 align-items-center d-flex m-0 p-1" id="reg_sp"></p>
                </div>

                <div class="row">
                    <label for="disabledInput" class="col-sm-3 col-form-label p-1">PIC Repair</label>
                    <p class="col-sm-9 align-items-center d-flex m-0 p-1" id="nama_pic"></p>
                </div>

                <div class="row">
                    <label for="disabledInput" class="col-sm-3 col-form-label p-1">Item Name</label>
                    <p class="col-sm-9 align-items-center d-flex m-0 p-1" id="item_name"></p>
                </div>

                <div class="row">
                    <label for="disabledInput" class="col-sm-3 col-form-label p-1">Progress</label>
                    <p class="col-sm-9 align-items-center d-flex m-0 p-1" id="progress"></p>
                </div>

                <div class="row">
                    <label for="disabledInput" class="col-sm-3 col-form-label p-1">Repair Place</label>
                    <p class="col-sm-9 align-items-center d-flex m-0 p-1" id="place_of_repair"></p>
                </div>

                <div class="divider m-0">
                    <div class="divider-text">Problem</div>
                </div>

                <div class="row">
                    <label for="disabledInput" class="col-sm-3 col-form-label p-1">Problem</label>
                    <p class="col-sm-9 align-items-center d-flex m-0 p-1" id="problem"></p>
                </div>

                <div class="row">
                    <label for="disabledInput" class="col-sm-3 col-form-label p-1">Analisa</label>
                    <p class="col-sm-9 align-items-center d-flex m-0 p-1" id="analisa"></p>
                </div>

                <div class="row">
                    <label for="disabledInput" class="col-sm-3 col-form-label p-1">Action</label>
                    <p class="col-sm-9 align-items-center d-flex m-0 p-1" id="action"></p>
                </div>


                <div class="divider m-0">
                    <div class="divider-text">Cost</div>
                </div>

                <div class="row">
                    <label for="disabledInput" class="col-sm-3 col-form-label p-1">Cost</label>
                    <p class="col-sm-9 align-items-center d-flex m-0 p-1" id="price"></p>
                </div>

                <div class="divider m-0">
                    <div class="divider-text">Plan</div>
                </div>

                <div class="row">
                    <label for="disabledInput" class="col-sm-3 col-form-label p-1">Plan Start</label>
                    <p class="col-sm-9 align-items-center d-flex m-0 p-1" id="plan_start_repair"></p>
                </div>

                <div class="row">
                    <label for="disabledInput" class="col-sm-3 col-form-label p-1">Plan Revision</label>
                    <p class="col-sm-9 align-items-center d-flex m-0 p-1" id="plan_start_revision"></p>
                </div>

                <div class="row">
                    <label for="disabledInput" class="col-sm-3 col-form-label p-1">Delay Reason</label>
                    <p class="col-sm-9 align-items-center d-flex m-0 p-1" id="reason_delay"></p>
                </div>

                <div class="row">
                    <label for="disabledInput" class="col-sm-3 col-form-label p-1">Revisi Reason</label>
                    <p class="col-sm-9 align-items-center d-flex m-0 p-1" id="reason_revision"></p>
                </div>

                <div class="row m-1">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-danger col m-1" data-bs-toggle="modal"
                        data-bs-target="#exampleModal2">
                        Delay Reason
                    </button>
                    <button type="button" class="btn btn-primary col m-1" data-bs-toggle="modal"
                        data-bs-target="#exampleModal1">
                        Revision Plan
                    </button>

                </div>

            </div>
        </div>
    </div>
    </div>

    <!-- Modal -->

    <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Revision Planning</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form method="POST" action="">
                        @csrf
                        @method('PUT')
                        {{-- <input type="hidden" name="_method" value="PATCH"> --}}
                        <input type="hidden" class="form-control" name="id" value="">

                        <div class="mb-3 row d-flex justify-content-between align-items-center">
                            <label for="plan_start_revision" class="col-sm-3 col-form-label">Plan Start
                                Revision</label>
                            <div class="col-sm-9">
                                <input type="datetime-local" class="form-control" name="plan_start_revision"
                                    id="plan_start_revision" value="">
                            </div>
                        </div>
                        <div class="mb-3 row d-flex justify-content-between align-items-center">
                            <label for="plan_finish_revision" class="col-sm-3 col-form-label">Plan Finish
                                Revision</label>
                            <div class="col-sm-9">
                                <input type="datetime-local" class="form-control" name="plan_finish_revision"
                                    id="plan_finish_revision" value="">
                            </div>
                        </div>
                        <div class="mb-3 row d-flex justify-content-between align-items-center">
                            <label for="reason_revision" class="col-sm-3 col-form-label">Alasan Revisi?</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="reason_revision" name="reason_revision" rows="3"
                                    placeholder="Tulis Alasan Disini" required></textarea>
                            </div>
                        </div>





                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Alasan Delay</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form method="POST" action="">
                        @csrf
                        @method('PUT')
                        {{-- <input type="hidden" name="_method" value="PATCH"> --}}
                        <input type="hidden" class="form-control" name="id" value="">

                        <div class="mb-3 row d-flex justify-content-between align-items-center">
                            <label for="reason_delay" class="col-sm-3 col-form-label">Alasan Delay?</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="reason_delay" name="reason_delay" rows="3"
                                    placeholder="Tulis Alasan Disini" required></textarea>
                            </div>
                        </div>





                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('assets/extensions/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/ui-apexchart.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/axios.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script>
        jQuery(document).ready(function() {
            jQuery('#hideshow').on('click', function(event) {
                jQuery('#asu').toggle('hide');
            });
        });
    </script>
    <script></script>
    <script>
        var data =
            <?php echo json_encode($data); ?>;


        var options = {
            series: [{
                    name: 'Plan',
                    data: [
                        @foreach ($data as $index => $dt)
                            {
                                x: '{{ $index + 1 }}.{{ $dt['nama_pic'] . ' | ' . $dt['item_name'] }}',
                                y: [
                                    new Date('{{ $dt['plan_start_repair'] }}').getTime(),
                                    new Date('{{ $dt['plan_finish_repair'] }}').getTime()
                                ],
                                fillColor: '{{ $dt['fillcolor'] }}',
                            },
                        @endforeach
                        @foreach ($data as $index => $dt)
                            {
                                x: '{{ $index + 1 }}.{{ $dt['nama_pic'] . ' | ' . $dt['item_name'] }}',
                                y: [
                                    new Date('{{ $dt['plan_start_revision'] }}').getTime(),
                                    new Date('{{ $dt['plan_finish_revision'] }}').getTime()
                                ],
                                fillColor: '{{ $dt['fillcolorrev'] }}'
                            },
                        @endforeach
                    ]

                },

            ],
            chart: {
                height: ({{ $count }} * 40) + 100,
                type: 'rangeBar',
                offsetY: '15',
                events:

                {
                    dataPointSelection: function(event, chartContext, config) {
                        var count = {{ $count }};
                        if (config.dataPointIndex >= count) {
                            var datapoint = config.dataPointIndex - count;
                        } else {
                            var datapoint = config.dataPointIndex;
                        };
                        // console.log(data[datapoint]);



                        $('#exampleModal1').on('show.bs.modal', function(event) {
                            var id = data[datapoint].id;
                            var modal = $("#exampleModal1");
                            var form = modal.find('form');
                            modal.find('form').attr('action',
                                "{{ route('partrepair.progress.revision', ':id') }}".replace(
                                    /:id\/?/,
                                    id));
                            modal.find('form').find('input[name="id"]').val(data[datapoint].id);
                            modal.find('form').find('input[name="plan_start_revision"]').val(data[
                                datapoint].plan_finish_repair);
                            modal.find('form').find('input[name="plan_finish_revision"]').val(data[
                                    datapoint]
                                .plan_finish_repair);


                        });

                        $('#exampleModal2').on('show.bs.modal', function(event) {
                            var id = data[datapoint].id;
                            var modal = $("#exampleModal2");
                            var form = modal.find('form');
                            modal.find('form').attr('action',
                                "{{ route('partrepair.progress.delay', ':id') }}".replace(
                                    /:id\/?/,
                                    id));
                            modal.find('form').find('input[name="id"]').val(data[datapoint].id);


                        });



















                        $('#asu').show(300);
                        $('#reg_sp').text(data[datapoint].reg_sp);
                        $('#reg_sp').html(
                            `<a href="{{ url('partrepair/waitingtable/') }}/` + data[
                                datapoint].id + `">` + data[datapoint]
                            .reg_sp +
                            '</a>');
                        $('#created_at').text(data[datapoint].created_at);
                        $('#updated_at').text(data[datapoint].updated_at);
                        $('#date').text(data[datapoint].date);
                        $('#nama_pic').text(data[datapoint].nama_pic);
                        $('#item_name').text(data[datapoint].item_name);
                        $('#date').text(data[datapoint].date);
                        $('#part_from').text(data[datapoint].part_from);
                        $('#section').text(data[datapoint].section);
                        $('#line').text(data[datapoint].line);
                        $('#machine').text(data[datapoint].machine);
                        $('#item_code').text(data[datapoint].item_code);
                        $('#item_type').text(data[datapoint].item_type);
                        $('#maker').text(data[datapoint].maker);
                        $('#problem').text(data[datapoint].problem);
                        $('#price').text(data[datapoint].price);
                        $('#place_of_repair').text(data[datapoint]
                            .place_of_repair);
                        $('#status_repair').text(data[datapoint].status_repair);
                        $('#progress').text(data[datapoint].progress);
                        $('#item_type').text(data[datapoint].item_type);
                        $('#analisa').text(data[datapoint].analisa);
                        $('#action').text(data[datapoint].action);
                        $('#id').text(data[datapoint].progressid);
                        $('#plan_start_repair').text(moment(data[datapoint]
                            .plan_start_repair).format('DD-MMM-YYYY') + '  s/d  ' + moment(data[
                                datapoint]
                            .plan_finish_repair).format('DD-MMM-YYYY'));

                        if (data[datapoint].plan_start_revision == null) {
                            $('#plan_start_revision').text("--");
                        } else {
                            $('#plan_start_revision').text(moment(data[datapoint]
                                .plan_start_revision).format('DD-MMM-YYYY') + '  s/d  ' + moment(data[
                                    datapoint]
                                .plan_finish_revision).format('DD-MMM-YYYY'));
                        }



                        if (data[datapoint].reason_delay == null) {
                            $('#reason_delay').text("--");
                        } else {
                            $('#reason_delay').text(data[datapoint].reason_delay);
                        }

                        if (data[datapoint].reason_revision == null) {
                            $('#reason_revision').text("--");
                        } else {
                            $('#reason_revision').text(data[datapoint].reason_revision);
                        }


                        $('#item_type').text(data[datapoint].item_type);


                        if (data[datapoint].progress == "Finish") {
                            $('#finish').prop("checked", true);
                        } else if (data[datapoint].progress == "Trial") {
                            $('#trial').prop("checked", true);
                        } else if (data[datapoint].progress == "Seal Kit") {
                            $('#sealkit').prop("checked", true);
                        } else if (data[datapoint].progress == "On Progress") {
                            $('#progress2').prop("checked", true);
                        } else {
                            $('#waiting').prop("checked", true);
                        }
                    }
                }
            },
            dataLabels: {
                enabled: true,
                textAnchor: 'start',
                formatter: function(val) {
                    var a = new Date(val[0]).getTime();
                    var b = new Date(val[1]).getTime();
                    var diff = Math.ceil((b - a) / (1000 * 3600 * 24));
                    if (diff >= 1) {
                        return diff + (diff > 1 ? ' days' : ' day');
                    } else {
                        return ''
                    }

                },
                offsetX: 0,
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'light',
                    type: 'vertical',
                    shadeIntensity: 0.25,
                    gradientToColors: undefined,
                    inverseColors: true,
                    opacityFrom: 1,
                    opacityTo: 1,
                    stops: [50, 0, 100, 100]
                }
            },
            plotOptions: {
                bar: {
                    horizontal: true
                }

            },
            legend: {
                position: 'bottom'
            },
            xaxis: {
                type: 'datetime',
                position: 'top',
            },
            toolbar: {
                show: true,
            },
            grid: {
                show: true,
                xaxis: {
                    lines: {
                        show: true
                    }
                },
                yaxis: {
                    lines: {
                        show: true
                    }
                }
            },
            yaxis: {
                labels: {
                    style: {
                        fontSize: '12px', // ukuran font label
                        lineHeight: '10000px', // jarak antara baris
                    },
                },
            },
            annotations: {

                xaxis: [{
                    x: new Date().getTime(),
                    borderColor: "#ff0000",
                    label: {
                        text: 'Hari ini    :',
                        style: {
                            color: "#fff",
                            background: "#ff0000",
                            fontSize: '12px',
                        }
                    }
                }]
            },


        };

        var chart = new ApexCharts(document.querySelector("#gantt"), options);
        chart.render();
    </script>
@endsection
