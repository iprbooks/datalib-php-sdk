# DATALIB PHP SDK

API DATALIB - RESTful API сервер, предназначенный для взаимодействия с информационными системами клиентов -
подписчиков [DataLIB](https://datalib.ru/). Документация по API находится [будет здесь]().


# Содержание:

1. [Установка](#1)
2. [Инициализация клиента API](#2)
3. [Доступ к метаданным](#3)
    * [Получение коллекции книг](#31)
    * [Получение метаданных книги](#32)
    * [Получение коллекции периодических изданий](#33)
    * [Получение метаданных периодического издания](#34)
    * [Получение коллекции выпусков периодического издания](#35)
    * [Получение метаданных выпуска периодического издания](#36)
4. [Управление пользователями](4)
    * [Получение текущего списка пользователей](#41)
    * [Получение пользователя и его метаданных](#42)
    * [Добавление пользователя](#43)
    * [Блокировка пользователя](#44)
    * [Восстановление пользователя](#45)
5. [Бесшовная интеграция](#5)
    * [Генерация ссылки на активацию ключа и авторизацию пользователя](#51)
    * [Создание ссылки для прохождения автоматической регистрации/аутентификации пользователя](#52)



<a name="1"><h1>Установка</h1></a>
Простой и наиболее предпочтительный способ установки SDK - composer.
```sh
 "iprbooks/datalib-php-sdk" : "dev-master"
```

Другой способ - скачать архив с исходным кодм [master.zip](https://github.com/iprbooks/iprbooks-ebs-sdk/archive/master.zip)
или воспользоваться **git clone** и вручную добавить в проект.
```sh
git clone git@github.com:iprbooks/iprbooks-ebs-sdk.git
```

<a name="2"><h1>Инициализация клиента Api</h1></a>
Для инициализации клиента необходимы следующие параметры

| Параметр  | Описание |
| --------  | -------- |
| $clientId | Идентификатор организации-клиента ЭБС IPR BOOKS (получается вместе с ключевой фразой для получения JWT-токена). |
| $token    | В личном кабинете ЭБС авторизоваться под главным пользователем организации, сгенерировать ключ защиты данных для JWT-авторизации запросов. |

#### Пример
```php
$clientId = 187;
$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9kZXYuYXBpLmRhdGFsaWIucnVcL2FwaVwvYXV0aFwvbG9naW4iLCJpYXQiOjE2NTcxNzc5MDMsIm5iZiI6MTY1NzE3NzkwMywianRpIjoidHd5RFF4OGFFN0RpSjJTaCIsInN1YiI6OSwicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9.4zjEXK6FBPeKr-N5PmdGucVV_Ekt9RhtRiJ7iuAtbD0';

$client = new Client($token);
```


<a name="3"><h1>Доступ к метаданным</h1></a>
Доступ к метаданным позволяет посредством API получать информацию о книгах и периодических изданиях, доступных подписчику
ЭБС IPR BOOKS в рамках приобретенной подписки.


<a name="31"><h3>Получение коллекции книг</h3></a>
Список полей для фильтрации с описанием доступен в
[BooksCollection.php](https://github.com/iprbooks/iprbooks-ebs-sdk/blob/master/src/collections/BooksCollection.php),
атрибуты элемента коллекции (книги) доступны с помощью публичных методов определенных и описанных в
[Book.php](https://github.com/iprbooks/iprbooks-ebs-sdk/blob/master/src/models/Book.php)
#### Пример:
```php
// инициализация клиента
$client = new Client($clientId, $token);

// создание и конфигурация объекта коллекции
$booksCollection = new BooksCollection($client);
$booksCollection->setFilter(BooksCollection::YEAR_LEFT, '2010')
    ->setFilter(BooksCollection::YEAR_RIGHT, '2010')
    ->setLimit(25)
    ->setOffset(0);

// выполнение запроса
$booksCollection->get();

// обращение к элементу коллекции по индексу
$title = $booksCollection->getItem(0)->getTitle();

// перебор элементов коллекции с помощью foreach
foreach ($booksCollection as $book) {
    $title = $book->getTitle();
}
``` 

<a name="32"><h3>Получение метаданных книги</h3></a>
Атрибуты книги доступны с помощью публичных методов определенных и описанных в
[Book.php](https://github.com/iprbooks/iprbooks-ebs-sdk/blob/master/src/models/Book.php)
##### Пример:
```php
// инициализация клиента
$client = new Client($clientId, $token);

// создание объекта книги
$book = new Book($client);

// получение книги по $id
$book->get(7039);

// обращение к одному из атрибутов книги
$title = $book->getTitle();

// получение содержания
$content = $book->getContent();
$content->get(0)->getPage();
```


<a name="33"><h3>Получение коллекции периодических изданий</h3></a>
Список полей для фильтрации с описанием доступен в
[JournalCollection.php](https://github.com/iprbooks/iprbooks-ebs-sdk/blob/master/src/collections/JournalCollection.php),
атрибуты элемента коллекции (периодического издания) доступны с помощью публичных методов определенных и описанных в
[Journal.php](https://github.com/iprbooks/iprbooks-ebs-sdk/blob/master/src/models/Journal.php)
#### Пример:
```php
// инициализация клиента
$client = new Client($clientId, $token);

// создание и конфигурация объекта коллекции
$journalCollection = new JournalsCollection($client);
$journalCollection->setLimit(25)->setOffset(0);

// выполнение запроса
$journalCollection->get();

// обращение к элементу коллекции по индексу
$title = $journalCollection->getItem(0)->getTitle();

// перебор элементов коллекции с помощью foreach
foreach ($journalCollection as $journal) {
    $title = $journal->getTitle();
}
```


<a name="34"><h3>Получение метаданных периодического издания</h3></a>
Атрибуты книги доступны с помощью публичных методов определенных и описанных в
[Journal.php](https://github.com/iprbooks/iprbooks-ebs-sdk/blob/master/src/models/Journal.php)
#### Пример:
```php
// инициализация клиента
$client = new Client($clientId, $token);

// создание объекта периодического издания
$journal = new Journal($client);

// получение периодического издания по $id
$journal->get(3181);

// обращение к одному из атрибутов
$title = $journal->getTitle();
```
 
<a name="35"><h3>Получение коллекции выпусков периодического издания</h3></a>
Список полей для фильтрации с описанием доступен в
[IssuesCollection.php](https://github.com/iprbooks/iprbooks-ebs-sdk/blob/master/src/collections/IssuesCollection.php),
атрибуты элемента коллекции (выпуска) доступны с помощью публичных методов определенных и описанных в
[Issue.php](https://github.com/iprbooks/iprbooks-ebs-sdk/blob/master/src/models/Issues.php)
#### Пример:
```php
// инициализация клиента
$client = new Client($clientId, $token);

// создание и конфигурация объекта коллекции
$issuesCollection = new IssuesCollection($client);
$issuesCollection->setLimit(25)->setOffset(0);

// выполнение запроса, $id - id периодического издания
$issuesCollection->get(3181);

// обращение к элементу коллекции по индексу
$title = $issuesCollection->getItem(0)->getTitle();

// перебор элементов коллекции с помощью foreach
foreach ($issuesCollection as $issue) {
    $title = $issue->getTitle();
}
```
 
 
 <a name="36"><h3>Получение метаданных выпуска периодического издания</h3></a>
 Атрибуты книги доступны с помощью публичных методов определенных и описанных в
 [Issue.php](https://github.com/iprbooks/iprbooks-ebs-sdk/blob/master/src/models/Issue.php)
#### Пример:
```php
// инициализация клиента
$client = new Client($clientId, $token);

// создание объекта выпуска
$issue = new Issue($client);

// получение выпуска по $id
$issue->get(3339);

// обращение к одному из атрибутов
$title = $issue->getTitle();
```

 
<a name="4"><h1>Управление пользователями</h1></a>
<a name="41"><h3>Получение текущего списка пользователей</h3></a>
Список полей для фильтрации с описанием доступен в
[UsersCollection.php](https://github.com/iprbooks/iprbooks-ebs-sdk/blob/master/src/collections/UsersCollection.php),
атрибуты элемента коллекции (пользователя) доступны с помощью публичных методов определенных и описанных в
[User.php](https://github.com/iprbooks/iprbooks-ebs-sdk/blob/master/src/models/User.php)
#### Пример:
```php
// инициализация клиента
$client = new Client($clientId, $token);

// создание и конфигурация объекта коллекции
$usersCollection = new UsersCollection($client);
$usersCollection->setLimit(25)->setOffset(0);

// выполнение запроса, $id - id периодического издания
$usersCollection->get();

// обращение к элементу коллекции по индексу
$email = $usersCollection->getItem(0)->getEmail();

// перебор элементов коллекции с помощью foreach
foreach ($usersCollection as $user) {
    $email = $user->getEmail();
}
```


<a name="42"><h3>Получение пользователя и его метаданных</h3></a>
#### Пример:
```php
// инициализация клиента
$client = new Client($clientId, $token);

// создание объекта книги
$user = new User($client);

// получение пользователя по $id
$user->get(187);

// обращение к одному из атрибутов
$email = $user->getEmail();
```


<a name="43"><h3>Добавление пользователя</h3></a>
Обязательно должны быть переданы следующие параметры:
* $email — email-адрес пользователя, длина не более 255 символов
* $fullname — полное имя пользователя
* $password — пароль пользователя

Необязательные параметры:
* $userType — тип пользователя. Список возможных значений доступен в
[User.php](https://github.com/iprbooks/iprbooks-ebs-sdk/blob/master/src/models/User.php)

#### Пример:
```php
// инициализация клиента
$client = new Client($clientId, $token);

$email = 'newuser@mail.ru';
$fullname = 'newuser@mail.ru';
$password = '********';
$userType = User::STUDENT;

$manager = new UserManager($client);
$user = $manager->registerNewUser($email, $fullname, $password, $userType);
$userId = $user->getId();
```


<a name="44"><h3>Блокировка пользователя</h3></a>
Блокировка пользователя организации по id
#### Пример:
```php
// инициализация клиента
$client = new Client($clientId, $token);

$manager = new UserManager($client);
$manager->deleteUser(187);
```

<a name="45"><h3>Восстановление пользователя</h3></a>
Восстановление пользователя организации по id
#### Пример:
```php
// инициализация клиента
$client = new Client($clientId, $token);

$manager = new UserManager($client);
$manager->restoreUser(187);
```



<a name="5"><h1>Бесшовная интеграция</h1></a>
<a name="51"><h3>Генерация ссылки на активацию ключа и авторизацию пользователя</h3></a>

Обязательные параметры:
* $userId - id пользователя организации 

Необязательные параметры:
* $publicationId — проверяется существует ли данная публикация, если да, произойдет автопереход на страницу публикации

#### Пример:
```php
// инициализация клиента
$client = new Client($clientId, $token);

// получение id пользователя организации
$usersCollection = new UsersCollection($client);
$usersCollection->get();
$userId = $usersCollection->getItem(0)->getId();

// получение ссылки
$integrationManager = new IntegrationManager($client);
$url = $integrationManager->generateToken($userId);
```

<a name="52"><h3>Создание ссылки для прохождения автоматической регистрации/аутентификации пользователя</h3></a>

Обязательные параметры: 
* $email — email пользователя, если он уже зарегистрирован, произойдет автоматическая авторизация данного пользователя
* $fullname - полное имя пользователя
* $userType - тип пользователя:
    * 1 - студенты
    * 2 - аспиранты
    * 3 - преподаватели
    * 4 - нетипизированный(по умолчанию)
* $publicationId - если передано, проверяется существует ли данная публикация, если да, произойдет автопереход на страницу публикации
* $openMethod - работает, если передан publication_id, значения true/false. Если параметр передан, проверит доступность издания, проверит возможность загрузки в iframe, если все проверки успешно пройдены, откроет ридер с загруженной публикацией.

#### Пример:
```php
// инициализация клиента
$client = new Client($clientId, $token);

$integrationManager = new IntegrationManager($client);

// данные пользователя
$email = 'test@test.com';
$fullname = 'testname';
$userType = USER::STUDENT;
$publicationId = 123;
$isFrameOpen = true;

//получение ссылки
$url = $integrationManager->generateAutoAuthUrl($email, $fullname, $userType, $publicationId, $isFrameOpen);
```