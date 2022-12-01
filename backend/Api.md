## Api requests


#### All posts: GET https://localhost:8000/api/v1/post/?page=2&limit=2

success response: 200

```
{
    "links": {
        "self": "/api/v1/post/?page=2",
        "next": "/api/v1/post/?page=3",
        "last": "/api/v1/post/?page=7"
    },
    "success": true,
    "data": {
        "items": [
            {
                "title": "string",
                "content": "string...",
                "createdAt": "2022-11-29T21:07:04+07:00",
                "rating": 10,
                "id": "string"
            },
            {
                "title": "string",
                "content": "string...",
                "createdAt": "2022-11-29T21:06:57+07:00",
                "rating": 7,
                "id": "string"
            }
        ]
    }
}
```

#### Get post: GET https://localhost:8000/api/v1/post/637f52589a79475971109400

success response: 200

```
{
    "success": true,
    "data": {
        "title": "string",
        "textOverview": "string",
        "image": "string",
        "content": "string",
        "createdAt": "2022-11-29T21:04:30+07:00",
        "rating": 4,
        "id": "637f52589a79475971109400",
        "link": "string"
    }
}
```

negative response: 401
```
{
    "success": false,
    "error": "post not found"
}
```


#### Delete post: DELETE https://localhost:8000/api/v1/post/637f52589a79475971109400
negative response: 204
```
null
```


#### Change post rating: POST https://localhost:8000/api/v1/post/637f52589a79475971109400/rating
body
```
{
    "rating": 7
}
```
success response: 200
```
null
```

body
```
{
    "rating": 100
}
```
negative response: 400
```
{
    "success": false,
    "error": "validation failed",
    "violation": "This value should be less than or equal to 10."
}
```


#### Start news collector: GET https://localhost:8000/api/v1/news/collector/start?delay=3
success response: 200
```
null
```

#### Stop news collector: GET https://localhost:8000/api/v1/news/collector/stop
success response: 200
```
null
```

#### Change news collector delay: POST https://localhost:8000/api/v1/news/collector/delay
body:
```
{
    "delay": 5
}
```

success response: 200
```
null
```

body:
```
{
    "delay": -5
}
```
negative response: 400
```
{
    "success": false,
    "error": "validation failed",
    "violation": "This value should be greater than -1."
}
```
