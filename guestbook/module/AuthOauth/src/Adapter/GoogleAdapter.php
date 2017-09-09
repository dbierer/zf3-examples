<?php
namespace AuthOauth\Adapter;

use Exception;
use AuthOauth\Generic\Constants;
use Zend\Authentication\Exception\InvalidArgumentException;
use Zend\Authentication\Exception\RuntimeException;
use Zend\Authentication\Result;
use League\OAuth2\Client\Provider\Google as GoogleProvider;

class GoogleAdapter extends BaseAdapter
{
    
    const PROVIDER_NAME = 'google';    
    protected $provider;
    
    public function __construct($params)
    {
        $this->provider = new GoogleProvider($params);
        $this->callback = $this->callback . '/' . self::PROVIDER_NAME;
    }
    
    /**
     * Authenticate using logic provided by the PHP League Google Client docs
     *
     * @param Zend\Authentication\AuthenticationService $service | NULL
     * @return Result The authentication result
     * @throws RuntimeException
    */
    public function authenticate()
    {
        $result = FALSE;
        try {
            $identity = $this->process();
            if (!$identity) {
                $result = new Result(Result::FAILURE, $identity, [self::ERROR_AUTH]);
            } else {
                $result = new Result(Result::SUCCESS, $identity, [self::SUCCESS_AUTH]);
                // store identity
                $this->getAuthService()->getStorage()->write($result->getIdentity());
            }
        } catch (Exception $e) {
            error_log(__METHOD__ . ':' . __LINE__ . ':' . $e->getMessage());
            $result = new Result(Result::FAILURE_UNCATEGORIZED, NULL, [$e->getMessage()]);
        }
        return $result;
    }

    public function process()
    {
        $identity = array();
        if (!empty($_GET['error'])) {
            // Got an error, probably user denied access
            throw new Exception($this->formatErrorMessage(__LINE__, self::ERROR_UNKNOWN . htmlspecialchars($_GET['error'], ENT_QUOTES, 'UTF-8')));
        }
        if (empty($_GET['code'])) {
            // If we don't have an authorization code then get one
            $authUrl = $this->provider->getAuthorizationUrl();
            $this->session->oauth2state = $this->provider->getState();
            $this->session->oauth2state_old = $this->session->oauth2state;
            header('Location: ' . $authUrl);
            exit;
        } 
        if (empty($_GET['state']) || ($_GET['state'] !== $this->session->oauth2state)) {
            // State is invalid, possible CSRF attack in progress
            unset($this->session->oauth2state);
            throw new Exception($this->formatErrorMessage(__LINE__, self::ERROR_INVALID_STATE));
        }

        $response = array();
        // Try to get an access token (using the authorization code grant)
        $token = $this->provider->getAccessToken('authorization_code', ['code' => $_GET['code']]);

        // Optional: Now you have a token you can look up a users profile data
        try {

            // We got an access token, let's now get the owner details
            $response = $this->provider->getResourceOwner($token);

            if (!$response) {
                throw new Exception(self::ERROR_NO_RESPONSE);
            }
            
        } catch (Exception $e) {

            // Failed to get user details
            throw new Exception($this->formatErrorMessage(__LINE__, self::ERROR_SOMETHING_WRONG . $e->getMessage()));

        }

        $identity = $this->getUserEntity();
        
        // Use this to interact with an API on the users behalf
        $identity->setToken($token->getToken());

        // Use this to get a new access token if the old one expires
        $identity->setRefresh($token->getRefreshToken());

        // Number of seconds until the access token will expire, and need refreshing
        $identity->setExpiration($token->getExpires());
        
        // Set info from $response and return
        return $this->setCustomInfo($identity, $response);
    }

    /**
     * Sets information which is specific to google
     * 
     */
    public function setCustomInfo($identity, $response)
    {
        $identity->setId($response->getId());
        $identity->setEmail($response->getEmail());
        $identity->setOauthEmail($response->getEmail());
        $identity->setDisplayName($response->getName());
        $identity->setUserName(strtolower(substr($response->getFirstName(), 0, 1) . substr($response->getLastName(), 0, 7)));
        $identity->setProvider(self::PROVIDER_NAME);
        return $identity;
    }
    
}
