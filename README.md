



#  PHP-VK-BOT

Библиотека для работы с VK-ботами.
Поддерживается работа в беседах.

___

##  Содержание

1. [TODO](#todo)
 2. [Установка](#%D0%A3%D1%81%D1%82%D0%B0%D0%BD%D0%BE%D0%B2%D0%BA%D0%B0)
 3. [Обработка команд](#3-обработка-команд)
    + [Базовые опции](#31-базовые-опции)
      + [Вызов команды при помощи метода](#311-вызов-команды-при-помощи-метода)
      + [Игнорирование вызова команды при помощи метода](#312-игнорирование-вызова-команды-при-помощи-метода)
    + [Расширенные опции](#32-расширенные-опции)
      + [Вариативность вызова команды](#321-вариативность-вызова-команды)
      + [Варианты реагирования бота на сообщения](#322-варианты-реагирования-бота-на-сообщения)
        - [Похоже на](#3221-похоже-на) 
        - [Начинается с](#3222-начинается-с)
        - [Заканчивается на](#3223-заканчивается-на)
        - [Содержит](#3224-содержит)
        - [Дополнение](#3225-дополнение)
      + [Исполнение нескольких методов](#323-исполнение-нескольких-методов)
4. [Методы](#4-методы)
    + [attachments (Вложения)](#41--attachmentsarraystring-attachments-arraystring)
    + [sendMessage (Отправить сообщение)](#42-sendmessagearraystring-message-int-peerid--null-void) 
    + [sendPhoto (Отправить фотографию)](#43-sendphotoarrraystring-photos-int-peerid--nullvoid)
    + [sendVideo (Отправить видео)](#44-sendvideoarrraystring-videos-int-peerid--nullvoid)
    + [sendDoc (Отправить документ)](#45-senddocarrraystring-docs-int-peerid--nullvoid)
    + [sendAudio (Отправить аудиозапись)](#46-sendaudioarrraystring-audio-int-peerid--nullvoid)
    + [sendWall (Отправить запись со стены)](#47-sendwallarrraystring-walls-int-peerid--nullvoid)
    + [sendPoll (Отправить опрос)](#48-sendpollarrraystring-polls-int-peerid--nullvoid)
    + [sendMarket (Отправить товар)](#49-sendmarketarrraystring-items-int-peerid--nullvoid)

___
## TODO

|Дата|Описание релиза |Состояние 
|:--:|--|--|
| 7.02.2019 |Возможность отправлять сообщения.  |**done**
| 7.02.2019 |Обработка команд от пользователей как в беседе так и в личных сообщениях.  |**done**
| 7.02.2019 |Обработка событий. (Покинул беседу, присоединился и т.д.)  |**done**

## Установка


>composer require danil005/php-vk-bot:dev-master


## 3. Обработка команд

### 3.1. Базовые опции

#### 3.1.1. Вызов команды при помощи метода

Для того, чтобы обработать команды, вам необходимо зайти в папку traits и открыть файл **CommantList.php**.  Создание каждого метода - это и есть команда. Также необходимо создавать методы только строчными буквами.

```php
trait CommandList  
{  
	protected function hello()  
	{  
		$this->sendMessage('Hello!');  
	}
}
 ```
 
 Теперь, если написать "hello" в чат, бот вам ответит: "Hello!".
#### 3.1.2. Игнорирование вызова команды при помощи метода

Если не хотите, чтобы метод вызывался при вводе ключевого слова, добавьте нижнее подчеркивание в начале метода (**function_hello**):

 ```php
trait CommandList  
{  
    protected function _hello()  
    {  
         $this->sendMessage('Hello!');  
	 
    }
}
 ```
 
 Тогда при вызове _hello или hello, метод выполняться не будет.
 
#### 3.1.3. Реакция не предложения или другие слова
 
Если хотите сделать реакцию на предложения, то создайте метод **cList()** в CommandList.

```php
protected function cList()  
{  
    return [  
        [ //Команда #1
            'text'=>'text message',  
            'method' => '_hello'  //Обязательно использовать _.
        ],
        [...], //Команда #2
        ...  
    ];
}
 ```
 
**Обязательно создавать методы с использование нижнего подчеркивания, иначе этот метод можно будет вызывать.**

 Массив состоящий из вложенного массива создает команду.
 
|Ключ|Значение  |
|--|--|
|text|Сообщение на которое будет реагировать бот.|
|method|Метод из CommandList. **Обязательно использовать: _**

### 3.2. Расширенные опции

#### 3.2.1. Вариативность вызова команды

Если указать ключ **text** как массив, то бот будет реагировать на несколько фраз.

```php
'text'=>['text message 1', 'text message 2']
```

#### 3.2.2. Варианты реагирования бота на сообщения.

Вы можете вызывать команду разными вариантами:

 - Похоже на
 - Начинается с 
 - Заканчивается на
 - Содержит
 
##### 3.2.2.1. Похоже на

Чтобы использовать этот вариант, добавьте **|** в начале строки.

Вы можете настроить вероятность совпадения в диапазоне [0-100]. 

Установить эту настройку можно в **config.php** под c ключом: **similar_percent**.

По умолчанию: 75%.

```php
'text'=>'|привет всем',
```

##### 3.2.2.2. Начинается с

Чтобы использовать этот вариант, добавьте **[|** в начале строки.

```php
'text'=>'[|привет всем',
```

##### 3.2.2.3. Заканчивается на

Чтобы использовать этот вариант, добавьте **|]** в конец строки.

```php
'text'=>'привет всем|]',
```

##### 3.2.2.4. Содержит

Чтобы использовать этот вариант, выделите фразу в фигурных скобках **{ фраза }**.

```php
'text'=>'{привет всем}',
```

##### 3.2.2.5. Дополнение

Данный способ работает и с использованием множества вариантов вызова.

```php
'text'=>['[|привет', '{ку}', 'хай|]', '|здравствуйте']
```

#### 3.2.3. Исполнение нескольких методов

Если указать ключ **method** как массив, то бот будет выполнять указанные методы по очереди.

```php
'method'=>['_hello', '_goodbye']
```

## 4. Методы

### 4.1.  attachments(array|string $attachments): array|string

Добавить вложения для сообщения. Указывать **ДО** вызова метода sendMessage()

|Аргумент|Тип данных|Описание|По умолчанию|
|--|--|--|--|
|$attachments|array\|string|Ссылка на медиавложения или массив|обязательно

Пример:

```php
protected function _hello()  
{  
  $this->attachments('photo-100172_166443618');
  //$this->attachments(['photo-100172_166443618', 'photo-124172_166443618'])
  $this->sendMessage(['Hello!', 'HI!']);  
}
```

**Если указать два и более подряд идущих методов attachments, то будет использоваться последний.**

Типы медиавложения:

|Тип|Описание|
|--|--|
|photo|Фотографии|
|video|Видео|
|audio|Аудио|
|doc|Документ|
|wall|Запись на стене|
|poll|Опрос|
|market|Товар|

Подробнее на официальном сайте [VK.COM (messages.send)](https://vk.com/dev/messages.send).

___
### 4.2. sendMessage(array|string $message, int $peerId = null): void

Отправка сообщения пользователю/в беседу.


|Аргумент|Тип данных|Описание|По умолчанию|
|--|--|--|--|
|$message|array\|string|Сообщение или массив сообщений, которые будут выбраны генератором случайных чисел.|обязательно
|$perrId|int|ID-пользователя/чата.|null 

Пример:

```php
$this->sendMessage(['Hi', 'Hello!']);
//Result: Hi
```

___
### 4.3. sendPhoto(arrray|string $photos, int $peerId = null):void

Отправить фотографию, не используя метод attachments. Указывайте **<owner_id>_<media_id>**.

Тип фотографию(и) будет по умолчанию photo. То есть photo-**100172_166443618**, то вам нужно вставить лишь выделенную часть.

|Аргумент|Тип данных|Описание|По умолчанию|
|--|--|--|--|
|$photos|array\|string|Ссылка на фотографию или массив|обязательно


Пример:

```php
$this->sendPhoto('175343153_456239018');
```

___
### 4.4. sendVideo(arrray|string $videos, int $peerId = null):void

Отправить видео, не используя метод attachments. По тому же правилу, что и sendPhoto.

|Аргумент|Тип данных|Описание|По умолчанию|
|--|--|--|--|
|$videos|array\|string|Ссылка на видео или массив|обязательно


Пример:

```php
$this->sendVideo('175343153_456239018');
```

___
### 4.5. sendDoc(arrray|string $docs, int $peerId = null):void

Отправить документ(ы), не используя метод attachments. По тому же правилу, что и sendPhoto.

|Аргумент|Тип данных|Описание|По умолчанию|
|--|--|--|--|
|$docs|array\|string|Ссылка на документ или массив|обязательно


Пример:

```php
$this->sendDoc('175343153_456239018');
```


___
### 4.6. sendAudio(arrray|string $audio, int $peerId = null):void

Отправить аудио, не используя метод attachments. По тому же правилу, что и sendPhoto.

|Аргумент|Тип данных|Описание|По умолчанию|
|--|--|--|--|
|$audio|array\|string|Ссылка на аудио или массив|обязательно


Пример:

```php
$this->sendAudio('175343153_456239018');
```


___
### 4.7. sendWall(arrray|string $walls, int $peerId = null):void

Отправить запись(и) со стен(ы), не используя метод attachments. По тому же правилу, что и sendPhoto.

|Аргумент|Тип данных|Описание|По умолчанию|
|--|--|--|--|
|$walls|array\|string|Ссылка на запись со стены или массив|обязательно


Пример:

```php
$this->sendWall('175343153_456239018');
```

___
### 4.8. sendPoll(arrray|string $polls, int $peerId = null):void

Отправить опрос(ы), не используя метод attachments. По тому же правилу, что и sendPhoto.

|Аргумент|Тип данных|Описание|По умолчанию|
|--|--|--|--|
|$polls|array\|string|Ссылка опрос или массив|обязательно


Пример:

```php
$this->sendPoll('175343153_456239018');
```

___
### 4.9. sendMarket(arrray|string $items, int $peerId = null):void

Отправить товар(ы), не используя метод attachments. По тому же правилу, что и sendPhoto.

|Аргумент|Тип данных|Описание|По умолчанию|
|--|--|--|--|
|$items|array\|string|Ссылка товар или массив|обязательно


Пример:

```php
$this->sendMarket('175343153_456239018');
```

