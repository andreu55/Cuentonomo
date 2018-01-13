<?php

function sqlToHuman($date) {

  $dtemp = strtotime($date);
  return date('d/m/Y', $dtemp);
}

function humanToSql($date) {

  $dtemp = DateTime::createFromFormat('d/m/Y', $date);
  return $dtemp->format('Y-m-d');
}

function trimestre($datetime)
{
  $mes = date("m",strtotime($datetime));
  $mes = is_null($mes) ? date('m') : $mes;
  $trim = floor(($mes-1) / 3)+1;
  return $trim;
}
