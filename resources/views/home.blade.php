@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('Welcome') . " " . Auth::user()->name . "!" }} 

                    {{ var_dump($modalWeekly) }}
                    {{ var_dump($penjualanWeekly) }}
                </div>

                
                <figure class="highcharts-figure">
                    <div id="container"></div>
                </figure>


            </div>
        </div>
    </div>
</div>

@endsection
