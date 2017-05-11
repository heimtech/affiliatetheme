<?php

class ProductReviews
{

    private $html;

    private $hasSidebar;

    private $postId;

    private $affiliseoOptions;

    function __construct($hasSidebar)
    {
        $this->hasSidebar = $hasSidebar;
        
        $this->affiliseoOptions = getAffiliseoOptions();
    }

    public function getReviewContentsHTML($postId)
    {
        if (isset($this->affiliseoOptions['hide_product_review']) && $this->affiliseoOptions['hide_product_review'] == 1) {
            return '';
        }
        
        $this->postId = $postId;
        
        $this->html .= '<div class="content">';
        
        $this->html .= '<div class="col12">';
        
        $this->html .= '<div class="product-reviews-header"><strong>' . $this->affiliseoOptions['product_review_description'] . '</strong></div>';
        
        $productReviewSummary = get_field('ProductReviewSummary', $this->postId);
        
        $productReviewTextArea = get_field('ProductReviewTextArea', $this->postId);
        
        $colSm = 'col-sm-12';
        
        if ($productReviewSummary == true) {
            
            $percentageAverage = $this->getPercentageAverage($this->postId);
            
            $colSm = 'col-sm-9';
            
            if ($percentageAverage <= 25) {
                $reviewRating = (isset($this->affiliseoOptions['product_review_rating1'])) ? $this->affiliseoOptions['product_review_rating1'] : 'SCHLECHT';
            } elseif ($percentageAverage > 25 && $percentageAverage <= 50) {
                $reviewRating = (isset($this->affiliseoOptions['product_review_rating2'])) ? $this->affiliseoOptions['product_review_rating2'] : 'BEFRIEDIGEND';
            } elseif ($percentageAverage > 50 && $percentageAverage <= 75) {
                $reviewRating = (isset($this->affiliseoOptions['product_review_rating3'])) ? $this->affiliseoOptions['product_review_rating3'] : 'GUT';
            } elseif ($percentageAverage >= 75) {
                $reviewRating = (isset($this->affiliseoOptions['product_review_rating4'])) ? $this->affiliseoOptions['product_review_rating4'] : 'SEHR GUT';
            }
            
            $this->html .= '<div class="col-sm-3">';
            
            $this->html .= '<div>';
            $this->html .= '<div class="product-reviews-summary-top">' . $this->printProductReviewText($this->postId);
            $this->html .= '<div class="clearfix"></div>';
            $this->html .= '<strong class="product-reviews-summary-percent">' . number_format($percentageAverage, 2, ',', '') . '%</strong>';
            $this->html .= '</div>';
            $this->html .= '<div class="product-reviews-summary-bottom"> ' . $reviewRating . ' </div>';
            $this->html .= '</div>';
            $this->html .= '</div>';
        }
        
        $this->html .= '<div class="' . $colSm . '">';
        
        $productReviewRatings = $this->printProductReviewRatings();
        $this->html .= $productReviewRatings;
        
        $this->html .= '</div>';
        
        $this->html .= '<div class="clearfix"></div>';
        
        if ($productReviewTextArea == true) {
            $this->html .= $this->printProductReviewWysiwyg();
        }
        
        $this->html .= '<div class="clearfix"></div>';
        
        $this->html .= '</div>';
        $this->html .= '</div>';
        
        // if no review exists then print blank string
        if ($productReviewRatings == "") {
            $this->html = '';
        }
        
        return $this->html;
    }

    private function printProductReviewRatings()
    {
        $out = '';
        
        if (have_rows('ProductReviewRatings')) {
            
            while (have_rows('ProductReviewRatings')) {
                the_row();
                
                $productReviewProperty = get_sub_field('product_review_property');
                $productReviewPercentage = get_sub_field('product_review_percentage');
                $productReviewHint = get_sub_field('product_review_hint');
                
                if ($productReviewHint != "") {
                    $productReviewHint = '( ' . $productReviewHint . ' )';
                }
                
                if ($productReviewPercentage <= 40) {
                    $progressbarClass = 'progress-bar progress-bar-danger';
                } elseif ($productReviewPercentage > 40 && $productReviewPercentage <= 50) {
                    $progressbarClass = 'progress-bar progress-bar-warning';
                } elseif ($productReviewPercentage > 50 && $productReviewPercentage <= 70) {
                    $progressbarClass = 'progress-bar progress-bar-info';
                } elseif ($productReviewPercentage >= 70) {
                    $progressbarClass = 'progress-bar progress-bar-success';
                }
                
                $out .= '<div class="col-sm-3"><strong>' . $productReviewProperty . '</strong></div>';
                $out .= '<div class="col9">';
                $out .= '<div class="progress">';
                $out .= '<div class="' . $progressbarClass . '" style="width: ' . $productReviewPercentage . '%;">' . $productReviewPercentage . '% ' . $productReviewHint . '</div>';
                $out .= '</div>';
                $out .= '</div>';
                $out .= '<div class="clearfix"></div>';
            }
        }
        
        return $out;
    }

    public function getPercentageAverage($postId)
    {
        $percentageAverage = 0;
        
        if (have_rows('ProductReviewRatings', $postId)) {
            $i = 0;
            $percentageSum = 0;
            
            while (have_rows('ProductReviewRatings', $postId)) {
                
                the_row();
                
                $percentageSum += get_sub_field('product_review_percentage');
                
                $i ++;
            }
            
            if ($percentageSum > 0) {
                $percentageAverage = $percentageSum / $i;
            }
        }
        
        return $percentageAverage;
    }

    public function printProductReviewText($postId)
    {
        return get_field('ProductReviewText', $postId);
    }

    private function printProductReviewWysiwyg()
    {
        $content = get_field('ProductReviewWysiwyg', $this->postId);
        $content = str_replace('&#8220;', '"', $content);
        $content = str_replace('&#8243;', '"', $content);
        $content = apply_filters('the_content', $content, true);
        
        $content = '<div class="product-reviews-footer">' . $content . '</div>';
        
        return $content;
    }
}