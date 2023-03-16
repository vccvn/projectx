@extends($_layout.'main')

{{-- khai báo title --}}
@section('title', 'Dashboard')

{{-- tên modul xuất hiện trong sub header --}}
@section('module.name', 'Dashboard')


@section('content')



						<div class="row">
							<div class="col-12">

								<!--begin::Portlet-->
								<div class="m-portlet">
									<div class="m-portlet__head">
										<div class="m-portlet__head-caption">
											<div class="m-portlet__head-title">
												<h3 class="m-portlet__head-text">
                                                    Filemanager
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
						</div>

@endsection
