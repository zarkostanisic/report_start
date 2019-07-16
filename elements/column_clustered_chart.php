<?php
  use App\Chart;
  use PhpOffice\PhpWord\Shared\Converter;
  

  $names = array('Broj ocitanih brojila', 'Broj neocitanih - nepristupacnih brojila', 'Broj neocitanih brojila');

  $clusteredValues = array(
   array('Smederevo', 44017, 41387, 2106, 524),
   array('Smederevska Palanka', 26373, 23631, 744, 1998),
   array('Velika Plana', 20173, 18248, 1018, 907)
  );
  $c3 = [];
  $s3 = [];
  foreach( $clusteredValues as $v){
     $c3[] = $v[0];

     $s3[0][] = $v[1];
     $s3[1][] = $v[2];
     $s3[2][] = $v[3];
   }

  $chart3 = new Chart('Ocitanost brojila po ispostavama', Converter::inchToEmu(6.5), Converter::inchToEmu(4), false, true, true, true);
  $chart3->columnClustered($c3, $s3, $names);
 ?>
