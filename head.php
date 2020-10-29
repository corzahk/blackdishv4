<?php


include __DIR__."/configs.php";
?>

<!DOCTYPE html>
<html lang="<?=$lang['lang']?>">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title><?=fh_title()?></title>

	<meta name="title" content="<?=fh_title()?>">
	<meta name="description" content="<?=site_description?>">
	<meta name="keywords" content="<?=site_keywords?>">

	<!-- Open Graph / Facebook -->
	<meta property="og:type" content="website">
	<meta property="og:url" content="<?=site_url?>">
	<meta property="og:title" content="<?=fh_title()?>">
	<meta property="og:description" content="<?=site_description?>">
	<meta property="og:image" content="<?=site_url?>">

	<!-- Twitter -->
	<meta property="twitter:card" content="summary_large_image">
	<meta property="twitter:url" content="<?=site_url?>">
	<meta property="twitter:title" content="<?=fh_title()?>">
	<meta property="twitter:description" content="<?=site_description?>">
	<meta property="twitter:image" content="<?=site_url?>">

	<!-- Favicon -->
	<link rel="shortcut icon" href="<?=path?>/<?=site_favicon?>" type="image/png" />

	<!-- Google Fonts -->
	<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Raleway:100,200,300,400,500,600,700,900%7CGentium+Basic:400italic%7COpen+Sans:400italic,700italic,400,300,700">

	<!-- Plugins -->
	<link rel="stylesheet" href="<?=path?>/css/all.min.css">
	<link rel="stylesheet" href="<?=path?>/css/tt.css">
	<link rel="stylesheet" href="<?=path?>/css/simple-line-icons.css">
	<link rel="stylesheet" href="<?=path?>/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?=path?>/js/minified/themes/default.min.css" />
	<link rel="stylesheet" href="<?=path?>/css/jquery-confirm.min.css">
	<link rel="stylesheet" href="<?=path?>/css/lightbox.css" />
	<link rel="stylesheet" href="<?=path?>/css//bootstrap-select.min.css">
	<link rel="stylesheet" href="<?=path?>/css/flag-icon.min.css">
	<link rel="stylesheet" href="<?=path?>/js/file_upload/fileinput.css" />
	<link rel="stylesheet" href="<?=path?>/css/owl.carousel.min.css" />
	<link rel="stylesheet" href="<?=path?>/css/scrolls.css" />

	<link rel="stylesheet" href="<?=path?>/css/<?=(page != "dashboard" ? 'style' : 'cpanel')?>.css">

</head>
<body<?=(page?' class="pt-'.page.'page"':'')?>>
