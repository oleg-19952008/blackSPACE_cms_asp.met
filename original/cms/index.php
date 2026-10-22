<?php
$name_="Ridi";
function title ($str) { 
 static $title;
 if (!empty($str)) $title=(SITE_TITLE===''?'':SITE_TITLE.' - ').$str;
 return $title;
}

$pages = array();
require  ("./config.php");

//обработать внешний параметр - имя искомого файла
$p='';
if (isset($_GET['p'])) $p=trim(strip_tags($_GET['p']));
$pk=array_keys($pages);
$pv=array_values($pages);

//найти запрошенный с сайта файл в списке
$file=$pk[0];
$title=$pv[0];
$found=true;
$ind=array_search($p,$pk);
if ($ind) { $file=$pk[$ind]; $title=$pv[$ind]; }
else if (!(empty($p) or $p==$file)) $found=false;

//вывести титул страницы и шапку
title ($title);
include "./header.php";

//сформировать меню
echo '<div align="center">';
foreach ($pages as $key => $val) {
 echo '<nobr class="button">['.($val==$title?'':'<a class="button" href="index.php?p='.$key.'">').
 $val.($val==$title?'':'</a>').']</nobr> ';
}
echo '</div>';

//сформировать имя файла
$filename = "./p/$file.html";
if ($found and file_exists($filename)) {
 //получить содержимое тега <body>, если его нет - весь файл
 $file=@file_get_contents ($filename);
 if (!$file) {
  echo ('<p>Фатальная ошибка: на сайте недоступен файл '.$filename.' с данными!</p>'.
   '<p><a href="index.php">Вернуться на страницу скрипта</a></p>');
 }
 if (preg_match("#<body[^>]*>(.*?)<\/body>#msi", $file, $matches)) {
  echo "\n".$matches[1];
 }
 else {
  include "$filename";
 }
}
else {
 echo '<p>К сожалению, запрошенный Вами раздел "'.
  (strlen($p)>50?trim(substr($p,0,50)).'...':$p).
  '" не найден на сайте.<p>
  Воспользуйтесь ссылками на <a href="index.php">главной странице</a> сайтa.</p>';
}
//вывести подвал
include "./footer.php";
?>