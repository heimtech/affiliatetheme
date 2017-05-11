<?php

class TeaserSlider
{

    public function printContentTeaserSlider($postId, $postType)
    {
        $i = 0;
        
        $out = '';
        
        $slideEffect = get_field('ts_' . $postType . '_slide_effect', $postId);
        $dataInterval = get_field('ts_' . $postType . '_data_interval', $postId);
        $carouselIndicator = get_field('ts_' . $postType . '_carousel_indicator', $postId);
        $carouselControl = get_field('ts_' . $postType . '_carousel_control', $postId);
        
        $slideEffect = ($slideEffect == 'slideFade') ? 'carousel-fade' : '';
        
        $dataInterval = ($dataInterval > 99) ? $dataInterval : 3000;
        
        $out .= '<div id="carousel" class="teaser-slider-carousel carousel slide ' . $slideEffect . '" data-ride="carousel" data-interval="' . $dataInterval . '">';
        
        $indicators = '<ol class="carousel-indicators">';
        $slideWrappers = '<div class="carousel-inner" role="listbox">';
        
        $selector = 'ts_' . $postType . '_slideshow_images';
        
        $images = get_field($selector, $postId);
        $j = 0;
        
        if (is_array($images) && count($images) > 0) {
            
            foreach ($images as $image) {
                
                $slideshowImageKey = 'ts_' . $postType . '_slideshow_image';
                $imageBgcKey = 'ts_' . $postType . '_image_bgc';
                $textOnImageKey = 'ts_' . $postType . '_text_on_image';
                $slideshowLinkKey = 'ts_' . $postType . '_slideshow_link';
                $isExternLinkKey = 'ts_' . $postType . '_is_extern_link';
                $useNofollowKey = 'ts_' . $postType . '_use_nofollow';
                
                $slideshowImage = (isset($image[$slideshowImageKey])) ? $image[$slideshowImageKey] : array();
                $imageBgc = (isset($image[$imageBgcKey])) ? $image[$imageBgcKey] : '';
                
                $bgStyle = ($imageBgc !== "") ? ' style="background-color:' . $imageBgc . ';" ' : '';
                
                $textOnImage = (isset($image[$textOnImageKey])) ? $image[$textOnImageKey] : '';
                $slideshowLink = (isset($image[$slideshowLinkKey])) ? $image[$slideshowLinkKey] : '';
                $isExternLink = (isset($image[$isExternLinkKey])) ? $image[$isExternLinkKey] : false;
                $useNofollow = (isset($image[$useNofollowKey])) ? $image[$useNofollowKey] : false;
                
                $sizes = $slideshowImage['sizes'];
                $iClass = ($i == 0) ? 'active' : '';
                
                $indicators .= ' <li data-target="#carousel" data-slide-to="' . $i . '" class="' . $iClass . '"></li>';
                
                $itemClass = (isset($sizes['full_size']) && $sizes['full_size'] != "") ? '' : 'teaser-slider-text';
                
                $slideWrappers .= '<div class="item ' . $iClass . ' ' . $itemClass . ' " ' . $bgStyle . '>';
                
                if ($slideshowLink != "") {
                    $slideWrappers .= '<a class="slider-link" href="' . $slideshowLink . '"';
                    
                    if ($useNofollow) {
                        $slideWrappers .= ' rel="nofollow" ';
                    }
                    
                    if ($isExternLink) {
                        $slideWrappers .= ' target="_blank" ';
                    }
                    
                    $slideWrappers .= ' >';
                }
                
                
                if (isset($sizes)) {
                    $slideWrappers .= '<img class="teaser-slider-text-img" height="'.$slideshowImage['height'].'" width="'.$slideshowImage['width'].'" src="' . $sizes['full_size'] . '" alt="' . $slideshowImage['title'] . '">';
                    $j ++;
                }
                
                if ($textOnImage != "") {
                    
                    $slideWrappers .= '<div class="container">';
                    $slideWrappers .= '<div class="carousel-caption">';
                    
                    ob_start();
                    $textOnImage_ = str_replace('&#8220;', '"', $textOnImage);
                    $textOnImage_ = str_replace('&#8243;', '"', $textOnImage_);
                    $textOnImage_ = trim($textOnImage_);
                    echo apply_filters('the_content', $textOnImage_);
                    $textOnImage = ob_get_contents();
                    ob_end_clean();
                    
                    $slideWrappers .= $textOnImage.'<p>&nbsp;</p>';
                    
                    $j ++;
                    
                    $slideWrappers .= '</div>';
                    $slideWrappers .= '</div>';
                }
                
                if ($textOnImage != "") {
                    
                    if ($slideshowLink != "") {
                        $slideWrappers .= '</a>';
                    }
                }
                
                $slideWrappers .= '</div>';
                $i ++;
            }
            
            $indicators .= '</ol>';
            $slideWrappers .= '</div>';
            
            if ($carouselIndicator == 1) {
                $out .= $indicators;
            }
            
            $out .= $slideWrappers;
            
            if ($carouselControl == 1) {
                $out .= '<a class="left carousel-control" href="#carousel" role="button" data-slide="prev">';
                $out .= '<i class="fa fa-angle-left fa-2x"></i>';
                $out .= '</a>';
                $out .= '<a class="right carousel-control" href="#carousel" role="button" data-slide="next">';
                $out .= '<i class="fa fa-angle-right fa-2x"></i>';
                $out .= '</a>';
            }
            
            $out .= '</div>';
        }
        
        if ($j > 0) {
            return $out;
        } else {
            return '';
        }
    }
}
