<?php

namespace app\Library;

class ExcelTable
{
  private $id;
  private $service = false;
  private $day = '';
  private $start = '';
  private $end = '';
  private $food_fg = '';
  private $outside_fg = '';
  private $medical_fg = '';
  private $note = '';

  function __construct($day, $record)
  {
    $this->day = $day;
    if (isset($record)) {
      $this->id = $record['id'];
      $this->service = true;
      $this->start = $record['start'];
      $this->end = $record['end'];
      $this->food_fg = $this->setFood_fg($record['food_fg']);
      $this->outside_fg = $this->setOutside_fg($record['outside_fg']);
      $this->medical_fg = $this->setMedical_fg($record['medical_fg']);
      $this->note = !$record['note'] == null ? $record['note']['note'] : '';
    }
  }

  /**
   * Get the value of id
   */
  public function getId()
  {
    return $this->id;
  }

  /**
   * Get the value of service
   */
  public function getService()
  {
    return $this->service;
  }

  /**
   * Get the value of day
   */
  public function getDay()
  {
    return $this->day;
  }

  /**
   * Get the value of start
   */
  public function getStart()
  {
    return $this->start;
  }

  /**
   * Get the value of end
   */
  public function getEnd()
  {
    return $this->end;
  }

  /**
   * Get the value of food_fg
   */
  public function getFood_fg()
  {
    return $this->food_fg;
  }

  /**
   * Get the value of outside_fg
   */
  public function getOutside_fg()
  {
    return $this->outside_fg;
  }

  /**
   * Get the value of medical_fg
   */
  public function getMedical_fg()
  {
    return $this->medical_fg;
  }

  /**
   * Get the value of note
   */
  public function getNote()
  {
    return $this->note;
  }

  /**
   * Set the value of food_fg
   *
   * @return  self
   */
  public function setFood_fg($food_fg)
  {
    if ($food_fg) {
      return '1';
    }
    return '';
  }

  /**
   * Set the value of outside_fg
   *
   * @return  self
   */
  public function setOutside_fg($outside_fg)
  {
    if ($outside_fg) {
      return '2';
    }
    return '';
  }

  /**
   * Set the value of medical_fg
   *
   * @return  self
   */
  public function setMedical_fg($medical_fg)
  {
    if ($medical_fg) {
      return '2';
    }
    return '';
  }
}
