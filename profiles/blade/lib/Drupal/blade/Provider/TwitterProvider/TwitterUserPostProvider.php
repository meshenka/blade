<?php

namespace Drupal\blade\Provider\TwitterProvider;

use TwitterOAuth\TwitterOAuth;
use Psr\Log\LoggerAwareTrait;
use Drupal\blade\Provider\ProviderInterface;
use Drupal\blade\Provider\NodeFinderTrait;

final class TwitterUserPostProvider implements  ProviderInterface
{
    use LoggerAwareTrait;
    use NodeFinderTrait;

    /**
     * @var array
     * $config = array(
     *   'consumer_key' => 'XXXXXXXXXXXXXXXXXXXXX',
     *   'consumer_secret' => 'YYYYYYYYYYYYYYYYYYYYYYYYYYYYYY',
     *   'oauth_token' => 'ZZZZZZZZZZZZZZZZZZZZZZZZZZZZZ',
     *   'oauth_token_secret' => 'VVVVVVVVVVVVVVVVVVVV',
     *   'output_format' => 'object'
     * );
     */
    private $config;

    /**
     * @var string
     */
    private $screenName;

    /**
     * @var TwitterOAuth\TwitterOAuth
     */
    private $twitter;

    public function __construct($config, $screenName)
    {
        $this->twitter = new TwitterOAuth($config);
        $this->screenName = $screenName;
    }

    /**
     * undocumented function
     *
     * @return void
     * @author
     **/
    public function fetch()
    {
        /**
     	 * Returns a collection of the most recent Tweets posted by the user
         * https://dev.twitter.com/docs/api/1.1/get/statuses/user_timeline
         */
        $params = array(
            'screen_name' => $this->screenName,
            'count' => 5,
            'exclude_replies' => true,
        );

        $response = $this->twitter->get('statuses/user_timeline', $params);
        foreach ($response as $post) {
            $this->import($post);
        }
    }

    private function buildUuid($post)
    {
        return 'twitter://'.$post->id_str;
    }

    private function twitterify($ret)
    {
        $ret = preg_replace("#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t< ]*)#", "\\1<a href=\"\\2\" target=\"_blank\">\\2", $ret);
        $ret = preg_replace("#(^|[\n ])((www|ftp)\.[^ \"\t\n\r< ]*)#", "\\1<a href=\"http://\\2\" target=\"_blank\">\\2", $ret);
        $ret = preg_replace("/@(\w+)/", "<a href=\"http://twitter.com/\\1\" target=\"_blank\">@\\1</a>", $ret);
        $ret = preg_replace("/#(\w+)/", "<a href=\"http://twitter.com/hashtag/\\1\" target=\"_blank\">#\\1</a>", $ret);

        return $ret;
    }

    private function import($post)
    {
        if ($node = $this->findByRemoteId($this->buildUuid($post))) {
            $this->logger->info('post @postid already imported', ['@postid' => $this->buildUuid($post)]);

            return false;
        }

        $newNode = (object) NULL;
        $newNode->type = 'news';
        node_object_prepare($newNode);

        $newNode->title = $post->text;
        $newNode->uid = 1;
        $newNode->created = strtotime($post->created_at);
        $newNode->changed = strtotime($post->created_at);
        $newNode->status = 1;
        $newNode->comment = 0;
        $newNode->promote = 0;
        $newNode->moderate = 0;
        $newNode->sticky = 0;
        $newNode->format = 'full_html';
        $newNode->language = 'fr';

        $newNode->body[LANGUAGE_NONE][0]['format'] = 'full_html';
        $newNode->body[LANGUAGE_NONE][0]['value'] = '<p>'.$this->twitterify($post->text).'</p>';
        $newNode->body[LANGUAGE_NONE][0]['summary'] = text_summary($newNode->body[LANGUAGE_NONE][0]['value']);
        // add CCK field data
        $newNode->field_remote_id[LANGUAGE_NONE][0]['value'] = $this->buildUuid($post);

        // TODO $post->media
        // save node
        node_save($newNode);

        $this->logger->info('post @postid imported', ['@postid' => $newNode->field_remote_id[LANGUAGE_NONE][0]['value']]);

        return $newNode;
    }
}
