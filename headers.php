<?php $aHeaders = array(
	'sku',
	'_store',
	'_attribute_set',
	'_type',
	'_category',
	'_root_category',
	'_product_websites',
	'name',
	'description',
	'short_description',
	'price',
	'special_price',
	'special_from_date',
	'special_to_date',
	'cost',
	'weight',
	'manufacturer',
	'meta_title',
	'meta_keyword',	
	'meta_description',
	'image',
	'small_image',
	'thumbnail',
	'media_gallery',
	'color',
	'news_from_date',
	'news_to_date',
	'gallery',
	'status',
	'url_key',
	'url_path',
	'minimal_price',
	'visibility',
	'custom_design',
	'custom_design_from',
	'custom_design_to',
	'custom_layout_update',
	'page_layout',
	'options_container',
	'required_options',
	'has_options',
	'image_label',
	'small_image_label',
	'thumbnail_label',
	'created_at',
	'updated_at',
	'country_of_manufacture',
	'msrp_enabled',
	'msrp_display_actual_price_type',
	'msrp',
	'tax_class_id',
	'gift_message_available',
	'watch_brand',
	'bransom_code',
	'jewellery_type',
	'designer',
	'gender',
	'metal',
	'gemstone',
	'qty',
	'min_qty',
	'use_config_min_qty',
	'is_qty_decimal',
	'backorders',
	'use_config_backorders',
	'min_sale_qty',
	'use_config_min_sale_qty',
	'max_sale_qty',
	'use_config_max_sale_qty',
	'is_in_stock',
	'notify_stock_qty',
	'use_config_notify_stock_qty',
	'manage_stock',
	'use_config_manage_stock',
	'stock_status_changed_auto',
	'use_config_qty_increments',
	'qty_increments',
	'use_config_enable_qty_inc',
	'enable_qty_increments',
	'is_decimal_divided',
	'_links_related_sku',
	'_links_related_position',
	'_links_crosssell_sku',
	'_links_crosssell_position',
	'_links_upsell_sku',
	'_links_upsell_position',
	'_associated_sku',
	'_associated_default_qty',
	'_associated_position',
	'_tier_price_website',
	'_tier_price_customer_group',
	'_tier_price_qty',
	'_tier_price_price',
	'_group_price_website',
	'_group_price_customer_group',
	'_group_price_price',
	'_media_attribute_id',
	'_media_image',
	'_media_lable',
	'_media_position',
	'_media_is_disabled'
);
/* If this file is called by ajax */
if(isset($_GET['json'])){
	include_once("definedFields.php");
	/* Prepare Column Headers for table display */
	$aRet['columns'][] = array('field'=>'name', 'title'=>'Name');
	$aRet['columns'][] = array('field'=>'value', 'title'=>'Value');
	/* loop through all headers*/
	foreach($aHeaders as $iKey){
		/* Form the value array */
		if (!array_key_exists($iKey, $aFieldsDefined)){
			$aRet['data'][] = array('name'=>$iKey, 'value'=>'NULL');
			/*$aRet['data'][] = array('name'=>$iKey, 'value'=>"<a data-title='Field Title' data-type='text'  class='field_editable' data-pk='1' href='#' id='{$iKey}'>NULL</a>");*/
		}
	}
	/* send it back. */
	echo json_encode($aRet);
	
}
?>