<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Batting extends Model {

  protected $table = 'batting';

  public function getAverageAttribute() {
    if (isset($this->attributes['H'])) {
      $hits = $this->attributes['H'];
    } else {
      $hits = 0;
    }
    
    if (isset($this->attributes['AB'])) {
      $atBats = $this->attributes['AB'];
    } else {
      $atBats = 0;
    }
    
    if ($atBats) {
      $average = $hits / $atBats;
      return substr(number_format($average, 3), 1); 
    }
    else {
      return '.000';
    }
  }

}
