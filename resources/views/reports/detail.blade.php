<div class="p-3 my-3 bg-white p-2 text-dark rounded shadow-sm">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">File Laporan</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>                        
                @forelse  ($files as $row) 
                <tr>
                    <td><a href="{{ route('reports.download'); }}/?file={{ $row }}" target="_blank">{{ $row }}</a></td>
                    <td></td>
                </tr>      
                @empty
                <tr>
                    <td colspan="2" class="h5">No files.</td>
                </tr>                        
                @endforelse 
            </tbody>
        </table>
    </div>                    
</div>
