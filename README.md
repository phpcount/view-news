## Часть Фронтенд
### Создать SPA приложение со следующим функционалом:

1. Вывод новостей с пагинацией ( пагинация по скроллу ), кол-во элементов на странице можно задавать через веб-интерфейс
2. Обновление данных раз в N - секунд, желательно с возможностью изменения времени из веб-интерфейса
3. Выделять новость ( обводка, изменение фона ) при изменении рейтинга. При повышении рейтинга - зеленым, при уменьшении - красным
4. Страница вывода подробной информации о новости
5. Возможность удаления новости на главной странице из списка новостей

### Необходимо использовать Фреймворк Vue >= 2 и сопутствующие библиотеки. Обязательное условие: использовать vuex

## Часть PHP:
  1. Спарсить (программно) первые 15 новостей с rbk.ru (блок "Лента новостей") и вставить в базу данных (составить структуру самому).
  2. Для каждой новости добавить "рейтинг", который заполнить рандомно значениями от 1 до 10.
  3. Сделать API для получения новостей и обновления рейтинга отдельной новости.
  4. Вывести список новостей в формате jsonApi, сократив текст до 200 символов в качестве описания, значение рейтинга и ссылку на полную новость. На полной новости выводить картинку, если есть в новости.
  5. Подумать над оптимизацией нагрузки на приложение и улучшением производительности.
  6. Предусмотреть возможность расширения функционала парсинга для добавления дополнительных новостных ресурсов.

### Необходимо использовать Фреймворк Symfony

### Срок выполнения: неделя.

<br>

# Project setup


## backend

Symfony 6.1

#### need Symfony CLI, composer


### Install
```
cd backend
symfony composer install
```

### Install Docker
```
docker-compose up -d
```

---
### How to parse a news
```
symfony console app:news-parse [sourceNews] --count=[number]
```
#### Command example
```
symfony console app:news-parse rbc --count=10
```
#### Or Fixtures load (for checking)

```
symfony console doctrine:fixtures:load -n
```
---

### Run server
```
symfony serve
```

## frontend

Vue.js 3

```
cd frontend
npm install
```

### Compiles and hot-reloads for development
```
npm run serve
```

### Compiles and minifies for production
```
npm run build
```



## Project setup
```
cd frontend

npm install
```

### Compiles and hot-reloads for development
```
npm run serve
```

### Compiles and minifies for production
```
npm run build
```
