<?php

$out = '/*
 * Copyright (c) 2024 Petko Yotov pmwiki.org/petko
 *
 * SPDX-License-Identifier: MIT
 * 
 * These abbreviations make combos more readable.
 * Not all are used, or even can be reasonably used.
 * 
 * The combo is described by the character and position, 
 * in columns from left to right, for example _TMB:
    * T = key on the Top row pressed
    * M = key on the Middle row pressed
    * X = both keys (Top and Middle) rows pressed
    * _ = neither top or bottom keys in the column pressed
    * L prefix for a left-hand combo
    * R prefix for a right-hand combo
 * 
 * Note that every column of the 3x2 keypad (left or right side)
 * can be represented as 4 bits.
 * In fact the combo abbreviations below are basically 
 * the numbers between 2 and 63 (4^3-1) converted to base-4, 
 * removing those with a single key pressed.
 * Combos only span 1 side.
 */
';





for($i=2; $i<64; $i++) {
  
  $b = base_convert($i, 10, 4);
  $b = str_repeat('0', 3-strlen($b)) . $b;
  $n = strtr( $b, '0123', '_TMX');
  
  if(preg_match('/^_*[TM]_*$/', $n)) continue;
//   echo "$i:$b:$n\n";
  
  $left  = "#define L$n"; 
  $right = "#define R$n";
  
  for($j=0; $j<=2; $j++) {
    $pressed = $n[$j];
    if($pressed == '_') continue;
    $l = $j+1;
    $r = $j+4;
    $left  .= " $pressed$l";
    $right .= " $pressed$r";
    
    
  }
  
  $out .= "$left\n$right\n";
  
  continue;
  
//   $name = sprintf("%'_4s ", $n);
//   if(preg_match('/^_*[TB]_* $/', $name)) continue;
//   
//   $val = '';
//   for($j=0; $j<4; $j++) {
//     $c = $name[$j];
//     $val .= $keys[$c][$j];
//   }
//   $out[] = "#define $name  $val";
  
}

$out = preg_replace('/ X(\\d)/', ' T$1 M$1', $out);

print_r($out);

