<?php

class AsCookiePolicy
{

    private $asOptions = array();

    private $disableCookiePolicy = '';

    private $message = '';

    private $acceptButton = '';

    private $hideReadMoreButton = '';

    private $readMoreButton = '';

    private $readMoreLink = '';

    private $expire = 84600;

    private $messagePosition = 'bottom';

    private $hideEffect = 'fade';

    function __construct()
    {
        $this->asOptions = getAffiliseoOptions();
        
        if (isset($this->asOptions['disable_cookie_policy_function']) && $this->asOptions['disable_cookie_policy_function'] != "") {
            $this->disableCookiePolicy = $this->asOptions['disable_cookie_policy_function'];
        }
        
        if (isset($this->asOptions['cookie_policy_message']) && $this->asOptions['cookie_policy_message'] != "") {
            $this->message = $this->asOptions['cookie_policy_message'];
        } else {
            $this->message = __('To make this site work properly, we place small data files called cookies on your device.', 'affiliatetheme');
        }
        
        if (isset($this->asOptions['cookie_policy_accept_button']) && $this->asOptions['cookie_policy_accept_button'] != "") {
            $this->acceptButton = $this->asOptions['cookie_policy_accept_button'];
        } else {
            $this->acceptButton = __('Ok', 'affiliatetheme');
        }
        
        if (isset($this->asOptions['hide_cookie_policy_read_more_button']) && $this->asOptions['hide_cookie_policy_read_more_button'] != "") {
            $this->hideReadMoreButton = $this->asOptions['hide_cookie_policy_read_more_button'];
        }
        
        if (isset($this->asOptions['cookie_policy_read_more_button']) && $this->asOptions['cookie_policy_read_more_button'] != "") {
            $this->readMoreButton = $this->asOptions['cookie_policy_read_more_button'];
        } else {
            $this->readMoreButton = __("more information", 'affiliatetheme');
        }
        
        if (isset($this->asOptions['cookie_policy_read_more_link']) && $this->asOptions['cookie_policy_read_more_link'] != "") {
            $this->readMoreLink = $this->asOptions['cookie_policy_read_more_link'];
        }
        
        if (isset($this->asOptions['cookie_policy_expire']) && $this->asOptions['cookie_policy_expire'] != "") {
            $this->expire = $this->asOptions['cookie_policy_expire'];
        }
        
        if (isset($this->asOptions['cookie_policy_message_position']) && $this->asOptions['cookie_policy_message_position'] != "") {
            $this->messagePosition = $this->asOptions['cookie_policy_message_position'];
        }
        
        if (isset($this->asOptions['cookie_policy_hide_effect']) && $this->asOptions['cookie_policy_hide_effect'] != "") {
            $this->hideEffect = $this->asOptions['cookie_policy_hide_effect'];
        }
    }

    public function writeCookiePolicyBar()
    {
        $out = '<div  id="as-cookie-policy-bar" class="cookie-policy-bar" style="' . $this->messagePosition . ':0;">';
        $out .= '<span class="cookie-policy-message"> ' . $this->message . ' </span>';
        $out .= '<a href="#" id="cookie-policy-accept-button" class="cookie-policy-accept-button btn">' . $this->acceptButton . '</a>';
        
        if ($this->hideReadMoreButton != 1) {
            $out .= '<a href="' . $this->readMoreLink . '" target="_blank" class="cookie-policy-read-more-button btn">' . $this->readMoreButton . '</a>';
        }
        
        $out .= '</div>';
        
        return $out;
    }

    public function writeCookiePolicyJsVars()
    {
        $out = 'cookiePolicyHideEffect = "' . $this->hideEffect . '"; ' . "\n";
        $out .= 'cookiePolicyExpireTime = ' . $this->expire . ';' . "\n";
        
        return $out;
    }
}
