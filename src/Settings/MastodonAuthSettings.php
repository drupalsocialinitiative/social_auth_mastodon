<?php

namespace Drupal\social_auth_mastodon\Settings;

use Drupal\social_api\Settings\SettingsBase;

/**
 * Defines methods to get Social Auth Mastodon settings.
 */
class MastodonAuthSettings extends SettingsBase implements MastodonAuthSettingsInterface {

  /**
   * Client ID.
   *
   * @var string
   */
  protected $clientId;

  /**
   * Client secret.
   *
   * @var string
   */
  protected $clientSecret;

  /**
   * Instance URL.
   *
   * @var string
   */
  protected $instance;

  /**
   * Restricted domain.
   *
   * @var string
   */
  protected $restrictedDomain;

  /**
   * {@inheritdoc}
   */
  public function getClientId() {
    if (!$this->clientId) {
      $this->clientId = $this->config->get('client_id');
    }
    return $this->clientId;
  }

  /**
   * {@inheritdoc}
   */
  public function getClientSecret() {
    if (!$this->clientSecret) {
      $this->clientSecret = $this->config->get('client_secret');
    }
    return $this->clientSecret;
  }

  /**
   * {@inheritdoc}
   */
  public function getInstance() {
    if (!$this->instance) {
      $this->instance = $this->config->get('instance');
    }
    return $this->instance;
  }

}
