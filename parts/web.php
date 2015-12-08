<?php //write the keywords here for search
$url  = 'http://' . $urls[ $_REQUEST['si'] ] . '/search?num=30&q=' . $keywordsGot;
$html = file_get_html( $url );
// Find all images
// Find all links
$i = 0;
foreach ( $html->find( '.g' ) as $element ):$i ++ ?>
	<div class="row ckmark" style="margin-bottom: 40px;">
		<div class="col-xs-1">
			<div class="no"><?php echo $i; ?></div>
			<div class="cb"></div>
			<input style="display: none;" type="checkbox" name="pos[]" value="<?php echo $i; ?>@@#@@<?php echo 'http://' . $urls[ $_REQUEST['si'] ] . '/';
			echo $element->find( 'h3 a', 0 )->href; ?>@@#@@<?php echo $element->find( '.r', 0 )->plaintext; ?>" id="">
		</div><!-- -->
		<div class="col-xs-11">
			<div class="sres">
				<h3><?php echo utf8_encode( $element->find( '.r', 0 )->plaintext ); ?></h3>

				<div class="link" style="padding-bottom: 5px;">
					<a href="<?php echo $element->find( 'cite', 0 )->plaintext; ?>"><?php echo utf8_encode( $element->find( 'cite', 0 )->plaintext ); ?></a>
				</div>
				<div class="desc"><?php echo utf8_encode( $element->find( '.st', 0 )->plaintext ); ?></div>
			</div>
		</div>
	</div>
<?php endforeach;
?>