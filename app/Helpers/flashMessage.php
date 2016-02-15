<?php

function flashMessage($message, $alertType) {
  session()->flash('flash_message', $message);
  session()->flash('alert_type', $alertType);
}
