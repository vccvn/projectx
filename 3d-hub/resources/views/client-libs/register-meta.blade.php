{{-- neu co bai viet hoac san pham dc khai bao --}}
<?php
$full_title = get_title_by_breadcrumbs();
?>
@if(isset($article) && $article)
    @if ($full_title)
        @section('full_title', $full_title)
    @else
        @section('title', $article->getFullTitle())
    @endif
    @section('meta_title', $article->meta_title?$article->meta_title:($full_title??$article->getFullTitle().' | '.$siteinfo->site_name('DH Team')))
    @section('description',$article->getShortDesc(300))
    @section('meta_description',$article->meta_description?$article->meta_description:$article->getShortDesc(300))
    @section('keywords',$article->getSeoKeywords())
    @if($article->feature_image)
        @section('image',$article->getFeatureImage())
    @endif
    @section('page.type','article')
    @if(isset($category) && $category)
        @section('article_section',$category->name?$category->name:$category->title)
    @elseif($category = $article->category)
        @section('article_section',$category->name?$category->name:$category->title)
        
    @endif
    @section('published_time',$article->dateFormat('Y-m-d').'T'.$article->dateFormat('H:i:s').'+07:00')
    @section('modified_time',$article->updateTimeFormat('Y-m-d').'T'.$article->updateTimeFormat('H:i:s').'+07:00')
    @section('modified_time',$article->updateTimeFormat('Y-m-d').'T'.$article->updateTimeFormat('H:i:s').'+07:00')

@elseif($active_article = get_active_model('post')??(get_active_model('page')??(get_active_model('product')??(get_active_model('project')))))
    @if ($full_title)
        @section('full_title', $full_title)
    @else
        @section('title', $active_article->getFullTitle())
    @endif
    @section('meta_title', $active_article->meta_title?$active_article->meta_title:($full_title??($active_article->getFullTitle().' | '.$siteinfo->site_name('DH Team'))))
    @section('description',$active_article->getShortDesc(300))
    @section('meta_description',$active_article->meta_description?$active_article->meta_description:$active_article->getShortDesc(300))
    @section('keywords',$active_article->getSeoKeywords())
    @if($active_article->feature_image)
        @section('image',$active_article->getFeatureImage('social'))
    @endif
    @section('page.type','article')
    @if(isset($category) && $category)
        @section('article_section',$category->name?$category->name:$category->title)
    @elseif($category = $active_article->category)
        @section('article_section',$category->name?$category->name:$category->title)
    @endif
    @section('published_time',$active_article->dateFormat('Y-m-d').'T'.$active_article->dateFormat('H:i:s').'+07:00')
    @section('modified_time',$active_article->updateTimeFormat('Y-m-d').'T'.$active_article->updateTimeFormat('H:i:s').'+07:00')
@elseif(($category = get_active_model('post_category')) || ($category = get_active_model('product_category')) || ($category = get_active_model('project_category')))
    @if ($full_title)
        @section('full_title', $full_title)
    @else
        @section('title', $category->getFullTitle())
    @endif
    @section('meta_title', $full_title??$category->getFullTitle().' | '.$siteinfo->site_name('DH Team'))
    @if($category->feature_image)
        @section('image', $category->getFeatureImage())
    @endif
    @if($category->description)
        @section('description', $category->getShortDesc(500))
    @endif
    @if($category->keywords)
        @section('keywords', $category->keywords)
    @endif

@elseif(isset($page_title))
    @section('title', $page_title)
@endif

