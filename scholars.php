<?php $title='Our scholars';require 'includes/header.php';
// Reads the published Google Sheet (CSV) behind the Google Form. Cached for 10 minutes.
function sheet_rows($url){
  if(!$url)return null;
  $c=sys_get_temp_dir().'/raco_sheet.csv';
  if(!is_file($c)||time()-filemtime($c)>600){
    $d=@file_get_contents($url,false,stream_context_create(['http'=>['timeout'=>6]]));
    if($d!==false&&strlen($d)>10)file_put_contents($c,$d);
  }
  if(!is_file($c))return [];
  $f=fopen($c,'r');$rows=[];while(($r=fgetcsv($f,0,',','"',''))!==false)$rows[]=$r;fclose($f);return $rows;
}
function drive_img($v){
  $v=trim(explode(',',$v)[0]);
  if(preg_match('~(?:id=|/d/)([\w-]{20,})~',$v,$m))return 'https://drive.google.com/thumbnail?id='.$m[1].'&sz=w800';
  return preg_match('~^https?://~',$v)?$v:'';
}
$rows=sheet_rows($S['sheet']??'');$cards=[];
if($rows&&count($rows)>1){
  $hd=array_map(fn($x)=>strtolower(trim($x)),array_shift($rows));
  $col=function($keys,$not=[])use($hd){foreach($hd as $i=>$h){foreach($not as $n)if(strpos($h,$n)!==false)continue 2;foreach($keys as $k)if(strpos($h,$k)!==false)return $i;}return -1;};
  $iN=$col(['name'],['school','institution','course']);$iS=$col(['institution','school','university']);$iC=$col(['course','programme','department']);$iL=$col(['level','year','class']);$iB=$col(['story','background','about']);$iP=$col(['picture','photo','image','upload']);$iA=$col(['approved','approve']);
  foreach($rows as $r){
    if($iA<0||strtolower(trim($r[$iA]??''))!=='yes'||$iN<0)continue;   // only rows marked Approved = Yes are shown
    $cards[]=['n'=>trim($r[$iN]??''),'s'=>$iS>=0?trim($r[$iS]??''):'','c'=>$iC>=0?trim($r[$iC]??''):'','l'=>$iL>=0?trim($r[$iL]??''):'','b'=>$iB>=0?trim($r[$iB]??''):'','p'=>$iP>=0?drive_img($r[$iP]??''):''];
  }
}?>
<div class="page"><div class="wrap"><span class="bar"></span><h1>Our scholars</h1><p class="lead">The young people RACO is helping to learn, and the stories behind them. Each profile is shared with the consent of the student or their guardian.</p></div></div>
<section><div class="wrap">
<?php if($cards): ?><div class="tm sch"><?php foreach($cards as $c): ?>
<div class="mem rv"><?=$c['p']?'<img class="pt" src="'.h($c['p']).'" alt="'.h($c['n']).'" loading="lazy" referrerpolicy="no-referrer">':'<div class="ph pt"><span>No photo yet</span></div>'?>
<b><?=h($c['n'])?></b><?php if($c['c']||$c['l'])echo '<span>'.h(trim($c['c'].($c['c']&&$c['l']?', ':'').$c['l'])).'</span>';if($c['s'])echo '<span style="display:block">'.h($c['s']).'</span>';?>
<?php if($c['b']): ?><details><summary>Read their story</summary><p><?=nl2br(h($c['b']))?></p></details><?php endif; ?></div>
<?php endforeach; ?></div>
<?php else: ?><p class="lead">Student profiles are coming soon. Check back shortly.</p><?php endif; ?>
</div></section>
<section class="cta"><div class="wrap rv"><h2>Help a child reach the next class</h2><p>Sponsor a student's education, books and school fees.</p><a class="btn btn-r" href="support.php">Sponsor a student</a></div></section>
<?php require 'includes/footer.php';?>
