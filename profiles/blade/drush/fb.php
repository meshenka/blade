<?php
/**
 * this drush command load composer autoloader and
 * import contents from a Facebook account
 *
 * @author sylvain.gogel@gmail.com
 * @package Blade
 * @subpackage Importer
 * @example drush scr profiles/blade/drush/fb.php
 * @since 1.0.0
 *
 */

include_once DRUPAL_ROOT.'/sites/all/libraries/autoload.php';

use Facebook as FB;
use Facebook\HttpClients\FacebookGuzzleHttpClient;
use Drupal\blade\Provider\FacebookProvider\FacebookUserFeedProvider;
use Drupal\log\DrushLogger;

$logger = new DrushLogger();
$logger->info('Facebook Import');

$fbId = variable_get('bladenews_fb_id', false);
$fbSecret = variable_get('bladenews_fb_secret', false);
FB\FacebookSession::setDefaultApplication($fbId, $fbSecret);

FB\FacebookRequest::setHttpClientHandler(
  new FacebookGuzzleHttpClient()
  );

$session = FB\FacebookSession::newAppSession();
$userId = variable_get('bladenews_fb_userid', false);

$fbProvider = new FacebookUserFeedProvider($userId, $session);
$fbProvider->setLogger($logger);

$fbProvider->fetch();
