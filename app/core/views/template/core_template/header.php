<?php
$rb=rimbun_info();
?>
<meta name="web_author" content="<?=$rb['developer_name'];?>, <?=$rb['developer_email'];?>" />
<?php
echo rb_add_css(rb_path_assets('url')."cdn/dashboard/core.css");
echo rb_add_js(rb_path_assets('url')."cdn/dashboard/core.js");
?>
<link rel="shortcut icon" href="<?php echo rb_system_favicon('64');?>" />
<script>
	var base_url="<?=base_url();?>";
	var asset_url="<?=rb_path_assets();?>";
</script>