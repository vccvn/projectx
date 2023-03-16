@extends($_layout.'main')

{{-- khai báo title --}}
@section('title', 'Dashboard')

{{-- tên modul xuất hiện trong sub header --}}
@section('module.name', 'Dashboard')


@section('content')
	


						<div class="row">
							<div class="col-md-8">

								<!--begin::Portlet-->
								<div class="m-portlet">
									<div class="m-portlet__head">
										<div class="m-portlet__head-caption">
											<div class="m-portlet__head-title">
												<h3 class="m-portlet__head-text">
													FPT Polytechnic Hosting Manager
												</h3>
											</div>
										</div>
									</div>
									<div class="m-portlet__body">

										<!--begin::Section-->
										<div class="m-section m-section--last">
                                            Xin chào! Cảm ơn bạn đã sử dụng dịch vụ của DH Team. <br>
                                            <br>
                                            Đây là trang quản trị! Hãy truy cập các chức năng ở Sidebar bên tay trái!
										</div>

										<!--end::Section-->
									</div>
								</div>

								<!--end::Portlet-->
							</div>

							<div class="col-md-4">
								
								<!--begin::Portlet-->
								<div class="m-portlet m-portlet--tabs m-portlet--success m-portlet--head-solid-bg m-portlet--head-sm">
									<div class="m-portlet__head">
										<div class="m-portlet__head-caption">
											<div class="m-portlet__head-title">
												<h3 class="m-portlet__head-text">
													Hosting
												</h3>
											</div>
										</div>
										<div class="m-portlet__head-tools">
											<ul class="nav nav-tabs m-tabs m-tabs-line  m-tabs-line--right" role="tablist">
												<li class="nav-item m-tabs__item">
													<a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_tabs_7_1" role="tab">
														Thông tin hosting
													</a>
												</li>
												<li class="nav-item m-tabs__item">
													<a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_7_2" role="tab">
														Database
													</a>
												</li>
												<li class="nav-item m-tabs__item">
													<a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_7_3" role="tab">
														Storage
													</a>
												</li>
											</ul>
										</div>
									</div>
									<div class="m-portlet__body">
										<div class="tab-content">
											<div class="tab-pane active" id="m_tabs_7_1" role="tabpanel">
												<div class="table-responsive">
													<table class="table table-bordered table-hover">
														<tbody>
															<tr>
																<td>IP</td>
																<td>{{$_SERVER['SERVER_ADDR']}}</td>
															</tr>
															<tr>
																<td>Sub-Domain</td>
																<td>
																	
																	<a href="http://{{$settings->subdomain . '.' . $settings->domain}}">
																		{{$settings->subdomain . '.' . $settings->domain}}
																	</a>
																</td>
															</tr>
															<tr>
																<td>Alias-Domain</td>
																<td>
																	@if ($settings->alias_domain)
																		<a href="http://{{$settings->alias_domain}}">{{$settings->alias_domain}}</a>
																	@endif
																</td>
															</tr>
															<tr>
																<td>DOCUNENT_ROOT</td>
																<td>
																	/public
																</td>
															</tr>
															<tr>
																<td>Storage</td>
																<td>
																	<span class="storage-usage">NA</span> / <span>{{$user->userWebSetting->storage_limited}} MB</span>
																</td>
															</tr>

														</tbody>
													</table>
												</div>
											</div>
											<div class="tab-pane" id="m_tabs_7_2" role="tabpanel">
												<div class="table-responsive">
													<table class="table table-bordered table-hover">
														<tbody>
															<tr>
																<td>Số lượng</td>
																<td>1</td>
															</tr>
															<tr>
																<td>Database</td>
																<td>
																	{{$user->secret_id}}
																</td>
															</tr>
															<tr>
																<td>Username</td>
																<td>
																	{{$user->secret_id}}
																</td>
															</tr>
															
														</tbody>
													</table>
												</div>
											</div>
											<div class="tab-pane " id="m_tabs_7_3" role="tabpanel">
												<div class="table-responsive">
													<table class="table table-bordered table-hover">
														<tbody>
															<tr>
																<td>Dung lượng</td>
																<td class="text-right"><span>{{$user->userWebSetting->storage_limited}} MB</span></td>
															</tr>
															<tr>
																<td>Đã sử dụng</td>
																<td class="text-right">
																	<span class="storage-usage">NA</span>
																	
																</td>
															</tr>
															
														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>

								<!--end::Portlet-->

							</div>
						</div>

@endsection


@section('js')
	<script>
		$(function(){
			App.api.get("{{route('filemanager.folders.size')}}").then(function(rs){
				if(rs.status){
					$('.storage-usage').html(rs.data.size + " " + rs.data.unit);
				}
			})
		});
	</script>
@endsection