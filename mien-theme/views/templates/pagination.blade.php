@if ($paginator->hasPages())
    <?php
    $itemClass = 'page-item';
    $activeClass = 'active';
    $prevItemClass = $itemClass;
    $nextItemClass = $itemClass;
    $activeItemClass = $itemClass . ' active';
    
    $linkClass = 'page-link';
    $prevLinkClass = $linkClass; // . ' prev';
    $nextLinkClass = $linkClass; // . ' next';
    $activeLinkClass = ' active';
    
    ?>

    <nav aria-label="Page navigation example" class="page-section">

        <ul class="pagination">

            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="{{ $prevItemClass }} disabled">
                    <a class="{{ $prevLinkClass }}" href="javascript:void(0)" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            @else
                @php
                    $html->addToHead('link', [
                        'data-rh' => 'true',
                        'rel' => 'previous',
                        'href' => $paginator->previousPageUrl(),
                    ]);
                @endphp
                <li class="{{ $prevItemClass }}">
                    <a class="{{ $prevLinkClass }}" href="{{ $paginator->previousPageUrl() }}" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @php
                $l = false;
                $r = false;
                $l2 = false;
                $r2 = false;
                $mp = 0;
                $cp = $paginator->currentPage();
                $t = $paginator->lastPage();
                
            @endphp
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    @if (!$l && !$l2 && $mp < $cp)
                        @php
                            $l = true;
                            $l2 = true;
                        @endphp
                        <li class="{{ $itemClass }}"><a class="{{ $linkClass }} dots" href="javascript:void(0)"><span>{{ $element }}</span></a></li>
                    @elseif(!$r && !$r2 && $mp > $cp)
                        <li class="{{ $itemClass }}"><a class="{{ $linkClass }} dots" href="javascript:void(0)"><span>{{ $element }}</span></a></li>
                        @php
                            $r = true;
                            $r2 = true;
                        @endphp
                    @endif
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @php $mp++; @endphp
                        @if ($page == 1 || ($page >= $cp - 2 && $page <= $cp + 2) || $page == $t)
                            @if ($page == $paginator->currentPage())
                                <li class="{{ $activeItemClass }}"><a class="{{ $activeLinkClass }} {{ $linkClass }}" href="javascript:void(0)">{{ $page }}</a></li>
                            @else
                                <li class="{{ $itemClass }}"><a class="{{ $linkClass }}" href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @elseif($page < $cp - 2 && $page > 1 && !$l)
                            @php $l = true; @endphp
                            <li class="{{ $itemClass }}"><span class="{{ $linkClass }} dots">...</span></li>
                        @elseif($page > $cp + 2 && $page < $t && !$r)
                            @php $r = true; @endphp
                            <li class="{{ $itemClass }}"><span class="{{ $linkClass }} dots">...</span></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                @php
                    $html->addToHead('link', [
                        'data-rh' => 'true',
                        'rel' => 'next',
                        'href' => $paginator->nextPageUrl(),
                    ]);
                @endphp

                <li class="{{ $nextItemClass }}">
                    <a class="{{ $nextLinkClass }}" href="{{ $paginator->nextPageUrl() }}" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            @else
                <li class="{{ $nextItemClass }} disabled">
                    <a class="{{ $nextLinkClass }}" href="javascript:void(0)" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            @endif
        </ul>
        <!--/.pagination -->
    </nav>
@endif
