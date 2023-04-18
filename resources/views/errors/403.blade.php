@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger">
                    <center><strong>This action is unauthorized.</strong> Kamu tidak memiliki hak akses untuk melakukan
                        action ini.</center>
                </div>
                <a href="{{ url()->previous() }}" class="btn btn-primary">Go back</a>
            </div>
        </div>
    </div>
@endsection
