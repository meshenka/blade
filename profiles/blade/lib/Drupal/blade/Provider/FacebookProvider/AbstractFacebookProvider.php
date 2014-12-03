<?php

namespace Drupal\blade\Provider\FacebookProvider;

use Drupal\blade\Provider\ProviderInterface;
use Facebook\FacebookSession;
use Facebook\FacebookRequestException;

abstract class AbstractFacebookProvider implements ProviderInterface
{
    /**
     * @var Facebook\FacebookSession
     */
    private $session;

    public function getSession()
    {
        return $this->session;
    }

    public function __construct(FacebookSession $session)
    {
        $this->session = $session;
    }

    public function fetch()
    {
        $this->validateSession();

        return $this->doFetch();
    }

    private function validateSession()
    {
        // To validate the session:
        try {
            $this->session->validate();
        } catch (FacebookRequestException $ex) {
            throw $ex;
        } catch (Exception $ex) {
            // Graph API returned info, but it may mismatch the current app or have expired.
            throw $ex;
        }
    }

    abstract protected function doFetch();
}
