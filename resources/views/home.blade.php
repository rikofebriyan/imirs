@extends('layouts.app')

@section('content')
    <div class="content-wrapper container">
        <div class="page-content">
            <div class="row my-2">
                <div class="col sm-8">
                    <h2 class="mb-0">SPARE PART REPAIR STATISTIC</h2>
                </div>
                <div class="col align-self-end">
                    <a href="{{ route('partrepair.registeredticket.index') }}">
                        <h3 class="text-end align-middle mb-0">
                            History Ticket : {{ $data['total_registered'] }}
                            <i class="fa fa-tools mb-1"></i>
                        </h3>
                    </a>
                </div>
            </div>

            <div class="container">
                <div class="row row-cols-2 row-cols-lg-4 g-2 g-lg-3">

                    <div class="col p-1 mt-0">
                        <div class="card-box" style="background-color: rgba(244, 81, 108, 1);">
                            <div class="inner">
                                <h2 class="text-white"> {{ $data['total_Waiting_Approve'] }} </h2>
                                <h5 class="text-white"> Waiting Approval </h5>
                            </div>
                            <div class="icon">
                                <i class="fas fa-file-signature"></i>
                            </div>
                            <a href="{{ route('partrepair.waitingapprove.index') }}" class="card-box-footer">View More <i
                                    class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col p-1 mt-0">
                        <div class="card-box" style="background-color: #fd7e14;">
                            <div class="inner">
                                <h2 class="text-white"> {{ $data['total_Waiting_Progress'] }} </h2>
                                <h5 class="text-white"> Total Waiting Progress </h5>
                            </div>
                            <div class="icon">
                                <i class="fas fa-history"></i>
                            </div>
                            <a href="{{ route('partrepair.waitingtable.index') }}/?progress=waiting"
                                class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <div class="col p-1 mt-0">
                        <div class="card-box" style="background-color: rgba(0, 197, 220, 1);">
                            <div class="inner">
                                <h2 class="text-white">
                                    {{ $data['total_On Progress'] + $data['total_Seal Kit'] + $data['total_Trial'] }} </h2>
                                <h5 class="text-white"> Total Progress </h5>
                            </div>
                            <div class="icon">
                                <i class="fas fa-running"></i>
                            </div>
                            <a href="{{ route('partrepair.waitingtable.index') }}/?progress=progress"
                                class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col p-1 mt-0">
                        <div class="card-box" style="background-color: rgba(52, 191, 163, 1);">
                            <div class="inner">
                                <h2 class="text-white">
                                    {{ $data['total_Finish'] + $data['total_Scrap'] }}
                                </h2>
                                <h5 class="text-white"> Total Finish </h5>
                            </div>
                            <div class="icon">
                                <i class="fas fa-check"></i>
                            </div>
                            <a href="{{ route('finishtable') }}" class="card-box-footer">View More <i
                                    class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 
            <div class="row">
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $data['total_Waiting'] }}</h5>
                            <p class="card-text">Total Waiting</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $data['total_On Progress'] }}</h5>
                            <p class="card-text">Total On Progress</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $data['total_Seal Kit'] }}</h5>
                            <p class="card-text">Total Prep. Repair Kit</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $data['total_Trial'] }}</h5>
                            <p class="card-text">Total On Trial</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $data['total_Finish'] }}</h5>
                            <p class="card-text">Total Finished</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $data['total_repair_trade_in'] }}</h5>
                            <p class="card-text">Total Trade In</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $data['total_Scrap'] }}</h5>
                            <p class="card-text">Total Scrap</p>
                        </div>
                    </div>
                </div> --}}
            {{-- <div class="col-lg-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Rp <span class="number">{{ $data['total_cost_saving'] / 1000000 }}</span> Mil</h5>
                                    <p class="card-text">Total Cost Saving</p>
                                    <a href="#" class="btn btn-primary rounded-pill">View Detail <i
                                        class="fa-solid fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div> --}}
            {{-- <div class="col-lg-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $data['total_pneumatic'] }}</h5>
                                    <p class="card-text">Total Type Of Part : Pneumatic</p>
                                    <a href="#" class="btn btn-primary rounded-pill">View Detail <i
                                        class="fa-solid fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div> --}}
            {{-- <div class="col-lg-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $data['total_hydraulic'] }}</h5>
                                    <p class="card-text">Total Type Of Part : Hydraulic</p>
                                    <a href="#" class="btn btn-primary rounded-pill">View Detail <i
                                        class="fa-solid fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div> --}}
            {{-- <div class="col-lg-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $data['total_mechanic'] }}</h5>
                                    <p class="card-text">Total Type Of Part : Mechanic</p>
                                    <a href="#" class="btn btn-primary rounded-pill">View Detail <i
                                        class="fa-solid fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div> --}}
            {{-- <div class="col-lg-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $data['total_electric'] }}</h5>
                                    <p class="card-text">Total Type Of Part : Electric</p>
                                    <a href="#" class="btn btn-primary rounded-pill">View Detail <i
                                        class="fa-solid fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div> --}}
            {{-- <div class="col-lg-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $data['total_repair_in_house'] }}</h5>
                                    <p class="card-text">Total Repair In House</p>
                                    <a href="#" class="btn btn-primary rounded-pill">View Detail <i
                                        class="fa-solid fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div> --}}
            {{-- <div class="col-lg-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $data['total_repair_in_subcont'] }}</h5>
                                    <p class="card-text">Total Repair In Subcont</p>
                                    <a href="#" class="btn btn-primary rounded-pill">View Detail <i
                                        class="fa-solid fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div> --}}
            {{-- <div class="col-lg-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $data['total_repair_trade_in'] }}</h5>
                                    <p class="card-text">Total Trade In</p>
                                    <a href="#" class="btn btn-primary rounded-pill">View Detail <i
                                        class="fa-solid fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div> --}}
            {{-- <div class="col-lg-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $data['total_repair_kit_ready'] }}</h5>
                                    <p class="card-text">Total Repair Kit Ready</p>
                                    <a href="#" class="btn btn-primary rounded-pill">View Detail <i
                                        class="fa-solid fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div> --}}
            {{-- <div class="col-lg-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $data['total_repair_kit_not_ready'] }}</h5>
                                    <p class="card-text">Total Repair Kit Not Ready</p>
                                    <a href="#" class="btn btn-primary rounded-pill">View Detail <i
                                        class="fa-solid fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div> --}}
            {{-- <div class="col-lg-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $data['total_judgement_ok'] }}</h5>
                                    <p class="card-text">Total Trial Judgement OK</p>
                                    <a href="#" class="btn btn-primary rounded-pill">View Detail <i
                                        class="fa-solid fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div> --}}
            {{-- <div class="col-lg-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $data['total_judgement_ng'] }}</h5>
                                    <p class="card-text">Total Trial Judgement NG</p>
                                    <a href="#" class="btn btn-primary rounded-pill">
                                        View Detail <i class="fa-solid fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div> --}}
        </div>
    </div>
@endsection
