
### How to parse a news
```
symfony console app:news-parse [sourceNews] --count=[number]
```

#### simple

```
symfony console app:news-parse rbc --count=10
```


# The Fast Track (Backend)

```
symfony new backend --version=6.1 --php=8.1 --docker

symfony composer require symfony/orm-pack

symfony composer require --dev symfony/maker-bundle

symfony composer require symfony/dom-crawler

symfony composer require symfony/css-selector

symfony composer require symfony/http-client

symfony composer require symfony/serializer

symfony composer require symfony/validator

symfony console make:migration

symfony console doctrine:migrations:migrate

symfony composer req doctrine-messenger [removed]

symfony composer require symfony/monolog-bundle

symfony composer require --dev orm-fixtures

symfony composer require --dev fakerphp/faker

```
