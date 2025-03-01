<?
if($reccnt>$pagesize){
$num_pages=$reccnt/$pagesize;
$PHP_SELF=$_SERVER['PHP_SELF'];
$qry_str=$_SERVER['argv'][0];
$m=$_GET;
unset($m['start']);
$qry_str=qry_str($m);
//echo "$qry_str : $p<br>";
//$j=abs($num_pages/10)-1;
$j=$start/$pagesize-5;
//echo("<br>$j");
if($j<0) { $j=0; }
$k=$j+10;
if($k>$num_pages)	{ $k=$num_pages; }
$j=intval($j);
?>
<div class="pagination-wrap hstack gap-2">
<a class="page-item pagination-prev disabled" href="#">
                                                    Pages
                                                </a>
  <ul class="pagination listjs-pagination mb-0">
  <?
 			for($i=$j;$i<$k;$i++) {
				//if($i==$j)echo "Page:";
				if($i==$j) ;
				if(($pagesize*($i))!=$start)  {
	?>
    <li class="active"><a class="page" href="<?=$PHP_SELF?><?=$qry_str?>&start=<?=$pagesize*($i)?>" data-i="1" data-page="8"> <?=$i+1?></a></li>
	<?  } else{ ?>
     <li ><a class="page" href="#" data-i="1" data-page="8"><?=$i+1?></a></li>  
      <? }
 }?>
  </ul>
</div>
<? 
}
?>