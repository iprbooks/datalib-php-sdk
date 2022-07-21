<?php

namespace Datalib\Sdk\Models;

final class Content
{

    /*
     * Элемент содержания
     */
    private $content;


    /**
     * Конструктор Content
     * @param $content
     */
    public function __construct($content)
    {
        $this->content = $content;
    }

    /**
     * Возвращает номер страницы оглавления
     * @return mixed
     */
    public function getPage()
    {
        if ($this->content) {
            return $this->content['page_id'];
        } else {
            return null;
        }
    }

    /**
     * Возвращает заголовок оглвления
     * @return mixed
     */
    public function getDescription()
    {
        if ($this->content) {
            return $this->content['content'];
        } else {
            return null;
        }
    }

}