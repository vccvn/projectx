<?php
    $jv = 'javascript:void(0);';
    // $style_class = 'text-accent btn btn-outline-accent m-btn m-btn--icon m-btn--pill m-btn--air';
    $style_class = 'page-link';
?>
@if ($paginator->hasPages())


                <ul class="pagination float-right">
                    {{-- Previous Page Link --}}

                    <li class="paginate_button page-item previous {{(!$paginator->onFirstPage()) ? '' : 'disabled'}}" id="m_table_1_previous">
                        <a href="{{ (!$paginator->onFirstPage()) ? $paginator->previousPageUrl(): $jv }}" class=" {{$style_class}}">
                            <i class="la la-angle-left"></i>
                        </a>
                    </li>
                    {{-- Pagination Elements --}}
                    @php
                    $l = false;
                    $r = false;
                    $l2 = false;
                    $r2 = false;
                    $mp = 0;
                    @endphp
                    @foreach ($elements as $element)
                        <?php 
                            $cp = $paginator->currentPage();
                            $t = $paginator->lastPage();
                        ?>
                            
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            @if(!$l && !$l2 && $mp < $cp) 
                                <?php 
                                $l = true;
                                $l2 = true; 
                                ?>
                                {{-- <li class="page-item disabled"><span class="">{{ $element }}</span></li> --}}
                                <li class="paginate_button page-item disabled">
                                    <a href="{{ $jv }}" class=" {{$style_class}}">{{ $element }}</a>
                                </li>
                            @elseif(!$r && !$r2 && $mp > $cp)
                                <li class="paginate_button page-item disabled">
                                    <a href="{{ $jv }}" class=" {{$style_class}}">{{ $element }}</a>
                                </li>
                                <?php 
                                $r = true; 
                                $r2 = true; 
                                ?>
                            @endif
                            
                        @endif
                        
                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                <?php $mp++; ?>
                                @if($page == 1 || ($page >= $cp-2 && $page <= $cp+2) || $page == $t)
                                    <li class="paginate_button page-item {{$page == $paginator->currentPage()? 'active':''}}">
                                        <a href="{{ $url }}" class=" {{$style_class}}">{{ $page }}</a>
                                    </li>
                                @elseif($page < $cp-2 && $page > 1 && !$l)
                                @php $l = true; @endphp
                                    <li class="paginate_button page-item disabled">
                                        <a href="{{ $jv }}" class=" {{$style_class}}">
                                            <i class="la la-circle-o"></i>
                                        </a>
                                    </li>
                                @elseif($page > $cp+2 && $page < $t && !$r)
                                    @php $r = true; @endphp
                                    <li class="paginate_button page-item disabled">
                                        <a href="{{ $jv }}" class=" {{$style_class}}">
                                            <i class="la la-circle-o"></i>
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    {{-- @if ($paginator->hasMorePages())
                        <li class="page-item"><a class="" href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a></li>
                    @else
                        <li class="page-item disabled"><span class="">&raquo;</span></li>
                    @endif
                     --}}
                    <li class="paginate_button page-item next {{(!$paginator->hasMorePages()) ? 'disabled' : ''}}" id="m_table_1_next">
                        <a href="{{ (!$paginator->hasMorePages()) ?$jv : $paginator->nextPageUrl() }}" class=" {{$style_class}}">
                            <i class="la la-angle-right"></i>
                        </a>
                    </li>
                </ul>
                <div class="clearfix" style="clear:both;"></div>

@endif
