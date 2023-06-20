@extends('layouts.app')

@section('content')
    <div class="content-wrapper container">

        <div class="page-content">
            <div class="page-heading mt-3">
                <h3>Report Repair</h3>
            </div>
            <section class="row my-4">
                <div class="col-12 col-lg-3">
                    <div class="row">
                        <div class="col-6 col-lg-12 col-md-6">
                            <div class="card">
                                <div class="card-body px-4 py-4-5">
                                    <form action="{{ route('report') }}" method="get">
                                        <div class="mb-3">
                                            <h6>Group By</h6>
                                            <fieldset class="form-group">
                                                <select class="form-select" name="groupBy" id="groupBy" required>
                                                    <option value="" disabled>Choose ...</option>
                                                    <option value="Week"
                                                        @if ($groupBy == 'Week') selected @endif>Week</option>
                                                    <option value="Month"
                                                        @if ($groupBy == 'Month') selected @endif>Month</option>
                                                </select>
                                            </fieldset>
                                        </div>
                                        <div id="bulan_div" class="mb-3">
                                            <h6>Bulan</h6>
                                            <fieldset class="form-group">
                                                <select class="form-select" name="bulan" id="bulan">
                                                    <option value="" disabled selected>Choose ...</option>
                                                    @foreach ($month as $index => $mo)
                                                        <option value="{{ $index }}"
                                                            @if ($dateNowMonth == $index) selected @endif>
                                                            {{ $mo }}</option>
                                                    @endforeach
                                                </select>
                                            </fieldset>
                                        </div>
                                        <div class="mb-3">
                                            <h6>Tahun</h6>
                                            <fieldset class="form-group">
                                                <select class="form-select" name="tahun" id="tahun">
                                                    <option value="" disabled selected>Choose ...</option>
                                                    @foreach ($year as $index => $ye)
                                                        <option value="{{ $ye }}"
                                                            @if ($dateNowYear == $ye) selected @endif>
                                                            {{ $ye }}</option>
                                                    @endforeach
                                                </select>
                                            </fieldset>
                                        </div>
                                        <div class="mb-3">
                                            <button class="btn btn-primary rounded-pill">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-9">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div id="chart-qty-repair">
                                        <apexchart type="bar" height="350" :options="chartOptions"
                                            :series="series"></apexchart>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <div id="chart-cost-saving"></div>
                                </div>
                            </div>

                            @foreach ($placeOfRepair as $indexPlace => $place)
                                <div class="card">
                                    <div class="card-body">
                                        <div id="chart-cost-saving-{{ $indexPlace }}"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection

