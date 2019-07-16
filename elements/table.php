<?php
  use App\Table;

  $rows = [];
  $rows[] = ['Header Column 1', ['value' => 'Header Column 2', 'bold' => true]];
  $rows[] = [['value' => 'Row 1 Cell 1', 'bold' => true], 'Row 1 Cell 2'];
  $rows[] = [['value' => 'Row 2 Cell 1', 'bold' => true], 'Row 2 Cell 2'];

  $table = new Table($rows);
 ?>
