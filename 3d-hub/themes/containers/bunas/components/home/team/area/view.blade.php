

    <!-- Star Team Area
    ============================================= -->
    <div class="team-area default-padding bottom-less bg-fixed half-bg-light shadow dark" style="background-image: url({{$data->background(theme_asset('img/banner/1.jpg'))}});">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="site-heading text-light text-center">
                        <h2>{{$data->title('Nhóm làm việc')}}</h2>
                        <p>
                            {{$data->description}}
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="team-members">
                    @if ($data->list_type == 'data')
                        @if ($data->item_number > 0 && count($members = $helper->getTeamMembers(['team_id' => $data->team_id, '@sort' => $data->sort_type, '@limit' => $data->item_number])))
                            @foreach ($members as $member)
                            <div class="col-md-4 single-item">
                                <div class="item">
                                    <div class="thumb">
                                        <img src="{{$member->avatar}}" alt="{{$member->name}}" alt="Thumb">
                                    </div>
                                    <div class="info">
                                        <p>
                                            {{$member->description}}
                                        </p>
                                        <div class="bottom">
                                            <div class="left">
                                                <h4>{{$member->name}}</h4>
                                                <span>{{$member->job}}</span>
                                            </div>
                                            <div class="right">
                                                <a href="{{$member->link?$member->link:'#'}}"><i class="fas fa-plus"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @endforeach
                        @endif
                    @else
                        {!! $html->team_members->components !!}
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
    <!-- End Team Area -->