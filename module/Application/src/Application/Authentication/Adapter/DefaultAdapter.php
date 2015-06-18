<?php

namespace Application\Authentication\Adapter;

use DoctrineModule\Persistence\ProvidesObjectManager;
use Zend\Authentication\Adapter\AdapterInterface;
use Application\Service\MeetupClient;
use Zend\Authentication\Result;
use ZF\OAuth2\Client\Service\OAuth2Service;
use Zend\Json\Json;
use Db\Entity;

class DefaultAdapter implements AdapterInterface
{
#    use ProvidesObjectManager;

    protected $oAuth2Service;
    protected $profile = 'default';

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

        $client->setUri('http://localhost:8080/api/me');
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