@section('script')
    <!-- script chart-qty-repair -->
    <script type="text/javascript" src="{{ asset('assets/extensions/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/ui-apexchart.js') }}"></script>
    <script>
        var options = {
            series: [{
                name: 'Waiting',
                type: 'column',
                data: [
                    @foreach ($qty['Waiting'] as $index => $key)
                        {{ $key }},
                    @endforeach
                ]
            }, {
                name: 'On Progress',
                type: 'column',
                data: [
                    @foreach ($qty['On Progress'] as $index => $key)
                        {{ $key }},
                    @endforeach
                ]
            }, {
                name: 'Prep. Seal Kit',
                type: 'column',
                data: [
                    @foreach ($qty['Seal Kit'] as $index => $key)
                        {{ $key }},
                    @endforeach
                ]
            }, {
                name: 'Trial',
                type: 'column',
                data: [
                    @foreach ($qty['Trial'] as $index => $key)
                        {{ $key }},
                    @endforeach
                ]
            }, {
                name: 'Finish',
                type: 'column',
                data: [
                    @foreach ($qty['Finish'] as $index => $key)
                        {{ $key }},
                    @endforeach
                ]
            }, {
                name: 'Scrap',
                type: 'column',
                data: [
                    @foreach ($qty['Scrap'] as $index => $key)
                        {{ $key }},
                    @endforeach
                ]
            }, {
                name: 'Total Registered',
                type: 'line',
                data: [
                    @foreach ($qty['total'] as $index => $key)
                        {{ $key }},
                    @endforeach
                ]
            }],
            colors: [
                '#fd7e14',
                'rgba(0, 197, 220, 1)',
                'rgba(52, 191, 163, 1)',
                'rgba(115, 76, 234, 1)',
                'rgba(255, 185, 0, 1)',
                '#343a40',
                'rgba(244, 81, 108, 1)',
            ],
            chart: {
                type: 'line',
                height: 350,
                stacked: true,
                toolbar: {
                    show: true
                },
                zoom: {
                    enabled: true
                }
            },
            title: {
                text: 'Qty Part Repair',
                align: 'left'
            },
            dataLabels: {
                enabled: true,
                enabledOnSeries: [6]
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    legend: {
                        position: 'bottom',
                        offsetX: -10,
                        offsetY: 0
                    }
                }
            }],
            plotOptions: {
                bar: {
                    horizontal: false,
                    borderRadius: 10,
                    dataLabels: {
                        total: {
                            enabled: true,
                            style: {
                                fontSize: '13px',
                                fontWeight: 900
                            }
                        }
                    }
                },
            },
            xaxis: {
                categories: [
                    @foreach ($qty['xAxis'] as $key)
                        '{{ $key }}',
                    @endforeach
                ],
            },
            yaxis: {
                title: {
                    text: 'Qty'
                },
            },
            legend: {
                position: 'right',
                offsetY: 40
            },
            fill: {
                opacity: 1
            }
        };

        var chart = new ApexCharts(document.querySelector("#chart-qty-repair"), options);
        chart.render();
    </script>

    <!-- script chart-cost-saving -->
    <script>
        var options = {
            series: [{
                    name: "Cost Saving",
                    data: [
                        @foreach ($costSaving['actual'] as $index => $key)
                            {{ $key }},
                        @endforeach
                    ],
                },
                {
                    name: 'Target',
                    data: [
                        @foreach ($costSaving['target'] as $index => $key)
                            {{ $key }},
                        @endforeach
                    ],
                }
            ],
            chart: {
                height: 350,
                type: 'line',
                zoom: {
                    enabled: false
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                width: [5, 7, 5],
                curve: 'straight',
                dashArray: [0, 8, 5]
            },
            title: {
                text: 'Cost Saving',
                align: 'left'
            },
            legend: {
                tooltipHoverFormatter: function(val, opts) {
                    return val + ' - ' + opts.w.globals.series[opts.seriesIndex][opts.dataPointIndex] + ''
                }
            },
            markers: {
                size: 0,
                hover: {
                    sizeOffset: 6
                }
            },
            xaxis: {
                categories: [
                    @foreach ($costSaving['xAxis'] as $key)
                        '{{ $key }}',
                    @endforeach
                ],
            },
            yaxis: {
                title: {
                    text: 'Rupiah (in Million)'
                },
            },
            tooltip: {
                y: [{
                        title: {
                            formatter: function(val) {
                                return val + " (mins)"
                            }
                        }
                    },
                    {
                        title: {
                            formatter: function(val) {
                                return val + " per session"
                            }
                        }
                    },
                    {
                        title: {
                            formatter: function(val) {
                                return val;
                            }
                        }
                    }
                ]
            },
            grid: {
                borderColor: '#f1f1f1',
            }
        };

        var chart = new ApexCharts(document.querySelector("#chart-cost-saving"), options);
        chart.render();
    </script>

    @foreach ($placeOfRepair as $indexPlace => $place)
        <!-- script chart-cost-saving By {{ $place }}-->
        <script>
            var options = {
                series: [{
                        name: "Cost Saving By {{ $place }}",
                        data: [
                            @foreach ($costSaving[$place] as $index => $key)
                                {{ $key }},
                            @endforeach
                        ],
                    },
                ],
                chart: {
                    height: 350,
                    type: 'line',
                    zoom: {
                        enabled: false
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: [5, 7, 5],
                    curve: 'straight',
                    dashArray: [0, 8, 5]
                },
                title: {
                    text: 'Cost Saving By {{ $place }}',
                    align: 'left'
                },
                legend: {
                    tooltipHoverFormatter: function(val, opts) {
                        return val + ' - ' + opts.w.globals.series[opts.seriesIndex][opts.dataPointIndex] + ''
                    }
                },
                markers: {
                    size: 0,
                    hover: {
                        sizeOffset: 6
                    }
                },
                xaxis: {
                    categories: [
                        @foreach ($costSaving['xAxis'] as $key)
                            '{{ $key }}',
                        @endforeach
                    ],
                },
                yaxis: {
                    title: {
                        text: 'Rupiah (in Million)'
                    },
                },
                tooltip: {
                    y: [{
                            title: {
                                formatter: function(val) {
                                    return val + " (mins)"
                                }
                            }
                        },
                        {
                            title: {
                                formatter: function(val) {
                                    return val + " per session"
                                }
                            }
                        },
                        {
                            title: {
                                formatter: function(val) {
                                    return val;
                                }
                            }
                        }
                    ]
                },
                grid: {
                    borderColor: '#f1f1f1',
                }
            };

            var chart = new ApexCharts(document.querySelector("#chart-cost-saving-{{ $indexPlace }}"), options);
            chart.render();
        </script>
    @endforeach

    <script>
        $(document).ready(function() {
            checkFilter()

            $('#groupBy').on('change', function() {
                checkFilter()
            });

            function checkFilter() {
                var groupBy = $('#groupBy option:selected').val()

                if (groupBy == 'Month') {
                    $('#bulan_div').hide()
                } else {
                    $('#bulan_div').show()
                }
            }
        });
    </script>
@endsection
