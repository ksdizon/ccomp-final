<?php
/*
    Tracks the following user information
        1. IP Address
        2. Continent
        3. Country
        4. Region
        5. City
        6. ISP
        7. Proxy
        8. Operating System
        9. Browser
*/
    include 'connectDb.php';
    include 'osBrowserCheck.php';

    collateConnectionInfo();

    function collateConnectionInfo() {
        /*
        
        */
        date_default_timezone_set('Asia/Manila');

        $current_date = date('Y/d/m');
        $current_time = date('H:i:s');
        $user_ip = getUserIp();
        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        $internet_details = getIpGeoInformation($user_ip);
    
        $complete_connection_info = array (
            "date" => $current_date,
            "time" => $current_time,
            "visited_before" => hasUserConnectedBefore(),
            "ip" => $user_ip,
            "isp" => $internet_details['isp'],
            "device" => "device",
            "os" => getOperatingSystem($user_agent),
            "vpn_user" => $internet_details['proxy'],
            "browser" => getBrowser($user_agent),
            "continent" => $internet_details['continent'],
            "region_name" => $internet_details['regionName'],
            "city" => $internet_details['city'],
            "country" => $internet_details['country']
        );

        if ( $complete_connection_info["vpn_user"] == null) {
            $complete_connection_info["vpn_user"] = "false";
        }

        print_r($complete_connection_info);
    }

    function getUserIp() {
        /*
            Rertrieves the ip address of user
        */
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    function getIpGeoInformation($user_ip) {
        /*
            Use ip-api to retrieve geolocation from ip address.
            Limited to only 45 requests per minute.
        */
        $api_url = "http://ip-api.com/php/{query}?fields=status,continent,country,regionName,city,isp,proxy";

        // REMOVE LATER: 120.29.77.7
        $response = file_get_contents(str_replace("{query}", "120.29.77.7", $api_url));

        // convert the result to a php array
        return unserialize($response);
    }

    function hasUserConnectedBefore() {
        if (isset($_COOKIE['visited'])) {
            return "true";
        } else {
            // Generate a new cookie if it doesn't exist
            list($usec, $sec) = explode(" ", microtime());
            $expire = time() + 60 * 60 * 24 * 30; // Expire in 30 days
            $cookie_value = md5($sec . "." . $usec); // Create a unique hash
            setcookie("visited", $cookie_value, $expire, "/", "", false); // Set the cookie
            
            return "false";
        }
    }
?>