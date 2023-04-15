<div class="col-lg-{{$data->col_lg(4)}} col-sm-{{$data->col_sm(6)}} service_item">
    <a href="{{$data->url}}">
        <div class="media theme_doc_item wow fadeInUp">
            <img src="{{$data->img_icon}}" alt="">
            <div class="media-body">
                
                <h4 class="c_head">{{$data->title}}</h4>
                
                <p>{{$data->description}}</p>
            </div>
        </div>
    </a>
</div>