<?php
include '../../../../../../wp-load.php';
require( dirname( __FILE__ ) . '/php/Uploader.php' );
//
$upload_dir = dirname( dirname( dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) ) ) . '/uploads/ssuploader/';
if( ! is_dir( $upload_dir ) )
	mkdir( $upload_dir );
$uploader = new FileUpload( 'uploadfile' );
$uploader->newFileName = sanitize_file_name( $uploader->getFileName() ) . '_' . rand( 0, 10 ) . '.' . $uploader->getExtension();
$result = $uploader->handleUpload( $upload_dir );
//
switch( $_GET['uploadType'] ) {
	case 'cv':
		if( ! $result ) {
			exit( json_encode( array(
				'success' => FALSE,
				'msg'     => $uploader->getErrorMsg()
			) ) );
		} else {
			///
			$cv_url = SURL . '/wp-content/' . explode( 'wp-content', $uploader->getSavedFile() )[1];
			$attach_id = xsUTL::add_image( $cv_url );
			if( $attach_id > 0 ) {
				echo json_encode( array(
					'status' => TRUE,
					'id'     => $attach_id,
				) );
			} else {
				echo json_encode( array(
					'status' => TRUE,
					'msg'    => 'File Upload Failed.Please try again',
				) );
			}
		}
		die;
		break;
}
// Directory where we're storing uploaded images
// Remember to set correct permissions or it won't work
// Handle the upload
do_action( 'display_init' );
$image_url = SURL . '/wp-content/' . explode( 'wp-content', $uploader->getSavedFile() )[1];
$attach_id = xsUTL::add_image( $image_url );
if( $attach_id > 0 ) {
	echo json_encode( array(
		'success' => TRUE,
		'id'      => $attach_id,
		'url'     => explode( 'wp-content', $uploader->getSavedFile() )[1],
	) );
} else {
	exit( json_encode( array(
		'success' => FALSE,
		'msg'     => 'Can\'t add image to library'
	) ) );
}

