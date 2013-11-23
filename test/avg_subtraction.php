<?php
	$li = range(1, 999, 0.01);
	shuffle($li);
	$rkeys = array_rand($li, 5);
	foreach ($rkeys as $k) {
		$arr[] = $li[$k];
	}
	$sum = array_sum($arr);
	foreach ($arr as $k => $v) {
		echo sprintf("%d : %.2f", $k+1, $v) . PHP_EOL;
	}
	$min = min($arr);
	$max = max($arr);
	$li2 = range($min, $max, 0.01);
	shuffle($li2);
	$sub = floatval($li2[array_rand($li2, 1)]);
	echo 'sum: ' . sprintf("%.2f", $sum) . PHP_EOL;
	echo 'min: ' . sprintf("%.2f", $min) . PHP_EOL;
	echo 'max: ' . sprintf("%.2f", $max) . PHP_EOL;
	$ratio = floatval(floatval($sub)/floatval($sum));
	$sub_done = $sub_this = 0.00;
	$sub_arr = array();
	foreach ($arr as $k=>$v) {
		$sub_arr[$k] = $ratio * $v;
		$sub_done += $sub_arr[$k];
	}
	foreach ($sub_arr as $k => $v) {
		echo sprintf("sub_list: %d => %.2f", $k+1, $v) . PHP_EOL;
	}
	echo 'ratio: ' . sprintf("%.2f", $ratio) . PHP_EOL;
	echo 'sub: ' . sprintf("%.2f", $sub) . PHP_EOL;
	echo 'sub_done: ' . sprintf("%.2f", $sub_done) . PHP_EOL;
	echo 'sub_diff: ' . sprintf("%.2f", floatval($sub - $sub_done)) . PHP_EOL;