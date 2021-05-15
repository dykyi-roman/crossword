# Crossword

Used to build crosswords and store them in the cache. Redis - used as cache storage. 

### Rest Api

| Path                                                    | Method | Scheme | Grant |
| ------------------------------------------------------- | -------| ------ | ----- |
| /api/crossword/construct/{LANGUAGE}/{TYPE}/{WORD-COUNT} | GET    | ANY    | ALL   |
| /api/crossword/languages                                | GET    | ANY    | ALL   |
| /api/crossword/types                                    | GET    | ANY    | ALL   |

#### Response formats

* `json`
* `xml`

### Commands

Used to generate a new crossword:

```
php bin/console crossword:generate {type} {WORD-COUNT} --{LIMIT}
```

## Author
[Dykyi Roman](https://www.linkedin.com/in/roman-dykyi-43428543/), e-mail: [mr.dukuy@gmail.com](mailto:mr.dukuy@gmail.com)
