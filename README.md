

#  PHP-VK-BOT

Библиотека для работы с VK-ботами.
Поддерживается работа в беседах.
___

##  Содержание

 1. [TODO](#todo)
 2. [Установка](#%D0%A3%D1%81%D1%82%D0%B0%D0%BD%D0%BE%D0%B2%D0%BA%D0%B0)

___
## TODO
|Дата|Описание релиза |Состояние 
|:--:|--|--|
| 7.02.2019 |Возможность отправлять сообщения.  |**done**
| 7.02.2019 |Обработка команд от пользователей как в беседе так и в личных сообщениях.  |**done**
| 7.02.2019 |Обработка событий. (Покинул беседу, присоединился и т.д.)  |**done**

## Установка
  ``` 
composer require danil005/php-vk-bot:dev-master
 ```

## Обработка команд
### Базовые настройки
Для того, чтобы обработать команды, вам необходимо зайти в папку traits и открыть файл **CommantList.php**.  Создание каждого метода - это и есть команда. Также необходимо создавать методы только строчными буквами.
```
trait CommandList  
{  
	protected function hello()  
    {  
	  $this->sendMessage('Hello!');  
	}
}
 ```
 Теперь, если написать "hello" в чат, бот вам ответит: "Hello!".
 Если не хотите, чтобы метод вызывался при вводе ключевого слова, сделайте таким образом:
 ```
trait CommandList  
{  
	protected function _hello()  
    {  
	  $this->sendMessage('Hello!');  
	}
}
 ```
 Тогда при вызове _hello или hello, метод выполняться не будет.
Если хотите сделать реакцию на предложения, то создайте метод **cList()** в CommandList.
```
protected function cList()  
{  
	  return [  
		 [
		   'text'=>'te',  
		   'method' => '_hello'  
		 ],  
	  ];
}
 ```
<!--stackedit_data:
eyJoaXN0b3J5IjpbMTExMzc0MTgwNSwtODk4MjcxMjQ2LC01MT
M2OTYwNDgsLTc5MDg5MTUwMSwtMTM5ODM1MjY5XX0=
-->