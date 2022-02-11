<div>
    Showing {{ $pagination->firstItem() }} to {{ $pagination->lastItem() }} of {{ $pagination->total() }} results. 
    Page {{ $pagination->currentPage() }} out of {{ $pagination->lastPage() }} page(s). 
    
    <nav aria-label="Page navigation">
        <ul class="pagination pagination-sm">
            <li class="page-item @if (! $pagination->previousPageUrl() ) {{ 'disabled' }} @endif "><a class="page-link " href="{{ $pagination->previousPageUrl() }}">&laquo;</a></li>
            
            <li class="page-item @if (! $pagination->nextPageUrl() ) {{ 'disabled' }} @endif "><a class="page-link" href="{{ $pagination->nextPageUrl() }}">&raquo;</a></li>
        </ul>
    </nav>
</div>