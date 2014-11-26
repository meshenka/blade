<?php

namespace Blade\Model;

class Post
{
    private $id;
    private $title;
    private $content;
    private $medias = array();
    private $sourceUrl;
    private $createdAt;

    /**
     * id
     *
     * @return mixed(int|string) the unique id of the post
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * id
     *
     * @param Mixed $newid The unique id of the post
     */
    protected function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * title
     *
     * @return string the post title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * title
     *
     * @param String $newtitle The post title
     */
    protected function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * the post content
     *
     * @return string post content
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * content
     *
     * @param String $newcontent Post content
     */
    protected function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * sourceUrl
     *
     * @return string remote post uri
     */
    public function getSourceUrl()
    {
        return $this->sourceUrl;
    }

    /**
     * sourceUrl
     *
     * @param String $newsourceUrl Remote post uri
     */
    protected function setSourceUrl($sourceUrl)
    {
        $this->sourceUrl = $sourceUrl;

        return $this;
    }

    /**
     * createdAt
     *
     * @return DateTime date this post was initialiy published
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * createdAt
     *
     * @param DateTime $newcreatedAt D
     */
    protected function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * medias
     * @return array array of remote medias
     */
    public function getMedias()
    {
        return $this->medias;
    }

    public function addMedia($media)
    {
        $this->medias[] = $media;
    }
}
