<?php

function threeColumns($records, $breakPoint = 15) {
  $count = $records->count();
    if ($count < $breakPoint) {
      $recordsCol1 = $records;
      $recordsCol2 = [];
      $recordsCol3 = [];
    } elseif ($count < ($breakPoint * 2)) {
      $x = 0;
      foreach ($records as $record) {
        if ($x < ($count / 2)) {
          $recordsCol1[] = $record;
        } else {
          $recordsCol2[] = $record;
        }
        $x++;
      }
      $recordsCol3 = [];
    } else {
      $x = 0;
      foreach ($records as $record) {
        if ($x < ($count / 3)) {
          $recordsCol1[] = $record;
        } elseif ($x < (($count * 2) / 3)) {
          $recordsCol2[] = $record;
        } else {
          $recordsCol3[] = $record;
        }
        $x++;
      }
    }
    return array(
      'recordsCol1' => $recordsCol1,
      'recordsCol2' => $recordsCol2,
      'recordsCol3' => $recordsCol3,
    );
}

