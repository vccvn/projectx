
@if (is_array($cfg->tabs))
    
<?php $form->addClass('m-form m-form--fit m-form--label-align-left crazy-form');?>
<form {!! $form->attrsToStr() !!}>
    @csrf
    {!! $form->hidden_id !!}
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
                                    'config' => isset($group['config'])?$group['config']:[],
                                    'data' => $data
                                ]);
							?>
							@include('admin.forms.tab-inputs', $formConfig)
						</div>
					</div>
				@endforeach
			</div>
        </div>
        <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
            <div class="m-form__actions m-form__actions--solid">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <button type="submit" class="btn btn-info btn-submit-form">
                            {{$cfg->save_button_text}}
                        </button>
                        <a href="{{$cfg->cancel_button_url}}" class="btn btn-secondary">
                            {{$cfg->cancel_button_text}}
                        </a>
                    </div>
                    
                    
                </div>
            </div>
        </div>
    </div>
    
    
</form>
@endif