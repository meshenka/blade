<?php
/**
 * this drush command load composer autoloader and
 * import contents from a Facebook account
 *
 * @author sylvain.gogel@gmail.com
 * @package Blade
 * @subpackage Importer
 * @example drush scr profiles/blade/drush/twitter.php
 * @since 1.0.0
 */

include_once DRUPAL_ROOT.'/sites/all/libraries/autoload.php';

use Drupal\blade\Provider\TwitterProvider\TwitterUserPostProvider;
use Drupal\log\DrushLogger;

$logger = new DrushLogger();

$logger->info('Twitter Import');

$config = array(
    'consumer_key' => variable_get('bladenews_twitter_app_consumer_key', false),
    'consumer_secret' =>  variable_get('bladenews_twitter_app_consumer_secret', false),
    'oauth_token' => variable_get('bladenews_twitter_oauth_token', false),
    'oauth_token_secret' => variable_get('bladenews_twitter_oauth_token_secret', false),
    'output_format' => 'object',
);

$twitterProvider = new TwitterUserPostProvider($config, 'meshenka');
$twitterProvider->setLogger($logger);

$twitterProvider->fetch();
