<div class="p-3 my-3 bg-white p-2 text-dark rounded shadow-sm">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">File Laporan</th>
                    <th scope="col" class="text-center">Dibuat</th>
                    <th scope="col" class="text-center">Size</th>
                </tr>
            </thead>
            <tbody>                        
                @forelse  ($files as $row) 
                <tr>
                    <td><a href="{{ route('reports.download'); }}/?file={{ $row['filename'] }}" target="_blank">{{ $row['filename'] }}</a></td>
                    <td class="text-center">{{ date('j F Y H:i', $row['lastModified']) }}</td>
                    <td class="text-center">{{ number_format($row['size'] / 1024, 2) }} kb</td>
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
