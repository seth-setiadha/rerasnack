<div class="">
    @if ($pagination->total() > 0)
        Showing {{ $pagination->firstItem() }} to {{ $pagination->lastItem() }} of {{ $pagination->total() }} results. 
        Page {{ $pagination->currentPage() }} out of {{ $pagination->lastPage() }} page(s). 
        
        <nav aria-label="Page navigation">
            <ul class="pagination pagination-sm d-flex flex-wrap">
                <li class="page-item @if (! $pagination->previousPageUrl() ) {{ 'disabled' }} @endif "><a class="page-link " href="{{ $pagination->previousPageUrl() }}">&laquo;</a></li>
                @for ($i=1;$i<=$pagination->lastPage();$i++)
                <li class="page-item @if ($i == $pagination->currentPage()) {{ 'disabled' }} @endif "><a class="page-link " href="{{ $pagination->url($i) }}">{{ $i }}</a></li>    
                @endfor            
                <li class="page-item @if (! $pagination->nextPageUrl() ) {{ 'disabled' }} @endif "><a class="page-link" href="{{ $pagination->nextPageUrl() }}">&raquo;</a></li>
            </ul>
        </nav>
    @else
    @endif
</div>