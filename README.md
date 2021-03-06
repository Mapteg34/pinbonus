# README #

Проект представляет собой прохождения тестового задания для компании pinbonus

### Постановка задачи ###

Необходимо реализовать страничку
для просмотра рекламных кампаний и объявлений с использованием API: https://vk.com/dev/ads
​
* Страничка авторизации для получения ключа доступа:
    - если ключ доступа уже был получен в результате предыдущей успешной
    авторизации и запомнен в БД, то показывается страничка со списком
    рекламных кабинетов
    - если нет запомненного ключа доступа, то на этой страничке должна
    быть возможность авторизации для получения ключа доступа
* Страничка со списком рекламных кабинетов:
    - показывается имя и фото авторизованного пользователя
    - ссылка “Выйти”, по которой происходит забывание ключа доступа и
    возврат к страничке авторизации
    - показывается список рекл. кабинетов авторизованного пользователя
    - возможность выбора рекл. кабинета кликом по нему с переходом на
    страничку выбранного кабинета
* Страничка кабинета
    - показывается название выбранного кабинета и ссылка “К списку
    кабинетов”, при клике по которой происходит возврат на страничку со
    списком рекл. кабинетов
    - показать список всех рекламных кампаний кабинета
    - возможность выбора рекл. кампании кликом по ней с переходом на
    страничку выбранной кампании
* Страничка кампании
    - показывается название кабинета и название кампании и ссылка “К
    списку кампаний”, при клике по которой происходит возврат на страничку
    со списком рекл. кампаний
    - список объявлений кампании со всеми полями объявления в понятном
    для пользователя виде (пример: https://yadi.sk/i/xh72ZnQP3NnBLr)
    - должна быть возможность удалить объявление (объявление помечается
    как архивное и не показывается на этой страничке)
    - должна быть возможность сохранить и изменить собственное
    примечание к объявлению, не более 100 символов.

Верстка делается максимально просто, чтобы на “красивости” была минимальная трудоемкость.

Если что-то не удается сделать или вы считаете, что выполнение какого-то пункта
имеет большую трудоемкость, не уместную в рамках тестового испытания, просим в
ответе это пояснить/предложить алтернативы.

Задание выполняется на php, желательно (но не обязательно) в рамках
laravel-фреймоворка. В качестве хранилища использовать MySQL. Если не laravel или
MySQL, то просим пояснить ваш выбор.

Задание сдается в виде http-ссылки по которой можно увидеть результат работы в
браузере. Обязательно приложить исходные коды (архив без исходников фреймворка
или ссылку на публичный git-репозиторий) и дамп структуры БД. 

### How do I get set up? ###

Для разворачивания теста необходимо:

1. git clone

2. composer install && nvm use 9 && npm install && npm run prod

3. make up

3. http://_domain_of_your_pc_/

4. за деталями - смотри .env.default

### Готовые ссылки ###

https://github.com/Mapteg34/pinbonus

http://pinbonus.malahov-artem.ru/

### Трудозатраты ###

Суммарно около 10 часов
