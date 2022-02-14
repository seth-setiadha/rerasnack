<div class="">
    @if ($pagination->total() > 0)
        Showing {{ $pagination->firstItem() }} to {{ $pagination->lastItem() }} of {{ $pagination->total() }} results. 
        Page {{ $pagination->currentPage() }} out of {{ $pagination->lastPage() }} page(s). 
        <?php 
        $from = 1; $last = $to = $pagination->lastPage(); $current = $pagination->currentPage();
        if($to > 10) {
            $from  = $current - 4; $to = $current + 4;
            if($from < 1) { $from = 1; }
            if(($to - $from) <=8) { $to = $from + 8; }           

            if($to > $last) { $to = $last; }
            if(($to - $from) <=8) { $from = $to - 8; }
            if($from < 1) { $from = 1; }
        }
        ?>
        <nav aria-label="Page navigation">
            <ul class="pagination pagination-sm d-flex flex-wrap">
                <li class="page-item @if ( $pagination->onFirstPage() ) {{ 'disabled' }} @endif "><a class="page-link " href="{{ $pagination->url(1) }}">First</a></li>
                @for ($i=$from;$i<=$to;$i++)
                <li class="page-item @if ($i == $pagination->currentPage()) {{ 'disabled' }} @endif "><a class="page-link " href="{{ $pagination->url($i) }}">{{ $i }}</a></li>    
                @endfor            
                <li class="page-item @if ($current == $last) {{ 'disabled' }} @endif "><a class="page-link" href="{{ $pagination->url($last) }}">Last</a></li>
            </ul>
        </nav>
    @else
    @endif
</div>