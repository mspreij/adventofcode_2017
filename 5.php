<pre>
<?php

$lines = explode("\n", trim(file_get_contents('5.txt')));

// 5a
// $i = 0;
// $steps = 0;
// while(isset($lines[$i])) {
//     $val = $lines[$i];
//     $lines[$i] += 1;
//     $i = $i + $val;
//     $steps++;
// }
// echo $steps;

// 5b
$i = 0;
$steps = 0;
while(isset($lines[$i])) {
    $val = $lines[$i];
    $lines[$i] += (($val >= 3) ? -1 : 1);
    $i = $i + $val;
    $steps++;
}
echo $steps;

//_____________________________________
// time_taken($tally=0, $precision=5) /
function time_taken($tally=0, $precision=5) {
    static $start = 0; // first call
    static $notch = 0; // tally calls
    static $time  = 0; // set to time of each call (after setting $duration)
    $now = microtime(1);
    if (! $start) { // init, basically
        $time = $notch = $start = $now;
        return "Starting at $start.\n\n";
    }
    $duration = $now - $time;
    $time = $now;
    $out = "That took ".round($duration, $precision)." seconds.\n";
    if ($tally) { // time passed since last tally
        $since_start      = $now - $start;
        $since_last_notch = $now - $notch;
        $notch = $now;
        $out .= "<br>". round($since_start, $precision) .' seconds since start'.($since_start!=$since_last_notch ? ' ('.round($since_last_notch, $precision) .' since last sum).':'.');
    }
    return $out;
}


?>