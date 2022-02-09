@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">

        <div class="col-md-12">
            
        
            <div class="d-flex align-items-center p-3 my-3 bg-{{ $colorTheme }} p-2 text-dark bg-opacity-25 rounded shadow-sm">
                <div class="me-auto">
                    <h3 class="mb-0 lh-1">{{ ucwords(__($pageName)) }}</h3>
                </div>
                <div class="ms-auto">
                    <a class="btn btn-{{ $colorTheme }}" href="{{ route($pageName . '.create') }}">{{ __('Tambah '. ucwords($pageName)) }}</a>
                </div>
            </div>
            
                @if (session('status'))
                    <div class="alert alert-success" role="alert">{{ session('status') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
                @endif
                <div class="p-3 my-3 bg-white p-2 text-dark bg-opacity-50 rounded shadow-sm">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Tanggal</th>
                                    <th scope="col">Nama Barang</th>
                                    @if ($stock == "IN") <th scope="col">Bal/kg</th> @endif
                                    <th scope="col">Qty</th>
                                    <th scope="col">Harga / Unit</th>
                                    <th scope="col">Subtotal</th>
                                    <th scope="col">Sisa</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $row)
                                <tr>
                                    <td>{{ $row->tanggal }}</td>
                                    <td>{{ $row->item_name . ' (' . $row->item_code . ')' }}</td>
                                    @if ($stock == "IN") <td>{{ $row->bal_kg }}</td> @endif
                                    <td>{{ $row->qty }}</td>
                                    <td>{{ $row->unit_price . ' / ' . $row->unit }}</td>
                                    <td>{{ $row->sub_total }}</td>
                                    <td>{{ $row->sisa }} kg</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div>

                        <?php 
                        $start = 1; $end = $nPage;
                        if($nPage > 10) { $start = $page - 4; $end = $page + 4; // PAGE RANGE
                            // echo ($start . " ..1.. " . $end);
                            $start = $start > 0 ? $start : 1;                   // SET UP END PAGE
                            $end = ($end - $start) >= 8 ? $end : $start + 8;
                            // echo ($start . " ..2.. " . $end);

                            $start = ($end - $start) >= 8 && ($nPage - $end) >= 4 ? $start : $nPage - 8;
                            // echo ($start . " ..3.. " . $end);
                            $end = $end > $nPage ? $nPage : $end;
                         } ?>
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-center">
                                <li class="page-item @if ($page <= 1) {{ 'disabled' }} @endif "><a class="page-link " href="{{ route($pageName . '.index') . '/?page=' . ($page - 1) }}">Previous</a></li>
                                @for ($i=$start; $i<=$end;$i++)
                                <li class="page-item @if ($page == $i) {{ 'disabled' }} @endif"><a class="page-link" href="{{ route($pageName . '.index') . '/?page=' . $i }}">{{ $i }}</a></li>
                                @endfor
                                <li class="page-item @if ($page >= $nPage) {{ 'disabled' }} @endif "><a class="page-link" href="{{ route($pageName . '.index') . '/?page=' . ($page + 1) }}">Next</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            
            
        </div>
    </div>
</div>
@endsection
