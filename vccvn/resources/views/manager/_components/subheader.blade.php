<?php
use Crazy\Helpers\Arr;
?>

					<div class="m-subheader ">
						<div class="d-flex align-items-center">
							<div class="mr-auto">
								<h3 class="m-subheader__title m-subheader__title--separator">@yield('module.name')</h3>
								<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
									<li class="m-nav__item m-nav__item--home">
										<a href="/" class="m-nav__link m-nav__link--icon">
											<i class="m-nav__link-icon la la-home"></i>
										</a>
									</li>
									@if ( is_array($map = manager_breadcrumbs()) )
									@foreach ($map as $item)
										
									<li class="m-nav__separator">-</li>
									<li class="m-nav__item">
										<a href="{{isset($item['url'])?$item['url']:'#'}}" class="m-nav__link">
											<span class="m-nav__link-text">{{isset($item['text'])?$item['text']:''}}</span>
										</a>
									</li>
									@endforeach
									@endif
									
								</ul>
							</div>

							@if ($actionmenus = manager_action_menu())
								

							<div>
								<div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" m-dropdown-toggle="hover" aria-expanded="true">
									<a href="#" class="m-portlet__nav-link btn btn-lg btn-secondary  m-btn m-btn--outline-2x m-btn--air m-btn--icon m-btn--icon-only m-btn--pill  m-dropdown__toggle">
										<i class="la la-plus m--hide"></i>
										<i class="la la-ellipsis-h"></i>
									</a>
									<div class="m-dropdown__wrapper">
										<span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
										<div class="m-dropdown__inner">
											<div class="m-dropdown__body">
												<div class="m-dropdown__content">
													<ul class="m-nav">
														{{-- <li class="m-nav__section m-nav__section--first m--hide">
															<span class="m-nav__section-text">Quick Actions</span>
														</li> --}}
														@foreach ($actionmenus as $item)
														@php $a = new Arr($item); @endphp
														<li class="m-nav__item">
															<a href="{{$a->url?$a->url:($a->link?$a->link:($a->route?route($a->route, $a->params?$a->params:[]):'javascript:void(0);' ))}}" class="m-nav__link">
																@if ($a->icon)
																<i class="m-nav__link-icon {{$a->icon}}"></i>
																@endif
																
																<span class="m-nav__link-text">{{$a->text?$a->text:'menu item'}}</span>
															</a>
														</li>
														
														@endforeach
														{{-- <li class="m-nav__separator m-nav__separator--fit">
														</li>
														<li class="m-nav__item">
															<a href="#" class="btn btn-outline-danger m-btn m-btn--pill m-btn--wide btn-sm">Submit</a>
														</li> --}}
													</ul>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							@endif

						</div>
					</div>