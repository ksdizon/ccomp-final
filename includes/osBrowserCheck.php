<?php
    function getDevice($user_agent) {
        $os = getOperatingSystem($user_agent);
        $browser = getBrowser($user_agent);
        
        $computers = array(
            'Windows 10',
            'Windows 8.1',
            'Windows 8',
            'Windows 7',
            'Windows Vista',
            'Windows XP',
            'Windows XP',
            'Linux',
            'Ubuntu'
        );

        $mac = array(
            'Mac OS X',
            'Mac OS 9'
        );

        $mobiles = array(
            'Android',
            'BlackBerry'
        );

        $smart_devices = 'WebOS';
        $iPhone = 'iPhone';
        $iPod = 'iPod';
        $iPad = 'iPad';

        $device = 'Unknown';

        if (in_array($os, $computers)) {
            $device = 'Computer';
        } else if (in_array($os, $mac)) {
            $device = 'Mac';
        } else if (in_array($os, $mobiles)) {
            $device = 'Mobile';
        } else if ($os == 'WebOS') {
            $device = 'Smart Device';
        } else if ($os == 'iPhone') {
            $device = 'iPhone';
        } else if ($os == 'iPod') {
            $device = 'iPod';
        } else if ($os == 'iPad') {
            $device = 'iPad';
        }

        return array(
            'os' => $os,
            'browser' => $browser,
            'device' => $device
        );
    }

    function getOperatingSystem($user_agent) {    
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
            '/webos/i'             => 'WebOS',
        ];
    
        foreach ($os_array as $regex => $value) {
            if (preg_match($regex, $user_agent)) {
                $os_platform = $value;
            }
        }
        
        return $os_platform;
    }
    
    function getBrowser($user_agent) {
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