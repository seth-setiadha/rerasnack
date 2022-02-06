@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">

        <div class="col-md-12">
            
        
            <div class="d-flex align-items-center p-3 my-3 bg-info p-2 text-dark bg-opacity-50 rounded shadow-sm">
                <div class="lh-1">
                    <h3 class="mb-0 lh-1">{{ __('Master Items') }}</h3>
                </div>
            </div>
            
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="p-3 my-3 bg-white p-2 text-dark bg-opacity-50 rounded shadow-sm">
                    <div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Kode Barang</th>
                                    <th scope="col">Nama Barang</th>
                                    <th scope="col">kg/bal</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                <tr>
                                    <td>{{ $item->item_code }}</td>
                                    <td>{{ $item->item_name }}</td>
                                    <td>{{ $item->bal_kg }}</td>
                                    <td>&nbsp;</td>
                                </tr>
                                @endforeach                                
                            </tbody>
                        </table>
                    </div>
                    <div>

                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-center">
                                <li class="page-item @if ($page <= 1) {{ 'disabled' }} @endif "><a class="page-link " href="#">Previous</a></li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item @if ($page >= $nPage) {{ 'disabled' }} @endif "><a class="page-link" href="#">Next</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            
            
        </div>
    </div>
</div>
@endsection
