<?php
/*
    Tracks the following user information
*/    
    include 'connectDb.php';
    include 'osBrowserCheck.php';

    function collateConnectionInfo() {
        date_default_timezone_set('Asia/Manila');

        $connection_date = date('Y-m-d');
        $connection_time = date('H:i:s');
        $user_ip = getUserIp();
        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        $internet_details = getIpGeoInformation($user_ip);
        $device_info = getDeviceInfo($user_agent);
    
        $complete_connection_info = array (
            ":user_id" => $_SESSION['user_id'],
            ":connection_date" => $connection_date,
            ":connection_time" => $connection_time,
            ":ip_address" => $user_ip,
            ":isp" => $internet_details['isp'],
            ":device" => $device_info['device'],
            ":os" => $device_info['os'],
            ":browser" => $device_info['browser'],
            ":continent" => $internet_details['continent'],
            ":region_name" => $internet_details['regionName'],
            ":city" => $internet_details['city'],
            ":country" => $internet_details['country']
        );

        // Check if the user is using a VPN
        $complete_connection_info["using_vpn"] = $internet_details['proxy'] != null ? 1 : 0;

        uploadDataToDatabase($complete_connection_info);
    }

    function uploadDataToDatabase($complete_connection_info) {
        $database_handler = connect_db();

        $insert_sql ="
            INSERT INTO CONNECTIONS
            (user_id, connection_date, connection_time, ip_address, isp, device, os, using_vpn, browser, continent, region_name, city, country)
            VALUES
            (:user_id, :connection_date, :connection_time, :ip_address, :isp, :device, :os, :using_vpn, :browser, :continent, :region_name, :city, :country)
        ";

        $insert_stmt = $database_handler->prepare($insert_sql);
        $insert_stmt -> execute($complete_connection_info);
        
        // Close the statement and the connection
        $check_stmt = null;
        $insert_stmt = null;
        $database_handler = null;
    }

    function getUserIp() {
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
        $api_url = "http://ip-api.com/php/{query}?fields=status,continent,country,regionName,city,isp,proxy";

        // REMOVE LATER
        if ($user_ip == '127.0.0.1') {
            $user_ip = '120.29.77.7';
        }

        $response = file_get_contents(str_replace("{query}", $user_ip, $api_url));

        return unserialize($response);
    }
?>
