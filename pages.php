<?php


include __DIR__."/header.php";

$rs = db_rs("pages WHERE id = '{$id}'");

?>

<div class="pt-breadcrumb-p">
	<div class="container">
		<div class="pt-dtable"><div class="pt-vmiddle"><h3><?=$rs['title']?></h3></div></div>
	</div>
</div>

<div class="container">
	<div class="pt-box"><?=fh_bbcode($rs['content'])?></div>
</div>


<?php
include __DIR__."/footer.php";
