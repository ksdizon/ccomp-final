<?php
    function getOperatingSystem() {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
    
        // Match the operating systems
        $os_platform = "Unknown OS";
    
        $os_array = [
            '/windows nt 10/i'     => 'Windows 10',
            '/windows nt 6.3/i'    => 'Windows 8.1',
            '/windows nt 6.2/i'    => 'Windows 8',
            '/windows nt 6.1/i'    => 'Windows 7',
            '/windows nt 6.0/i'    => 'Windows Vista',
            '/windows nt 5.1/i'    => 'Windows XP',
            '/windows xp/i'        => 'Windows XP',
            '/macintosh|mac os x/i'=> 'Mac OS X',
            '/mac_powerpc/i'       => 'Mac OS 9',
            '/linux/i'             => 'Linux',
            '/ubuntu/i'            => 'Ubuntu',
            '/iphone/i'            => 'iPhone',
            '/ipod/i'              => 'iPod',
            '/ipad/i'              => 'iPad',
            '/android/i'           => 'Android',
            '/blackberry/i'        => 'BlackBerry',
            '/webos/i'             => 'Mobile',
        ];
    
        foreach ($os_array as $regex => $value) {
            if (preg_match($regex, $user_agent)) {
                $os_platform = $value;
            }
        }
        
        return $os_platform;
    }
    
    function getBrowser() {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        // Match the browsers
        $browser = "Unknown Browser";

        $browser_array = [
            '/msie/i'      => 'Internet Explorer',
            '/firefox/i'   => 'Mozilla Firefox',
            '/safari/i'    => 'Safari',
            '/chrome/i'    => 'Google Chrome',
            '/edge/i'      => 'Edge',
            '/opera/i'     => 'Opera',
            '/netscape/i'  => 'Netscape',
            '/maxthon/i'   => 'Maxthon',
            '/konqueror/i' => 'Konqueror',
            '/mobile/i'    => 'Handheld Browser',
        ];

        foreach ($browser_array as $regex => $value) {
            if (preg_match($regex, $user_agent)) {
                $browser = $value;
            }
        }
        
        return $browser;
    }
?>