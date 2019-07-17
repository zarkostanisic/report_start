<?php
  // Connection
  require_once('./app/connection.php');

  // Autoload
  require_once('./vendor/autoload.php');

  // Functions
  require_once('./includes/functions.php');

  use PhpOffice\PhpWord\PhpWord;

  $phpWord = new PhpWord();

  $sectionAutoFit = array('marginLeft'=>500, 'marginRight'=>500);

  $section = $phpWord->addSection($sectionAutoFit);

  // Table
  require_once('./elements/table.php');

  // Column chart
  require_once('./elements/column_chart.php');

  // Column chart with axes
  require_once('./elements/column_chart_with_axes.php');

  // Column clustered chart
  require_once('./elements/column_clustered_chart.php');

  // Pie chart
  require_once('./elements/pie_chart.php');

  $fileName = 'report-example';

  require_once('./includes/save.php');
 ?>
