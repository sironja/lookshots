<?php
$a = array();
$a[1]= "2012-02-10 00:00:00";
$b= "2012-04-10 00:00:00";
 $start_date = new DateTime($a[1]);
$end_date = new DateTime($b);
$interval = $start_date->diff($end_date);
echo "Result " . $interval->y . " years, " . $interval->m." months, ".$interval->d." days <br>";
echo $interval->h. "Hours   " .$inertval->i. "Minuts   ".$interval->s."Seconds<br>";


echo "<br><br><br><br><br>";
$elapsed = $interval->format('%i ');//$interval->format('%y years %m months %d days %h hours %i minutes %S seconds');
//echo $elapsed;
$year = $interval->format('%y');
$mon = $interval->format('%m');
$day = $interval->format('%d');
$hr = $interval->format('%h');
$min = $interval->format('%i');
$sec = $interval->format('%s');
echo $year."<br>";
echo $mon."<br>";
echo $day."<br>";
echo $hr."<br>";
echo $min."<br>";
echo $sec."<br>";
?> 
 

