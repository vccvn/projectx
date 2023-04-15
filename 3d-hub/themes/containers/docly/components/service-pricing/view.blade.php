@php
    
    $args = [];
    if($data->service_id){
        $args['id'] = $data->service_id;
    }else{
        $args['@limit'] = 3;
    }
    $args['@order_by'] = ['services.id' => 'ASC'];
    $args['@withPackages'] = [
        '@sort' => ['services_packages.price' => 'ASC']
    ];

@endphp

@if (count($services = $helper->getServices($args)))
    
<div id="pricing" class="ptb-100 biz-bg-2">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="headingOne text-left">
                    <h6 class="sub">{{$data->sub_title}}</h6>
                    <h2>{{$data->title('Bảng giá')}}</h2>
                </div>
                <p>{{$data->description}}</p>

                <ul class="nav nav-pills pricing-tab-list" role="tablist">
                    @foreach ($services as $service)
                        
                    <li class="nav-item">
                        <a href="#pricing-service-{{$service->id}}" class="nav-link {{$loop->first?'active':''}}" 
                            role="tab" data-toggle="tab" aria-expanded="false" id="tab-{{$service->id}}" 
                            aria-controls="card" aria-selected="true">
                            {{$service->name}}
                        </a>
                    </li>

                    @endforeach

                </ul>
            </div>

            <div class="col-md-9">
                <div class="tab-content tab-space">
                    @foreach ($services as $service)
                        <div class="tab-pane fade {{$loop->first?'show active':''}}" id="pricing-service-{{$service->id}}" role="tabpanel" aria-labelledby="tab-{{$service->id}}">
                            <div class="row">
                                @if ($service->packages && count($service->packages))
                                    @foreach ($service->packages as $package)
                                        <div class="col-md-4">
                                            <div class="card card-pricing card-{{$package->account_type == $data->active_type?'raised': 'plain'}}">
                                                <div class="card-content">
                                                    <h6 class="category">{{$package->package_name}}</h6>
                                                    <h3 class="card-title">{{number_format($package->price, 0, ',', '.')}}<small>Đ</small></h3>
                                                    <ul>
                                                        {!! 
                                                            implode('', array_map(function($line){
                                                                return '<li>'
                                                                    . str_replace(
                                                                        ['[t]', '[T]', '[check]', '[v]'],
                                                                        '<i class="fas fa-check"></i>',
                            
                                                                        str_replace(
                                                                            ['[f]', '[F]', '[times]', '[x]'],
                                                                            '<i class="fas fa-times"></i>',
                                                                            $line
                                                                        )
                                                                    )
                                                                .'</li>';
                                                            }, nl2array($package->features)))
                                                        !!}
                                                    </ul>
                                                    <div class="buy-btn">
                                                        <a href="{{
                                                            route('client.services.add', [
                                                                'service_id' => $service->id, 
                                                                'package_id' => $package->id
                                                            ])
                                                            }}" class="biz-btn-{{$package->account_type == $data->active_type?'solid': 'outline'}}">
                                                            Đăng ký
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>


@endif