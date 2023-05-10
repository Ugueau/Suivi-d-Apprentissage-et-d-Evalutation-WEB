<?php
    $today = new DateTime();
    $today->setTimezone(new DateTimeZone("Europe/Paris"));
    $selectedDate = $today;

    function verify($var, $element) {
        if(!isset($var[$element])) {
            return false;
            if(empty($var[$element])) {
                return false;
            }
        }
        return true;
    }

    function numberToMonth($number) {
        switch($number) {
            case 1:
                return "Janvier";
            case 2:
                return "Février";
            case 3:
                return "Mars";
            case 4:
                return "Avril";
            case 5:
                return "Mai";
            case 6:
                return "Juin";
            case 7:
                return "Juillet";
            case 8:
                return "Août";
            case 9:
                return "Septembre";
            case 10:
                return "Octobre";
            case 11:
                return "Novembre";
            case 12:
                return "Décembre";
        }
        return null;
    }

    function getDayNumber($month, $year) {
        $month = intval($month);
        $year = intval($year);
        if($month === 1 || $month === 3 || $month === 5 || $month === 7 || $month === 8 || $month === 10 || $month === 12) {
            return 31;
        }else if($month === 4 || $month === 6 || $month === 9 || $month === 11){
            return 30;
        }else if($month === 2) {
            if($year%4 === 0) {
                return 29;
            }else{
                return 28;
            }
        }else{
            return 31;
        }
    }

    function getStringDay($dayNumber) {
        switch($dayNumber){
            case 1:
                return "Lun.";
            case 2:
                return "Mar.";
            case 3:
                return "Mer.";
            case 4:
                return "Jeu.";
            case 5:
                return "Ven.";
            case 6:
                return "Sam.";
            case 7:
                return "Dim.";
        }
    }

    function isEquals($date1, $date2, $args) {
        return $date1->format($args) === $date2->format($args);
    }