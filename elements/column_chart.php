<?php
  use App\Chart;
  use PhpOffice\PhpWord\Shared\Converter;

  $c1 = ['Smederevo', 'Smederevska Palanka', 'Velika Plana'];
  $s1 = [55, 49, 30];

  $chart1 = new Chart('Broj citaca po ispostavama', Converter::inchToEmu(6.5), Converter::inchToEmu(4), false, true, true);
  $chart1->column($c1, $s1, 'Broj citaca');
 ?>
