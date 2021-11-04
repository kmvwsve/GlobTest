<?php  

function foo($array) {
	$isBreak = false;
	$return = [];

	if($array) {
		// Init min & max
		$min = min(current($array));
		$max = max(current($array));

		foreach ($array as $arr) {
			// Vérifier si l'intervalle est coupé
			if(min($arr) > $max || max($arr) < $min) {
				$isBreak = true;
			}

			if(!$isBreak) {			
				// Valeur min
				if(min($arr) < $min) {
					$min = min($arr);
				}

				// Valeur max
				if(max($arr) > $max) {
					$max = max($arr);
				}
			} else {
				$isBreak = false;
				$return[] = [$min, $max];
				$min = min($arr);
				$max = max($arr);
			}
		}

		$return[] = [$min, $max];

		sort($return);		
	}

	// Vérifier si l'intervalle est couvert
	if($return != $array) {
		return foo($return);
	} else {
		return $return;
	}
}

// Tests
$test1 = [[0, 3], [6, 10]];
$test2 = [[0, 5], [3, 10]];
$test3 = [[0, 5], [2, 4]];
$test4 = [[7, 8], [3, 6], [2, 4]];
$test5 = [[3, 6], [3, 4], [15, 20], [16, 17], [1, 4], [6, 10], [3, 6]];
$test6 = [[3, 6], [3, 4], [15, 20], [16, 17], [-10, 4], [6, 10], [3, 6]]; // négative
$test7 = [[3, 6], [3, 4], [15, 20], [16, 17], [0, 10000], [1, 4], [6, 10], [3, 6]]; // 0 - 10000
$test8 = [[3, 6], [3, 4], [15, 20], [16, 17], [1, 4], [6, 10], [3, 6], [-1, 0], [50, 100]]; // plus intervalles
$test9 = [[8, 7], [6, 3], [2, 4]]; // inverse 

echo "Results : <br>";
echo json_encode($test1)." -> ".json_encode(foo($test1))."<br>";
echo json_encode($test2)." -> ".json_encode(foo($test2))."<br>";
echo json_encode($test3)." -> ".json_encode(foo($test3))."<br>";
echo json_encode($test4)." -> ".json_encode(foo($test4))."<br>";
echo json_encode($test5)." -> ".json_encode(foo($test5))."<br>";
echo json_encode($test6)." -> ".json_encode(foo($test6))."<br>";
echo json_encode($test7)." -> ".json_encode(foo($test7))."<br>";
echo json_encode($test8)." -> ".json_encode(foo($test8))."<br>";
echo json_encode($test9)." -> ".json_encode(foo($test9))."<br>";

// Outputs
// Results :
// [[0,3],[6,10]] -> [[0,3],[6,10]]
// [[0,5],[3,10]] -> [[0,10]]
// [[0,5],[2,4]] -> [[0,5]]
// [[7,8],[3,6],[2,4]] -> [[2,6],[7,8]]
// [[3,6],[3,4],[15,20],[16,17],[1,4],[6,10],[3,6]] -> [[1,10],[15,20]]
// [[3,6],[3,4],[15,20],[16,17],[-10,4],[6,10],[3,6]] -> [[-10,10],[15,20]]
// [[3,6],[3,4],[15,20],[16,17],[0,10000],[1,4],[6,10],[3,6]] -> [[0,10000]]
// [[3,6],[3,4],[15,20],[16,17],[1,4],[6,10],[3,6],[-1,0],[50,100]] -> [[-1,0],[1,10],[15,20],[50,100]]
// [[8,7],[6,3],[2,4]] -> [[2,6],[7,8]]

?>