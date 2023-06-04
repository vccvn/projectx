<div class="our-story">
    <div class="row stories">
        <div class="col-10 col-sm-6 ml-auto mr-auto">
            <div class="first-story story">
                <div class="content-box">
                    <h3 class="story-title">{{$data->first_title}}</h3>
                    <div class="story-content">{{$data->first_content}}</div>
                </div>
                <div class="story-image">
                    <img src="{{$data->first_image}}" alt="{{$data->first_title}}">
                </div>
            </div>

        </div>
        <div class="col-10 col-sm-6 ml-auto mr-auto">
            <div class="second-story story">
                <div class="content-box">
                    <h3 class="story-title">{{$data->second_title}}</h3>
                    <div class="story-content">{{$data->second_content}}</div>
                </div>
                <div class="story-image">
                    <img src="{{$data->second_image}}" alt="{{$data->second_title}}">
                </div>
            </div>

        </div>
    </div>
    <div class="buttons">
        <a href="{{$data->url}}" class="btn-story mien-button">{{$data->btn_text('our stories')}}</a>
    </div>
</div>