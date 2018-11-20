<?php

namespace Drupal\social_auth_mastodon;

use Drupal\social_auth\AuthManager\OAuth2Manager;
use Drupal\Core\Config\ConfigFactory;

/**
 * Contains all the logic for Mastodon OAuth2 authentication.
 */
class MastodonAuthManager extends OAuth2Manager {

  /**
   * Constructor.
   *
   * @param \Drupal\Core\Config\ConfigFactory $configFactory
   *   Used for accessing configuration object factory.
   */
  public function __construct(ConfigFactory $configFactory) {
    parent::__construct($configFactory->get('social_auth_mastodon.settings'));
  }

  /**
   * {@inheritdoc}
   */
  public function authenticate() {
    $this->setAccessToken($this->client->getAccessToken('authorization_code',
      ['code' => $_GET['code']]));
  }

  /**
   * {@inheritdoc}
   */
  public function getUserInfo() {
    $this->user = $this->client->getResourceOwner($this->getAccessToken());
    return $this->user;
  }

  /**
   * {@inheritdoc}
   */
  public function getAuthorizationUrl() {
    $scopes = [
      'read:accounts',
    ];

    $mastodon_scopes = $this->getScopes();
    if ($mastodon_scopes) {
      if (strpos($mastodon_scopes, ',')) {
        $scopes = array_merge($scopes, explode(',', $mastodon_scopes));
      }
      else {
        $scopes[] = $mastodon_scopes;
      }
    }

    // Returns the URL where user will be redirected.
    return $this->client->getAuthorizationUrl([
      'scope' => implode(' ', $scopes),
    ]);
  }

  /**
   * {@inheritdoc}
   */
  public function requestEndPoint($path) {
    $url = $this->settings->getInstance() . $path;

    $request = $this->client->getAuthenticatedRequest('GET', $url, $this->getAccessToken());

    return $this->client->getParsedResponse($request);
  }

  /**
   * {@inheritdoc}
   */
  public function getState() {
    return $this->client->getState();
  }

}
