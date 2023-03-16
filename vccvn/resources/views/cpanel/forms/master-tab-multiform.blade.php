
@if (is_array($cfg->tabs))
    
	<div class="m-portlet m-portlet--tabs" id="theme-tabs-list">
		<div class="m-portlet__head">
			
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<h3>{{$cfg->title}}</h3>
				</div>
			</div>
			<div class="m-portlet__head-tools">
				<ul class="nav nav-tabs m-tabs-line m-tabs-line--right" role="tablist">
					
					@foreach ($cfg->tabs as $key => $group)
						<li class="nav-item m-tabs__item">
							<a class="nav-link m-tabs__link {{($tab == $key || (!$tab && !$loop->index))?'active':''}}" data-ref="{{$key}}" data-toggle="tab" href="#{{$key}}_tab_content" role="tab">
								{{$group['title']}}
							</a>
						</li>
					@endforeach
					
				</ul>
			</div>
		</div>
		<div class="m-portlet__body">
			<div class="tab-content">
				@foreach ($cfg->tabs as $key => $group)
					<div class="tab-pane {{($tab == $key || (!$tab && !$loop->index))?'active':''}}" id="{{$key}}_tab_content" role="tabpanel">
						<div class="{{$key}}-form ">
							<?php
								$formConfig = array_merge($group, [
                                    'config' => array_merge([
                                        'save_button_text' => 'Lưu',
                                        'cancel_button_text' => 'Hủy'
                                    ], isset($group['config'])?$group['config']:[]),
                                    'attrs' => [
                                        'method' => 'POST',
                                        'action' => (isset($group['url']) && $group['url']) ? $group['url'] : (
                                            isset($group['route']) ? route(
                                                $group['route'], 
                                                (isset($group['route_params']) && is_array($group['route_params'])) ? $group['route_params'] : []
                                            ) : '#'
                                        ),
                                        'id' => 'account-'.$key.'-option-form',
                                        'class' => 'crazy-form'
                                    ],
                                    'form' => $form,
                                    'data' => $data
                                ]);
							?>
							@include($_base.'forms.tab-form', $formConfig)
						</div>
					</div>
				@endforeach
			</div>
		</div>
    </div>
    
    
@endif