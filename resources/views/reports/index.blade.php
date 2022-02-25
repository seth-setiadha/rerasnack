@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">

        <div class="col-md-12">

            <div class="d-flex align-items-center p-3 bg-light text-dark bg-opacity-25 rounded shadow-sm">                
                <h3 class="mb-0 lh-1">{{ __('Reports') }}</h3>                
            </div>
            
            <x-alert-component />

            
            <div class="p-3 my-3 bg-white text-dark bg-opacity-50 rounded shadow-sm">
                <div class="my-3">Pilih laporan dan tanggal yg diinginkan:</div>
                <form class="row g-3 needs-validation" novalidate method="POST" action="{{ route('reports.index') }}">
                    @method('POST')
                    @csrf
                    @include('reports.form', ['colorTheme' => 'secondary'])
                </form>  
            </div>

            @include('reports.detail')

        </div>
    </div>
</div>
@endsection
