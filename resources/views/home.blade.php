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
        </div>
    </div>
@endsection
