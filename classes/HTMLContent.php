<?php

class HTMLContent
{
  public $condition;
  public $HTMLContent;

  function __construct($condition, $HTMLContent)
  {
    $this->condition = $condition;
    $this->HTMLContent = $HTMLContent;
  }

  function display()
  {
    if ($this->condition) {
      echo $this->HTMLContent;
    }
  }
}
