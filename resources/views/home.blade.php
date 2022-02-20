@extends('layouts.app')

@section('content')
<style type="text/css">
.highcharts-figure,
.highcharts-data-table table {
    min-width: 100%;
    margin: 1em auto;
}

.highcharts-data-table table {
    font-family: Verdana, sans-serif;
    border-collapse: collapse;
    border: 1px solid #ebebeb;
    margin: 10px auto;
    text-align: center;
    width: 100%;
    /* max-width: 500px; */
}

.highcharts-data-table caption {
    padding: 1em 0;
    font-size: 1.2em;
    color: #555;
}

.highcharts-data-table th {
    font-weight: 600;
    padding: 0.5em;
}

.highcharts-data-table td,
.highcharts-data-table th,
.highcharts-data-table caption {
    padding: 0.5em;
}

.highcharts-data-table thead tr,
.highcharts-data-table tr:nth-child(even) {
    background: #f8f8f8;
}

.highcharts-data-table tr:hover {
    background: #f1f7ff;
}

</style>
<script src="{{ url('/js/highcharts.js') }}"></script>
<script src="{{ url('/js/modules/exporting.js') }}"></script>
<script src="{{ url('/js/modules/export-data.js') }}"></script>
<script src="{{ url('/js/modules/accessibility.js') }}"></script>


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex">
                    <div class="me-auto">
                        {{ __('Dashboard') }}
                    </div>
                    <div class="ms-auto">
                        {{ __('Welcome') . " " . Auth::user()->name . "!" }} 
                    </div>

                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <figure class="highcharts-figure">
                        <div id="qtyChart"></div>
                    </figure>

                    <div class="card border-primary mb-3" style="max-width: 18rem;">
                        <div class="card-header bg-primary bg-opacity-25 h3">Top 3 Penjualan</div>
                        <div class="card-body">
                            <h5 class="card-title">Top 3 penjualan 30 hari terakhir</h5>
                            <p class="">
                                <ul>
                                @foreach ($top3 as $idx => $top)
                                    <li>{{ $top->item_code . " " . $top->item_name . ": " . $top->qty . " buah (Rp. " . number_format($top->sub_total) . ")" }}</li>
                                @endforeach
                                </ul>
                            </p>
                        </div>
                    </div>

                    <div class="card border-primary mb-3" style="max-width: 18rem;">
                        <div class="card-header bg-primary bg-opacity-25 h3">Top 3 Penjualan</div>
                        <div class="card-body">
                            <h5 class="card-title">Top 3 penjualan 30 hari terakhir</h5>
                            <p class="">
                                <ul>
                                @foreach ($top3 as $idx => $top)
                                    <li>{{ $top->item_code . " " . $top->item_name . ": " . $top->qty . " buah (Rp. " . number_format($top->sub_total) . ")" }}</li>
                                @endforeach
                                </ul>
                            </p>
                        </div>
                    </div>

                    

                    
                    <figure class="highcharts-figure">
                        <div id="subtotalChart"></div>
                    </figure>

                    
                    

                </div>

                


            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
Highcharts.chart('qtyChart', {
    chart: {
        type: 'line'
    },
    title: {
        text: 'Modal dan Penjualan 10 Hari terakhir'
    },
    subtitle: {
        text: ''
    },
    xAxis: {
        categories: [ {!! implode(',', $indexes) !!} ]
    },
    yAxis: {
        title: {
            text: 'Quantity'
        }
    },
    plotOptions: {
        line: {
            dataLabels: {
                enabled: true
            },
            enableMouseTracking: true
        }
    },
    series: [{
        name: 'Penjualan',
        data: [ {{ implode(',', $penjualans['qty']) }} ]
    }, {
        name: 'Modal',
        data: [ {{ implode(',', $modals['qty']) }} ]
    }]
});

</script>

@endsection
