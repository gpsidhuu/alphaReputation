<?phpclass xsUser extends WP_User {	public function __construct( $id = NULL ) {		if( is_user_logged_in() and $id = NULL ) {		}		parent::__construct( get_current_user_id() );	}	function is_Client() {		if( in_array( 'client', $this->roles ) ) return TRUE;		return FALSE;	}	function is_Pro() {		if( in_array( 'professional', $this->roles ) ) return TRUE;		return FALSE;	}}