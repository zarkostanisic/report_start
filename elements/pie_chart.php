<?php
  use App\Chart;
  use PhpOffice\PhpWord\Shared\Converter;

  $section = $phpWord->addSection(array('colsNum' => 2, 'breakType' => 'continuous'));

  $c4 = array('Ocitana brojila', 'Ukupno neocitanih brojila');
  $s4 = array(2, 211);

  $chart4 = new Chart('Pregled ocitanih brojila', Converter::inchToEmu(3), Converter::inchToEmu(2.5), true);
  $chart4->pie($c4, $s4);

  $section->addTextBreak();

  $c5 = array('Ocitana', 'Neocitana');
  $s5 = array(70, 500);

  $chart5 = new Chart('Pregled ocitanih brojila', Converter::inchToEmu(3), Converter::inchToEmu(2.5), true);
  $chart5->pie($c5, $s5);

  $section->addTextBreak();

  $section = $phpWord->addSection(array('breakType' => 'continuous'));
 ?>
