<?php

return array(
    'zf-oauth2-client' => array(
        'profiles' => array(
            'default' => array(
                'login_redirect_route' => 'authenticate',
                'client_id' => 'client15',
                'secret' => 'password',
                'endpoint' => 'http://localhost:8081/oauth', # The zf-oauth2 server
                'scope' => '',
            ),
        ),
    ),
);
