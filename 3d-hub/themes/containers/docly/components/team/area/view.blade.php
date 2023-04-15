@php
    $title = null;
    if($data->title) $title = $data->title;
    $attr = docly_section_attrs($data, [
        'class' => 'section section-teams ptb-100'
    ]);
@endphp

<section  {!!$attr!!}>
    <div class="container">
        <div class="mb-5 text-center section-title">
            <h2 class="mb-2">{{$title}}</h2>
            <p>{{$data->description}}</p>
        </div>

        <div class="teams-section">
            <div class="row">
                @if ($data->list_type == 'data')
                    @if ($data->item_number > 0 && count($members = $helper->getTeamMembers(['team_id' => $data->team_id, '@sort' => $data->sort_type, '@limit' => $data->item_number])))
                        @foreach ($members as $member)
                        <div class="col-sm-6 col-lg-3 team-item">
                            <div class="thumb-summary-wrap box-shadow-block">
                                <div class="team-thumb">
                                    <a href="{{$member->link?$member->link:'#'}}" target="-sefl"> 
                                        <img src="{{$member->avatar}}" alt="{{$member->name}}">
                                    </a>
                                </div><!-- .team-thumb-->
                                <div class="team-text-wrap">
                                    <h3 class="team-title"><a href="#">{{$member->name}}</a></h3>
                                    <p class="team-position">{{$member->job}}</p>
                                </div><!-- .team-text-wrap -->
                                <div class="social-links circle">
                                    <ul>
                                        <li><a href="http://facebook.com/" target="_blank">Facebook</a></li>
                                        {{-- <li><a href="http://twitter.com/" target="_blank">Twitter</a></li>
                                        <li><a href="http://linkedin.com/" target="_blank">Linkedin</a></li>
                                        <li><a href="http://instagram.com/" target="_blank">Instagram</a></li> --}}
                                    </ul>
                                </div><!-- .social-links -->
                            </div> <!-- .team-item -->
                        </div> <!-- .team-item  -->


                        @endforeach
                    @endif
                @else
                    {!! $html->team_members->components !!}
                @endif

                {{-- <div class="more-wrapper">
                    <a href="#" class="custom-button button-curved">Explore More</a>
                </div> --}}
            </div> <!-- .inner-wrapper -->
        </div> <!-- .teams-section -->
    </div> <!-- .container -->
</section> <!-- .section section-teams -->