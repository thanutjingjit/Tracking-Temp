<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "temp";
// $username = "qhctllrq_tracking-temp";
// $password = "asdasd";
// $dbname = "qhctllrq_tracking-temp";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$conn->set_charset("utf8");
session_start();

function DateThai($strDate)
{
    $strYear = date("Y", strtotime($strDate)) + 543;
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));
    $strHour = date("H", strtotime($strDate));
    $strMinute = date("i", strtotime($strDate));
    $strSeconds = date("s", strtotime($strDate));
    $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    $strMonthThai = $strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear, $strHour:$strMinute";
}

function SetFormatDate($strDate)
{
    $datetime = explode(" ", $strDate);
    $time = explode(":", $datetime[0]);
    $date = explode("/", $datetime[1]);
    $startDate = $date[2] . '-' . $date[0] . '-' . $date[1] . ' ' . $datetime[0];
    return $startDate;
}
