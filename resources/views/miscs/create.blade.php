@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">

        <div class="col-md-12">
            
        
            <div class="d-flex align-items-center p-3 mb-3 bg-secondary p-2 text-dark bg-opacity-25 rounded shadow-sm">
                <div class="me-auto">
                    <h3 class="mb-0 lh-1">{{ __('Tambah Modal Lain-Lain') }}</h3>
                </div>
                <div class="ms-auto">
                <a class="btn btn-secondary" href="{{ route('misc.index') }}">{{ __('kembali') }}</a>
                </div>
            </div>
            
            <x-alert-component />
            
                <div class="p-3 my-3 bg-white p-2 text-dark bg-opacity-50 rounded shadow-sm">
                        
                        <form class="row g-3 needs-validation" autocomplete="off" novalidate method="POST" action="{{ route('misc.store') }}">                                                
                            @method('POST')
                            @csrf
                            @include('miscs.form', ['create' => true])
                        </form>

                </div>
            
            
        </div>
    </div>
</div>

@endsection
