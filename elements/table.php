<?php
  use App\Table;
  
  $rows = [];
  $rows[] = ['Header Column 1', ['value' => 'Header Column 2', 'bold' => true]];
  $rows[] = [['value' => 'Cell 2', 'bold' => true], 'Cell 1'];

  $table = new Table($rows);
 ?>
