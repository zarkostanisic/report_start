<?php
  // Connection
  require_once('./app/connection.php');

  // Autoload
  require_once('./vendor/autoload.php');

  // Functions
  require_once('./includes/functions.php');

  use PhpOffice\PhpWord\PhpWord;

  $phpWord = new PhpWord();
  $phpWord->getSettings()->setUpdateFields(true);

  $section = $phpWord->addSection();

  $section->addTOC();
  $section->addPageBreak();

  // Styles
  require_once('./includes/styles.php');

  $sql_query_upd = $db->query("select id from obracunski_period where aktivan = '1' and status = 'otkljucan'");
  $rezultat_query_upd = mysqli_fetch_assoc($sql_query_upd);
  $obracunski_period = $rezultat_query_upd['id'];

  // Test 1
  require_once('./tests/test_1.php');

  echo 'save report' . '<br/>';
  $fileName = 'report';

  require_once('./includes/save.php');
 ?>
