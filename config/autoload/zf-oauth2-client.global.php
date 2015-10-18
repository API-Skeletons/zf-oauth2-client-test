<?php

return array(
    'zf-oauth2-client' => array(
        'profiles' => array(
            'default' => array(
                'login_redirect_route' => 'authenticate',
                'client_id' => 'clienttest',
                'secret' => 'password',
                'endpoint' => 'https://local.sso.social.oauth2.user/oauth', # The zf-oauth2 server
                'scope' => '',
            ),
        ),
    ),
);
