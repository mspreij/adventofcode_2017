<?php
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
?>