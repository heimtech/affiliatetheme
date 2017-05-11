<?php

class ACFP_PageBuilder
{

    private $html;

    private $hasSidebar;

    function __construct($hasSidebar)
    {
        $this->hasSidebar = $hasSidebar;
    }

    public function getFlexibleContentHTML($fieldName, $postId)
    {
        if (have_rows($fieldName, $postId)) :
            
            $this->html = '<div id="acfpb_sections">';
            
            while (have_rows($fieldName, $postId)) {
                the_row();
                
                // print layout element hr-tag
                if (get_row_layout() == 'acfp_hr') {
                    $this->html .= '<hr />';
                }
                
                $layout = get_row_layout();
                
                if (method_exists(get_class(), 'printContent' . $layout)) {
                    
                    $class = 'acfpb_section section-' . $layout;
                    
                    $style = get_sub_field('bg') ? 'background-color:' . get_sub_field('bg') : '';
                    
                    $wrapper = get_sub_field('wrapper_class');
                    
                    $this->html .= '<div  class="' . $class . '" style="' . $style . '">';
                    
                    $this->html .= '<div class="content">';
                    
                    if ($wrapper !== '') {
                        if (($this->hasSidebar)) {
                            $wrapper = 'col12';
                        }
                        $this->html .= '<div class="' . $wrapper . '">';
                    }
                    
                    $this->html .= $this->{'printContent' . $layout}();
                    
                    if ($wrapper !== '') {
                        $this->html .= '</div>';
                    }
                    
                    $this->html .= '<div class="row">';
                    $this->html .= '<div class="clearfix"></div>';
                    $this->html .= '</div>';
                    
                    $this->html .= '</div>';
                    $this->html .= '</div>';
                }
            }
            
            $this->html .= '</div>';
            
            
            return $this->html;
         

        else :
            
            return '';
        

        endif;
    }

    private function printContentBanner()
    {
        $out = '<div class="affiliseo-banner">';
        $out .= '<img src="' . get_sub_field('image') . '" class="img-responsive" />';
        
        if (get_sub_field('use_text')) {
            $out .= '<div class="silder-text">' . get_sub_field('text_on_image') . '</div>';
        }
        $out .= '</div>';
        return $out;
    }

    private function printContentButton()
    {
        $class = get_sub_field('button_class');
        $text = get_sub_field('button_text');
        $width = get_sub_field('width');
        
        switch (get_sub_field('link_to_page')) {
            
            case 'anchor':
                $href = '#' . get_sub_field('button_anchor');
                break;
            
            case 'external':
                $href = get_sub_field('external_link');
                break;
            
            case 'internal':
                $href = get_sub_field('internal_link');
                break;
            
            default:
                $href = '#';
                break;
        }
        
        return '<a href="' . $href . '" class="' . $class . ' ' . $width . '">' . $text . '</a>';
    }

    private function printContentContentGrid()
    {
        $blocks = get_sub_field('content_columns');
        
        $out = '';
        
        if (count($blocks) > 0) {
            
            foreach ($blocks as $block) {
                
                ob_start();
                $content = str_replace('&#8220;', '"', $block['content']);
                $content = str_replace('&#8243;', '"', $content);
                $content = trim($content);
                echo apply_filters('the_content', $content);
                $tempval = ob_get_contents();
                ob_end_clean();
                
                $out .= '<div class="col-sm-' . $block['width'] . ' col-sm-offset-' . $block['offset'] . '">';
                $out .= $tempval;
                $out .= '</div>';
            }
        }
        return $out;
    }

    private function printContentGallery()
    {
        $images = get_sub_field('images');
        $out = '';
        
        switch (get_sub_field('images_per_row')) {
            
            case '2':
                $class = 'col-sm-6';
                break;
            case '3':
                $class = 'col-sm-4';
                break;
            case '4':
                $class = 'col-sm-3';
                break;
            case '5':
                $class = 'col-sm-2 col-sm-20percent';
                break;
            case '6':
                $class = 'col-sm-2';
                break;
            default:
                $class = 'col-sm-12';
                break;
        }
        
        if (count($images) > 0) {
            
            $j = 1;
            
            foreach ($images as $item) {
                
                $out .= '<div class="' . $class . '">' . '<img src="' . $item['image'] . '" class="img-responsive" />';
                
                if ($item['title'] !== '') {
                    $out .= '<h4>' . $item['title'] . '</h4>';
                }
                
                if ($item['caption'] !== '') {
                    $out .= '<p>' . $item['caption'] . '</p>';
                }
                
                $out .= '</div>';
                
                if ((get_sub_field('images_per_row') == $j)) {
                    $out .= '<div class="clearfix"></div>';
                    $j = 0;
                }
                
                $j ++;
            }
        }
        return $out;
    }

    private function printContentSlideShow()
    {
        $images = get_sub_field('slideshow_images');
        $out = '';
        
        if (is_array($images) && count($images) > 0) {
            
            $dataInterval = (get_sub_field('data_interval') > 99) ? get_sub_field('data_interval') : 3000;
            
            $out .= '<div id="carousel" class="carousel slide" data-ride="carousel" data-interval="' . $dataInterval . '">';
            
            $indicators = '<ol class="carousel-indicators">';
            $slideWrappers = '<div class="carousel-inner" role="listbox">';
            
            $k = 0;
            foreach ($images as $item) {
                
                $textOnImage = (isset($item["text_on_image"])) ? $item["text_on_image"] : '';
                $slideshowLink = (isset($item["slideshow_link"])) ? $item["slideshow_link"] : '';
                $isExternLink = (isset($item["is_extern_link"])) ? $item["is_extern_link"] : false;
                $useNofollow = (isset($item["use_nofollow"])) ? $item["use_nofollow"] : false;
                
                $sizes = $item['slideshow_image']['sizes'];
                $iClass = ($k == 0) ? 'active' : '';
                
                $indicators .= ' <li data-target="#carousel" data-slide-to="' . $k . '" class="' . $iClass . '"></li>';
                $slideWrappers .= '<div class="item ' . $iClass . '">';
                $slideWrappers .= '<img src="' . $sizes['full_size'] . '" alt="' . $item['slideshow_image']['title'] . '">';
                
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
                
                if ($textOnImage != "") {
                    $slideWrappers .= '<span class="silder-text"> ' . $textOnImage . ' </span>';
                }
                
                if ($slideshowLink != "") {
                    $slideWrappers .= '</a>';
                }
                
                $slideWrappers .= '</div>';
                $k ++;
            }
            $indicators .= '</ol>';
            $slideWrappers .= '</div>';
            
            $out .= $indicators;
            $out .= $slideWrappers;
            
            $out .= '<a class="left carousel-control" href="#carousel" role="button" data-slide="prev">';
            $out .= '<i class="fa fa-angle-left fa-2x"></i>';
            $out .= '</a>';
            $out .= '<a class="right carousel-control" href="#carousel" role="button" data-slide="next">';
            $out .= '<i class="fa fa-angle-right fa-2x"></i>';
            $out .= '</a>';
            
            $out .= '</div>';
        }
        
        return $out;
    }

    private function printContentRawHtml()
    {
        return get_sub_field('html');
    }

    private function printContentWysiwyg()
    {
        $content = get_sub_field('wysiwyg_content');
        $content = str_replace('&#8220;', '"', $content);
        $content = str_replace('&#8243;', '"', $content);
        $content = str_replace('&#8211;', '"', $content);        
        $content = apply_filters('the_content', $content, true);
        
        return $content;
    }
}
