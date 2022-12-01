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
