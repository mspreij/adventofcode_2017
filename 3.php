<pre><?php
$input = 347991;

// 3a
/*
17  16  15  14  13
18   5   4   3  12
19   6   1   2  11
20   7   8   9  10
21  22  23---> ...

Realize the thing has the shape of a square, which has a square root, which, when rounded, and squared again, should sit at one of the corners (top-left or bottom-right).
The range of the answer is around sqrt/2 .. sqrt/2 + x.
Input: 347991, sqrt 589.9 -> 590, squared again 348100, which is even so it's top-left corner, at coords [-295, 295]. Ish.
348100 - 347991 = 109 so take that off the x coord, yielding [-186, 295]. Ish.
Which would give a manhattan distance of 481. Which is wrong. But it's probably close!
Spoiler: it was 480.
*/


// [2020-12-05 23:53:38] so yeah.. it worked, but ehr. I'll try and do it properly now.
// 3a take 2
$x = $y = 0;
$loc[$x][$y] = 1; // aka $loc = [[1]];
$min = $max = [0,0]; // for drawing things, later
$dirs = [
    [1,0],
    [0,-1],
    [-1,0],
    [0,1],
];
$dir = 0;

// $counter = 1;
// for ($i=1; $i < $input; $i++) {
//     $counter++;
//     // move, check surroundings, change direction if possible
//     $move = $dirs[$dir];
//     $x += $move[0];
//     $y += $move[1];
//     $max = [max($x, $max[0]), max($y, $max[1])];
//     $min = [min($x, $min[0]), min($y, $min[1])];
//     $loc[$x][$y] = $counter;
//     $next_dir = ($dir + 1)%4;
//     $next_x = $x + $dirs[$next_dir][0];
//     $next_y = $y + $dirs[$next_dir][1];
//     if (! isset($loc[$next_x][$next_y])) {
//         $dir = $next_dir;
//     }
// }
// echo "$x, $y: ".(abs($x) + abs($y));

// 3b
$counter = 1;
while ($loc[$x][$y] < $input) {
    $counter++;
    // move, check surroundings and add them up, change direction if possible
    $move = $dirs[$dir];
    $x += $move[0];
    $y += $move[1];
    $max = [max($x, $max[0]), max($y, $max[1])];
    $min = [min($x, $min[0]), min($y, $min[1])];
    $loc[$x][$y] = sum_surrounding($loc, $x, $y);
    $next_dir = ($dir + 1)%4;
    $next_x = $x + $dirs[$next_dir][0];
    $next_y = $y + $dirs[$next_dir][1];
    if (! isset($loc[$next_x][$next_y])) {
        $dir = $next_dir;
    }
}
echo "$x, $y: ". $loc[$x][$y];

function sum_surrounding($loc, $x, $y)
{
    $out = 0;
    for ($i=-1; $i <= 1; $i++) {
        for ($j=-1; $j <= 1; $j++) {
            if (!$i and !$j) continue;
            $out += $loc[$x+$i][$y+$j] ?? 0;
        }
    }
    return $out;
}

// table? if it fits..
if ($max[1] < 5) {
    echo '<table>';
    for ($y=$min[1]; $y <= $max[1]; $y++) {
        echo '<tr>';
        for ($x=$min[0]; $x <= $max[0]; $x++) {
            if (! isset($loc[$x][$y])) $loc[$x][$y] = ' ';
            echo "<td>{$loc[$x][$y]}</td>";
        }
        echo '</tr>';
        # code...
    }
    echo '</table>';
}

?>
<style>
    td, table {
        border: 1px solid black;
    }
</style>