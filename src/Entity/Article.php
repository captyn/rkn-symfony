<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Article
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    public function getId()
    {
        return $this->id;
    }

    /**
     * @ORM\Column(type="text")
     */
    private $title;

    public function getTitle() {
        return $this->title;
    }
    public function setTitle($title) {
        $this->title = $title;
    }

    /**
     * @ORM\Column(type="text")
     */
    private $body;

    public function getBody() {
        return $this->body;
    }
    public function setBody($body) {
        $this->body = $body;
    }

    /**
     * @ORM\Column(type="text")
     */
    private $article_type;

    public function getArticletype() {
        return $this->article_type;
    }
    public function setArticletype($article_type) {
        $this->article_type = $article_type;
    }


    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {

        if (!$this->getCreatedTime()) {
            $this->setCreatedTime((new\DateTime()));
        }

        if (!$this->getModifiedTime()) {
            $this->setModifiedTime(new \DateTime());
        }
    }

    /**
     * @ORM\PreUpdate
     */
    public function preModifiedTime()
    {
        $this->setModifiedTime(new \DateTime());
    }


    /**
     * @ORM\Column(type="datetimetz")
     * @var \DateTime
     */
    private $created;

    public function getCreatedTime()
    {
        return $this->created;
    }
    public function setCreatedTime($created)
    {
        $this->created = $created;
    }


    /**
     * @ORM\Column(type="integer")
     */
    private $creator;

    public function getCreator() {
        return $this->creator;
    }
    public function setCreator($creator) {
        $this->creator = $creator;
    }

    /**
     * @ORM\Column(type="boolean")
     */
    private $deleted;

    public function getDeleted() {
        return $this->deleted;
    }
    public function setDeleted($deleted) {
        $this->deleted = $deleted;
    }


    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $last_modified;

    public function getModifiedTime()
    {
        return $this->last_modified;
    }
    public function setModifiedTime($last_modified)
    {
        $this->last_modified = $last_modified;
    }

    /**
     * @ORM\Column(type="integer")
     */
    private $modified_by;

    public function getModifiedby() {
        return $this->modified_by;
    }
    public function setModifiedby($modified_by) {
        $this->modified_by = $modified_by;
    }

}
