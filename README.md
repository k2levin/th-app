th-app (Assignment)
===

[![Build Status](https://travis-ci.org/k2levin/th-app.svg?branch=master)](https://travis-ci.org/k2levin/th-app)

### Tasks:
1. Return a list of top posts ordered by the number of comments. Consume the API endpoints provided
- comments endpoint – https://jsonplaceholder.typicode.com/comments
- View Single Post endpoint – https://jsonplaceholder.typicode.com/posts/{post_id}
- View All Posts endpoint – https://jsonplaceholder.typicode.com/posts
- The API response should have the following fields:
  - post_id
  - post_title
  - post_body
  - total_number_of_comments
  
2. Search API Create an endpoint that allows a user to filter the comments based on all the available fields. Your solution needs to be scalable.
  - comments endpoint – https://jsonplaceholder.typicode.com/comments

***

### Solution, there are 2 APIs:
1. Return a list of top posts ordered by the number of comments.
```
- GET /api/list
```

2. Search API. Create an endpoint that allows a user to filter the comments based on all the available fields.
```
- POST /api/search?field=id&operator=eq&value=2          // id = 2
- POST /api/search?field=id&operator=ne&value=2          // id != 2
- POST /api/search?field=id&operator=gt&value=2          // id > 2
- POST /api/search?field=id&operator=gte&value=2         // id >= 2
- POST /api/search?field=id&operator=lt&value=2          // id < 2
- POST /api/search?field=id&operator=lte&value=2         // id <= 2
- POST /api/search?field=email&operator=like&value=hello // email LIKE *hello*
```

Code Coverage:
- docblock
- unit test
- CI/CD with automatic testing (Travis CI)
