# DATALIB PHP SDK

API DATALIB - RESTful API сервер, предназначенный для взаимодействия с информационными системами клиентов -
подписчиков [DataLIB](https://datalib.ru/). Документация по API находится [будет здесь]().


# Содержание:

1. [Установка](#1)
2. [Инициализация клиента API](#2)
3. [Доступ к метаданным](#3)
    * [Получение списка авторов с фильтрацией](#31)
    * [Получение списка издательств с фильтрацией](#32)
    * [Получение списка дисциплин с фильтрацией](#33)
    * [Получение списка заголовков книг с фильтрацией](#34)
    * [Получение списка типов публикаций](#35)
    * [Получение списка категорий](#36)
    * [Получение списка книг с фильтрацией](#37)
    * [Получение метаданных книги](#38)
4. [Бесшовная интеграция](#4)
    * [Создание ссылки для прохождения автоматической регистрации/аутентификации пользователя](#41)



<a name="1"><h1>Установка</h1></a>
Простой и наиболее предпочтительный способ установки SDK - composer.
```sh
 "datalib/datalib-php-sdk" : "dev-master"
```

Другой способ - скачать архив с исходным кодм [master.zip](https://github.com/iprbooks/datalib-php-sdk/archive/refs/heads/master.zip)
или воспользоваться **git clone** и вручную добавить в проект.
```sh
git clone git@github.com:iprbooks/datalib-php-sdk.git
```

<a name="2"><h1>Инициализация клиента Api</h1></a>
Для инициализации клиента необходим <b>jwt-token</b>. Получить его можно связавшись с техподдержкой [office@datalib.ru](mailto:office@datalib.ru)

#### Пример
```php
$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9kZXYuYXBpLmRhdGFsaWIucnVcL2FwaVwvYXV0aFwvbG9naW4iLCJpYXQiOjE2NTcxNzc5MDMsIm5iZiI6MTY1NzE3NzkwMywianRpIjoidHd5RFF4OGFFN0RpSjJTaCIsInN1YiI6OSwicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9.4zjEXK6FBPeKr-N5PmdGucVV_Ekt9RhtRiJ7iuAtbD0';

$client = new Client($token);
```


<a name="3"><h1>Доступ к метаданным</h1></a>
Доступ к метаданным позволяет посредством API получать информацию о книгах, доступных подписчику DataLIB в рамках приобретенной подписки.

<a name="31"><h3>Получение списка авторов с фильтрацией</h3></a>

```php
$authors = new AuthorsCollection($client);
$authors->setFilter(AuthorsCollection::TEXT, 'Ивано');
$authors->get();
$author = $authors->getItem(0);
``` 

<a name="32"><h3>Получение списка издательств с фильтрацией</h3></a>

```php
$publishers = new PublishersCollection($client);
$publishers->setFilter(PublishersCollection::TEXT, 'ай пи ар');
$publishers->get();
$publisher = $publishers->getItem(0);
``` 

<a name="33"><h3>Получение списка дисциплин с фильтрацией</h3></a>

```php
$disciplines = new DisciplinesCollection($client);
$disciplines->setFilter(DisciplinesCollection::TEXT, '')
    ->setFilter(DisciplinesCollection::CATEGORY_ID, 1)
    ->get();
$discipline = $disciplines->getItem(0);
``` 

<a name="34"><h3>Получение списка заголовков книг с фильтрацией</h3></a>

```php
$titles = new TitleCollection($client);
$titles->setFilter(TitleCollection::TEXT, 'алгебра');
$titles->get();
$title = $titles->getItem(0);
``` 

<a name="35"><h3>Получение списка типов публикаций</h3></a>

```php
$pubTypes = new PubTypeCollection($client);
$pubTypes->get();
$pubType = $pubTypes->getItem(0);
``` 

<a name="36"><h3>Получение списка категорий</h3></a>

```php
// TODO
``` 

<a name="37"><h3>Получение коллекции книг</h3></a>
Список полей для фильтрации с описанием доступен в
[BooksCollection.php](https://github.com/iprbooks/datalib-php-sdk/blob/master/src/collections/publication/BooksCollection.php),
атрибуты элемента коллекции (книги) доступны с помощью публичных методов определенных и описанных в
[Book.php](https://github.com/iprbooks/datalib-php-sdk/blob/master/src/models/Book.php)
#### Пример:
```php
// создание и конфигурация объекта коллекции
$bookCollection = new BooksCollection($client);
$bookCollection->setFilter(BooksCollection::CATEGORY, 1)
    ->setFilter(BooksCollection::RELATED_CATEGORIES, array(2, 3))
    ->setPage(3)
    ->get();


// обращение к элементу коллекции по индексу
$title = $bookCollection->getItem(0)->getTitle();

// перебор элементов коллекции
foreach ($bookCollection as $book) {
    $title = $book->getTitle();
}
``` 

<a name="38"><h3>Получение метаданных книги</h3></a>
Атрибуты книги доступны с помощью публичных методов определенных и описанных в
[Book.php](https://github.com/iprbooks/datalib-php-sdk/blob/master/src/models/Book.php)
##### Пример:
```php
// создание объекта книги
$book = new Book($client);

// получение книги по $id
$book->get(116611);

// обращение к одному из атрибутов книги
$title = $book->getId();

// получение содержания
$content = $book->getContent();
$content->get(0)->getPage();
```

<a name="4"><h1>Бесшовная интеграция</h1></a>
<a name="41"><h3>Создание ссылки для прохождения автоматической регистрации/аутентификации пользователя</h3></a>

Обязательные параметры: 
* $email — email пользователя, если он уже зарегистрирован, произойдет автоматическая авторизация данного пользователя
* $fullname - полное имя пользователя

Необязательные параметры:
* $publicationId - если передано, произойдет автопереход на страницу публикации

<b>Внимание!</b> Для каждого пользователя DataLib ссылка бесшовного перехода одноразовая и может быть только одна. Рекомендуется генерировать ее непосредственно перед использованием. 

#### Пример:
```php
// инициализация
$userManager = new UserManager($client);

// параметры
$email = 'test@test.com';
$fullname = 'testname';
$publicationId = 123;

//получение ссылки
$url = $userManager->generateAutoAuthUrl($email, $fullname, $publicationId);
```