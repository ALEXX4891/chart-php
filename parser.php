<?php
$doc = new DOMDocument();
$doc->loadHTMLFile($_GET['file']);

$rows = $doc->getElementsByTagName('tr'); //получяем все строки
$parcArreyDate = [];
$parcArreyBalance = [];
$parcArreyDinamic = [];
$trueFile = false;

//проверка шапки файла:
foreach ($rows as $row) {
  $cells = $row->getElementsByTagName('td'); 
  if (
    str_replace(' ', '', $cells->item(0)->textContent) == 'Ticket' &&
    str_replace(' ', '', $cells->item(1)->textContent) == 'OpenTime' &&
    str_replace(' ', '', $cells->item(2)->textContent) == 'Type' &&
    str_replace(' ', '', $cells->item(3)->textContent) == 'Size' &&
    str_replace(' ', '', $cells->item(4)->textContent) == 'Item' &&
    str_replace(' ', '', $cells->item(5)->textContent) == 'Price' &&
    str_replace(' ', '', $cells->item(6)->textContent) == 'S/L' &&
    str_replace(' ', '', $cells->item(7)->textContent) == 'T/P' &&
    str_replace(' ', '', $cells->item(8)->textContent) == 'CloseTime' &&
    str_replace(' ', '', $cells->item(9)->textContent) == 'Price' &&
    str_replace(' ', '', $cells->item(10)->textContent) == 'Commission' &&
    str_replace(' ', '', $cells->item(11)->textContent) == 'Taxes' &&
    str_replace(' ', '', $cells->item(12)->textContent) == 'Swap' &&
    str_replace(' ', '', $cells->item(13)->textContent) == 'Profit'
  ) {
    $trueFile = true;
  }
}

foreach ($rows as $row) {
  $cells = $row->getElementsByTagName('td'); //получяем все ячейки в строке
  // Формируем массивы данных в зависимости от типа строки:
  if ($cells->item(2)->textContent == 'buy') {
    $parcArreyDate[] = $cells->item(1)->textContent;  // массив дат для оси X
    $parcArreyBalance[] = floatval(str_replace(' ', '', $cells->item(10)->textContent)) + floatval(str_replace(' ', '', $cells->item(13)->textContent));
  } elseif ($cells->item(2)->textContent == 'balance') {
    $parcArreyDate[] = $cells->item(1)->textContent; // массив дат для оси X
    $parcArreyBalance[] = floatval(str_replace(' ', '', $cells->item(4)->textContent));
  }
}

//подготовим данные для оси Y:
for ($i = 0; $i < count($parcArreyBalance); $i++) {
  $parcArreyDinamic[$i] = $parcArreyBalance[$i] + $parcArreyDinamic[$i - 1];
}