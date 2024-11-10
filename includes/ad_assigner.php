<?php
    function ads_for_guests() {
        $ads = array(
            "upDLs1sn7g4",
            "HzVkeomiwSY",
            "8IHhvkaVqVE",
            "AJcc2xFRm74",
            "pgpwma0QxZ0",
            "3uCWL0EoDm0"
        );
        $random_index = random_int(0, count($ads) - 1);
        return $ads[$random_index]; 
    }

    function ads_for_users($age, $gender) {
        $age = intval($age);

        if ($gender == "Male") {
            if ($age < 18){
                return "hDbeBqYZtUA";
            } else if ($age >= 18 && $age <= 34) {
                return "TTfkYPgSpkQ";
            } else {
                return "KIvC5wsoW2Y";
            }
        } else if ($gender == "Female") {
            if ($age < 18){
                return "vo6AQHQTKtE";
            } else if ($age >= 18 && $age <= 34) {
                return "ebfXWwgjDPI";
            } else {
                return "ecsVyIOY-Ig";
            }
        } else {
            return ads_for_guests();
        }
    }
?>