@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">

        <div class="col-md-12">
            
        
            <div class="d-flex align-items-center p-3 my-3 bg-info p-2 text-dark bg-opacity-25 rounded shadow-sm">
                <div class="me-auto">
                    <h3 class="mb-0 lh-1">{{ __('Tambah Barang') }}</h3>
                </div>
                <div class="ms-auto">
                <a class="btn btn-info" href="{{ route('items.index') }}">{{ __('kembali') }}</a>
                </div>
            </div>
            
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                <div class="p-3 my-3 bg-white p-2 text-dark bg-opacity-50 rounded shadow-sm">
                        
                        <form class="row g-3 needs-validation" novalidate method="POST" action="{{ route('items.store') }}">                                                
                        @method('POST')
                            @csrf
                            @include('items.form')
                        </form>

                </div>
            
            
        </div>
    </div>
</div>

@endsection