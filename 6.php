<pre>
<?php

$memory = explode("\t", trim(file_get_contents('6.txt')));

/*
each loop:
find key and value of max bank
set its value to 0
go to next bank and shift 1 of the value to it, repeat until you run out
if config seen before, bail
store new config
*/

// $memory = [0, 2, 7, 0]; // test value

echo time_taken();

$run = 0;
$configs[join(',', $memory)] = 1;
$count = count($memory);

// 6a
// while ($run < 100000) { // the problem story is about infinite loops and I always have bad luck with while loops already, soo I'm setting a bloody counter limit.
//     $run++;
//     $key = array_search($value = max($memory), $memory);
//     $memory[$key] = 0;
//     for ($i=$value; $i > 0; $i--) {
//         $key = ($key+1)%$count;
//         $memory[$key]+=1;
//     }
//     $config = join(',', $memory);
//     if (isset($configs[$config])) break; // using isset() takes ± 5% of the time in_array() takes, worth the hassle
//     $configs[$config] = 1;
// }
// echo "run: $run\n";
// echo time_taken();

// 6b
while ($run < 100000) {
    $run++;
    $key = array_search($value = max($memory), $memory);
    $memory[$key] = 0;
    for ($i=$value; $i > 0; $i--) {
        $key = ($key+1)%$count;
        $memory[$key]+=1;
    }
    $config = join(',', $memory);
    if (isset($configs[$config])) break;
    $configs[$config] = 1;
}

$configs = array_keys($configs);
echo $run - array_search($config, $configs)."\n\n"; // two lines extra for part b \o/

echo time_taken();



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