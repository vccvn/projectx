<?php
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Input;
$search = Input::get('search'); 
$per_page = Input::get('per_page'); 
$page = Input::get('page'); 

$sortby = Input::get('sortby'); 
$sorttype = Input::get('sorttype'); 

$url = url_merge(URL::current(), compact('search','sortby','sorttype','per_page','page'));

$pageNumber = isset($page) ? $page  :  1;
$pageSize   = isset($per_page)   ? $per_page    : 10;
$totalPage  = isset($total_page)  ? $total_page   :  1;
$rsCount    = isset($count)       ? $count        :  0;
$maxOfPage  = $pageNumber * $pageSize;
$max        = $maxOfPage <= $rsCount ? $maxOfPage : $rsCount;


$showButton = isset($buttons)     ? $buttons      : 5;

$break_point = $showButton/2;

$enable_prev  = $pageNumber > 1 ? true : false;
$enable_next  = $pageNumber < $totalPage;

$jv = 'javascript:void(0);';

$beforeBlock = false;
$afterBlock = false;

?>


    <div class="row">
        <div class="col-sm-12 col-md-5">
            <div class="dataTables_info" id="m_table_1_info" role="status" aria-live="polite">
                Showing {{ ($pageNumber - 1) * $pageSize + 1 }} to {{ $max }} of {{ $rsCount }} result(s)
            </div>
        </div>
        <div class="col-sm-12 col-md-7">
            <div class="dataTables_paginate paging_full_numbers" id="m_table_1_paginate">
                @if ($totalPage > 1)
                <ul class="pagination">
                    <li class="paginate_button page-item previous {{$enable_prev ? '' : 'disabled'}}" id="m_table_1_previous">
                        <a href="{{ $enable_prev ? url_merge($url,'page', $pageNumber - 1): $jv }}" class="page-link">
                            <i class="la la-angle-left"></i>
                        </a>
                    </li>
                    @for ($i = 1; $i <= $totalPage; $i++)
                    @if (
                        ($pageNumber > $break_point && in_array($i, [1, 2])) || 
                        ($pageNumber + $break_point < $totalPage -2 && $i > $totalPage -2) ||
                        ($i >= $pageNumber-$break_point && $i < $pageNumber+$break_point) ||
                        ($pageNumber < $break_point && $i <= $showButton)
                    )
                    <li class="paginate_button page-item {{$i == $pageNumber? 'active':''}}">
                        <a href="{{url_merge($url,'page', $i)}}" class="page-link">{{$i}}</a>
                    </li>
                    @elseif(!$beforeBlock && $i < $pageNumber)
                        <?php $beforeBlock = true; ?>
                        <li class="paginate_button page-item disabled">
                            <a href="{{ $jv }}" class="page-link">
                                <i class="la la-circle-o"></i>
                            </a>
                            
                        </li>
                            
                    @elseif(!$afterBlock && $i > $pageNumber)
                        <?php $afterBlock = true; ?>
                        <li class="paginate_button page-item disabled">
                            <a href="{{ $jv }}" class="page-link">
                                <i class="la la-circle-o"></i>
                            </a>
                            
                        </li>
                            
                    @endif
                    
                    @endfor
                    
                    <li class="paginate_button page-item next {{$enable_next ? '' : 'disabled'}}" id="m_table_1_next">
                        <a href="{{ $enable_next ? url_merge($url,'page', $pageNumber + 1): $jv }}" class="page-link">
                            <i class="la la-angle-right"></i>
                        </a>
                    </li>
                </ul>
                @endif
            </div>
        </div>
    </div>

