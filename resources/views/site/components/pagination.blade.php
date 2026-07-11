@if ($paginator instanceof \Illuminate\Pagination\LengthAwarePaginator && $paginator->hasPages())
    <div class="pagination mt-3 mb-5">

        {{-- السابق --}}
        @if ($paginator->onFirstPage())
            <button id="prevBtn" disabled><i class="fa-solid fa-angle-left"></i></button>
        @else
            <a id="prevBtn" href="{{ $paginator->previousPageUrl() }}"><i class="fa-solid fa-angle-left"></i></a>
        @endif

        {{-- أرقام الصفحات --}}
        <div id="pageNumbers">
            @for ($page = 1; $page <= $paginator->lastPage(); $page++)
                @if ($page == $paginator->currentPage())
                    <button class="page-number active">{{ $page }}</button>
                @else
                    <a class="page-number" href="{{ $paginator->url($page) }}">{{ $page }}</a>
                @endif
            @endfor
        </div>

        {{-- التالي --}}
        @if ($paginator->hasMorePages())
            <a id="nextBtn" href="{{ $paginator->nextPageUrl() }}"><i class="fa-solid fa-angle-right"></i></a>
        @else
            <button id="nextBtn" disabled><i class="fa-solid fa-angle-right"></i></button>
        @endif

    </div>
@endif
