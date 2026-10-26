<?php $title='Gallery';require 'includes/header.php';
$g=[['children-courtyard.jpg','Children in matching ankara outfits at RACO'],['children-praying.jpg','Children praying in school uniform'],['group-photo.jpg','Children and visitors at the orphanage'],
['gallery-medical-outreach.jpg','Free medical outreach'],['gallery-widows-ceremony.jpg','Rural widows empowerment ceremony'],['gallery-christmas-fair.jpg','Christmas Grace Fun Fair'],['gallery-graduation.jpg','Schools graduation and thanksgiving'],['gallery-skills-training.jpg','Youth skills training'],['gallery-light-city.jpg','Light City, Ogun State']];?>
<div class="page"><div class="wrap"><span class="bar"></span><h1>Gallery</h1><p class="lead">Moments from our homes, schools and outreaches.</p></div></div>
<section><div class="wrap gal"><?php foreach($g as $x)echo '<div class="rv">'.photo($x[0],$x[1]).'</div>';?></div></section>
<?php require 'includes/footer.php';?>
