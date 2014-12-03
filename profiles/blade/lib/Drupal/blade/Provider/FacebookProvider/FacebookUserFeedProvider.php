<?php

namespace Drupal\blade\Provider\FacebookProvider;

use Facebook\FacebookSession;
use Facebook\FacebookRequest;

/**
 * Import les posts d'un user facebook sous forme de node News
 *
 */
final class FacebookUserFeedProvider extends AbstractFacebookProvider
{
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
     * undocumented function
     *
     * @return \stdClass last imported node
     **/
    protected function doFetch()
    {
        $data = (new FacebookRequest($this->getSession(), 'GET', '/'.$this->userId.'/posts'))->execute()->getGraphObject()->asArray();

        return $this->import($data['data'][0]);
    }

    /**
     * import a facebook post as a node
     * @param \stdClass a facebook post
     * @return \stdClass the imported node
     **/
    private function import(\stdClass $post)
    {
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
        $newNode->body[LANGUAGE_NONE][0]['value'] = '<p>'.$post->story.' <a href="'.$post->link.'" title="'.$post->name.'">'.$post->name.'</a></p>';
        $newNode->body[LANGUAGE_NONE][0]['summary'] = text_summary($newNode->body[LANGUAGE_NONE][0]['value']);
        // add CCK field data
        $newNode->field_remote_id[LANGUAGE_NONE][0]['value'] = $post->id;

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

        return $newNode;
    }
}
