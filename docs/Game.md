# Game

| Game              | Info                 | 
| ----------------- | -------------------- |
|  Levels           | 5 - ...n             | 
|  Types            | NORMAL / FIGURED     | 
|  Roles            | SIMPLE / PREMIUM     | 
|  Languages        | en, ru, ...n         | 

### Commands

Used to create a new player with SIMPLE role:

```
php bin/console game:create-player test 1q2w3e4r
```
Used to create a new player with PREMIUM role:

```
php bin/console game:create-player test 1q2w3e4r --role=ROLE_PREMIUM
```

### Web Url

| Path         | Method | Scheme | Grant |
| ------------ | -------| ------ | ----- |
| /game/play   | GET    | ANY    | ALL   |
| /game/login  | GET    | ANY    | ALL   |

## Author
[Dykyi Roman](https://www.linkedin.com/in/roman-dykyi-43428543/), e-mail: [mr.dukuy@gmail.com](mailto:mr.dukuy@gmail.com)
