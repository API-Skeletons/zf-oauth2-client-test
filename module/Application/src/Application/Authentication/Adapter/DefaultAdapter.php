<?php

namespace Application\Authentication\Adapter;

use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Result;
use ZF\OAuth2\Client\Service\OAuth2Service;
use Zend\Json\Json;

class DefaultAdapter implements
    AdapterInterface
{
    protected $oAuth2Service;
    protected $userInfoUrl;
    protected $profile = 'default';

    public function getUserInfoUrl()
    {
        return $this->userInfoUrl;
    }

    public function setUserInfoUrl($url)
    {
        $this->userInfoUrl = $url;

        return $this;
    }

    public function getOAuth2Service()
    {
        return $this->oAuth2Service;
    }

    public function setOAuth2Service(OAuth2Service $service)
    {
        $this->oAuth2Service = $service;

        return $this;
    }

    public function authenticate()
    {
        if (!$this->getOAuth2Service()) {
            return new Result(Result::FAILURE, null, []);
        }

        $client = $this->getOAuth2Service()->getHttpBearerClient($this->profile);

        $client->setUri('https://local.sso.social.oauth2.user/api/me');
        $client->setMethod('GET');
        $headers = $client->getRequest()->getHeaders();
        $headers->addHeaderLine('Accept: application/json');
        $headers->addHeaderLine('Content-Type: application/json');

        // Get the authenticated user
        $response = $client->send();
        $user = Json::decode($response->getBody(), true);

        return new Result(Result::SUCCESS, $user, []);
    }
}
