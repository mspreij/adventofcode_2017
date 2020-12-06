<pre>
<?php

$lines = explode("\n", trim(file_get_contents('4.txt')));

// 4a
// $valid = 0;
// foreach ($lines as $line) {
//     $phrase = explode(' ', $line);
//     $c = count($phrase);
//     $nc = count(array_flip(array_flip($phrase)));
//     if ($c === $nc) $valid++;
// }
// echo $valid;

// 4b
$valid = 0;
foreach ($lines as $line) {
    $phrase = explode(' ', $line);
    $c = count($phrase);
    $nc = count(array_flip(array_flip($phrase)));
    if ($c !== $nc) continue;
    $phrase = array_map(function($a) {$a = str_split($a); sort($a); return join('', $a);}, $phrase);
    $nc = count(array_flip(array_flip($phrase)));
    if ($c === $nc) $valid++;
}
echo $valid;

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