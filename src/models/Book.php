<?php

namespace Datalib\Sdk\Models;

use Datalib\Sdk\Collections\Publication\ContentCollection;
use Exception;
use Datalib\Sdk\Client;
use Datalib\Sdk\Core\Model;

final class Book extends Model
{

    private $apiMethod = '/catalog/books/{id}';


    /**
     * Конструктор Book
     * @param Client $client
     * @param null $response
     * @throws Exception
     */
    public function __construct(Client $client, $response = null)
    {
        parent::__construct($client, $response);
        return $this;
    }

    /**
     * Возвращает метод апи для вызова
     */
    protected function getApiMethod()
    {
        return $this->apiMethod;
    }

    /**
     * Возвращает список содержания
     * @return ContentCollection
     * @throws Exception
     */
    public function getContent()
    {
        if (!array_key_exists('contents', $this->data)) {
            $content = array();
        } else {
            $content = $this->data['contents'];
        }
        return new ContentCollection($content);
    }

    /**
     * Возрващает id книги
     * @return mixed
     */
    public function getId()
    {
        return $this->getValue('id');
    }

    public function getPublicationType()
    {
        return $this->getValue('publication_type');
    }

    /**
     * Возвращает название книги
     * @return mixed
     */
    public function getTitle()
    {
        return $this->getValue('title');
    }

    /**
     * Возвращает дополнительное название книги
     * @return mixed
     */
    public function getTitleAdditional()
    {
        return $this->getValue('title_additional');
    }

    /**
     * Возвращает издательство
     * @return mixed
     */
    public function getPublishers()
    {
        return $this->getValue('publishers');
    }

    /**
     * Возвращает список авторов
     * @return mixed
     */
    public function getAuthors()
    {
        return $this->getValue('authors');
    }

    /**
     * @return mixed
     */
    public function getLiability()
    {
        return $this->getValue('liability');
    }

    /**
     * Возвращает год издания
     * @return mixed
     */
    public function getYear()
    {
        return $this->getValue('year');
    }

    public function getIsbn()
    {
        return $this->getValue('isbn');
    }

    public function getDoi()
    {
        return $this->getValue('doi');
    }

    public function getMark()
    {
        return $this->getValue('mark');
    }

    /**
     * Возвращает описание
     * @return mixed
     */
    public function getDescription()
    {
        return $this->getValue('description');
    }

    public function getBibliography()
    {
        return $this->getValue('bibliography');
    }

    public function getViewsCount()
    {
        return $this->getValue('views');
    }

    public function getRating()
    {
        return $this->getValue('rating');
    }

    /**
     * Возвращает ссылку на обложку книги
     * @return mixed
     */
    public function getImage()
    {
        return $this->getValue('cover');
    }

    public function getPublicationTypeText()
    {
        return $this->getValue('publicationType');
    }

}