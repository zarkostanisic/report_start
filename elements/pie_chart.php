<?php
  use App\Chart;
  use PhpOffice\PhpWord\Shared\Converter;

  $c4 = array('Ocitana brojila', 'Ukupno neocitanih brojila');
  $s4 = array(2, 211);

  $chart4 = new Chart('Pregled ocitanih brojila', Converter::inchToEmu(3), Converter::inchToEmu(2.5), true);
  $chart4->pie($c4, $s4);

  $fileName = 'report';
 ?>
