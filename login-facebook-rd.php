<?php


# Header Page
include __DIR__.'/header.php';

# Main Page
if(!us_level):
	if( isset($_SESSION['facebook_access_token']) ):
		$fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
		$profile_request = $fb->get('/me?fields=name,first_name,last_name,email,picture.width(100).height(100)');
		$profile         = $profile_request->getGraphNode()->asArray();

		fh_social_login( 'facebook', $profile );

	endif;
else:
	echo fh_alerts($lang['alerts']['permission']);
endif;

$sidebar = false;

# Footer Page
include __DIR__.'/footer.php';
