<pre>
<?php

// 7a - a terrible shortcut but it works!
// preg_match_all('/([a-z]+)/', file_get_contents('7.txt'), $matches);
// foreach ($matches[1] as $match) @$out[$match]++;
// echo array_flip($out)[1];


// 7b
$lines = explode("\n", trim(file_get_contents('7.txt')));

// sample data
$linzes = explode("\n", "pbga (66)
xhth (57)
ebii (61)
havc (66)
ktlj (57)
fwft (72) -> ktlj, cntj, xhth
qoyq (66)
padx (45) -> pbga, havc, qoyq
tknk (41) -> ugml, padx, fwft
jptl (61)
ugml (68) -> gyxo, ebii, jptl
gyxo (61)
cntj (57)");

$index = []; // name => weight, total_weight, [children]
// get the data in a list
foreach ($lines as $line) {
    $parts = explode(' -> ', $line);
    preg_match('/(\w+) \((\d+)\)/', $parts[0], $stats);
    list($ignore, $name, $weight) = $stats;
    $index[$name] = ['weight'=>$weight];
    if (isset($parts[1])) {
        $index[$name]['children'] = explode(', ', $parts[1]);
    }
}

// add total_weight
foreach ($index as $name => $data) {
    $index[$name]['total_weight'] = get_total_weight($name);
}
// find the unbalanced disc(s). there is probably a way to do that in one go with the above, but...
echo hunt_down_wayward_child('hlhomy');


function hunt_down_wayward_child($name)
{
    global $index;
    $data = $index[$name];
    if (! isset($data['children'])) {
        echo "mismatch -> {$data['weight']}\n";
        return $name;
    }else{
        // check total_weight children, follow the non-matching one
        foreach ($data['children'] as $child) {
            $weights[$child] = $index[$child]['total_weight'];
        }
        $weight = array_search(1, array_count_values($weights));
        if ($weight) {
            $name = array_search($weight, $weights);
            echo "$name seems off, $weight out of ".join(', ', $weights)."\n";
            return hunt_down_wayward_child($name);
        }else{
            echo "it was $name! To wit:";
            var_export($index[$name]); // and *you* do the rest of the math o.o
            return $name;
        }
    }
}


function get_total_weight($name)
{
    global $index;
    if (isset($index[$name]['total_weight'])) {
        return $index[$name]['total_weight'];
    }
    $out = $index[$name]['weight'];
    if (isset($index[$name]['children'])) {
        foreach ($index[$name]['children'] as $child) {
            $out += get_total_weight($child);
        }
    }
    return $out;
}


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