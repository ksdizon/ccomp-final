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

        $connection_date = date('Y-m-d');
        $connection_time = date('H:i:s');
        $user_ip = getUserIp();
        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        $internet_details = getIpGeoInformation($user_ip);
    
        $complete_connection_info = array (
            "connection_time" => $connection_date,
            "connection_time" => $connection_time,
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

        uploadDataToDatabase($complete_connection_info);
        print_r($complete_connection_info);
    }

    function uploadDataToDatabase($complete_connection_info) {
        // Establish database connection
        $conn = connect_db(); // Ensure this function returns a valid mysqli connection
    
        if (!$conn) {
            echo "Database connection failed.";
            return;
        }
    
        // Prepare an SQL statement to insert the data
        $stmt = $conn->prepare("
            INSERT INTO connections (
                connection_date, connection_time, ip_address, isp, device, os, using_vpn, browser, continent, region_name, city, country
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
    
        if (!$stmt) {
            echo "Statement preparation failed: " . $conn->error;
            return;
        }
    
        // Bind parameters to the statement
        $stmt->bind_param(
            'ssssssssssss',
            $complete_connection_info['date'],
            $complete_connection_info['time'],
            $complete_connection_info['ip'],
            $complete_connection_info['isp'],
            $complete_connection_info['device'],
            $complete_connection_info['os'],
            $complete_connection_info['vpn_user'],
            $complete_connection_info['browser'],
            $complete_connection_info['continent'],
            $complete_connection_info['region_name'],
            $complete_connection_info['city'],
            $complete_connection_info['country']
        );
    
        // Execute the statement and check for success
        if ($stmt->execute()) {
            echo "Data uploaded successfully!";
        } else {
            echo "Error uploading data: " . $stmt->error;
        }
    
        // Close the statement and the connection
        $stmt->close();
        $conn->close();
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