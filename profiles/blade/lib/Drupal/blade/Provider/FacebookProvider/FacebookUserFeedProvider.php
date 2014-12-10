<?php

namespace Drupal\blade\Provider\FacebookProvider;

use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Psr\Log\LoggerAwareTrait;
use Drupal\blade\Provider\NodeFinderTrait;

/**
 * Import les posts d'un user facebook sous forme de node News
 *
 */
final class FacebookUserFeedProvider extends AbstractFacebookProvider
{
    use LoggerAwareTrait;
    use NodeFinderTrait;

    /**
     * @var integer
     */
    private $userId;

    /**
     * Constructor
     * @param integer $userId a facebook user id
     * @param Facebook\FacebookSession an already open session
     *
     * @return void
     **/
    public function __construct($userId, FacebookSession $session)
    {
        parent::__construct($session);
        $this->userId = $userId;
    }

    /**
     * fetch status posts (we dont need share, link etc...)
     *
     * @return \stdClass last imported node
     * @see https://developers.facebook.com/docs/graph-api/reference/v2.2/user/feed?locale=fr_FR
     **/
    protected function doFetch()
    {
        $data = (new FacebookRequest($this->getSession(), 'GET', '/'.$this->userId.'/feed'/*, ['filter' => 'app_2915120374']*/))->execute()->getGraphObject()->asArray();

        foreach ($data['data'] as $post) {
            $this->import($post);
        }
    }

    private function buildUuid($post)
    {
        return 'facebook://'.$post->id;
    }

    /**
     * import a facebook post as a node
     * @param \stdClass a facebook post
     * @return \stdClass the imported node
     * @see https://developers.facebook.com/docs/graph-api/reference/v2.2/post?locale=fr_FR
     **/
    private function import(\stdClass $post)
    {
        $remoteId = $this->buildUuid($post);

        if ($node = $this->findByRemoteId($remoteId)) {
            $this->logger->info('post @postid already imported', ['@postid' => $remoteId]);

            return false;
        }

        $newNode = (object) NULL;
        $newNode->type = 'news';
        node_object_prepare($newNode);

        $newNode->title = $post->story.' '.$post->name;
        $newNode->uid = 1;
        $newNode->created = strtotime($post->created_time);
        $newNode->changed = strtotime($post->update_time);
        $newNode->status = 1;
        $newNode->comment = 0;
        $newNode->promote = 0;
        $newNode->moderate = 0;
        $newNode->sticky = 0;
        $newNode->format = 'full_html';
        $newNode->language = 'fr';

        $newNode->body[LANGUAGE_NONE][0]['format'] = 'full_html';
        $newNode->body[LANGUAGE_NONE][0]['value'] = '<p>'.$post->story.' <a target="_blank" href="'.$post->link.'" title="'.$post->name.'">'.$post->name.'</a></p>';
        $newNode->body[LANGUAGE_NONE][0]['summary'] = text_summary($newNode->body[LANGUAGE_NONE][0]['value']);
        // add CCK field data
        $newNode->field_remote_id[LANGUAGE_NONE][0]['value'] = $remoteId;

        /* TODO importer les images
           //create file object
        $file = new stdClass();
        $file->uid = '1';
        //the file is already in sites/default/files - which is D7 public://
        $file->filename = $fpURL[3];
        $file->uri = file_build_uri($fpURL[3]);
        $file->filemime = file_get_mimetype((string) $new_node->field_image);//this is the complete path
        $file->status = '1';
        $savedFile = file_save($file);
        $savedFile = file_load($savedFile->fid);//do we need to do this?
        //slot into node - do we have to do all this?  Probably not...
        $node->field_visual[LANGUAGE_NONE][0] = array(
          'fid' => $savedFile->fid,//file id is key - now registered as file in system
          'alt' => $post->caption,
          'title' => $post->description,
          'uid' => '1',
          'filename' => $savedFile->filename,
          'uri' => $savedFile->uri,
          'filemime' => $savedFile->filemime,
          'filesize' => $savedFile->filesize,
          'status' => '1',
        );
        */
        // save node
        node_save($newNode);

        $this->logger->info('post @postid imported', ['@postid' => $remoteId]);

        return $newNode;
    }

    /**
     * Find if post was already imported
     *
     * @param  string                 $postId a remote post Id
     * @return mixed(false|\stdClass) a node entity or false
     */
    private function findExistingNode($postId)
    {
        $query = new \EntityFieldQuery();
        $query
            ->entityCondition('entity_type', 'node')
            ->entityCondition('bundle', 'news')
            ->fieldCondition('field_remote_id', 'value', $postId, '=')
            ->range(0, 1);
        $result = $query->execute();

        if (isset($result['node'])) {
            return entity_load('node', array_keys($result['node']));
        }

        return false;
    }
}
