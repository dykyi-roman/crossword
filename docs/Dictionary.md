# Dictionary

### Rest Api

| Path                                             | Method | Scheme | Grant |
| ------------------------------------------------ | -------| ------ | ----- |
| /api/dictionary/languages                        | GET    | ANY    | ALL   |
| /api/dictionary/words/{LANGUAGE}?mask={MASK}     | GET    | ANY    | ALL   |

#### Response formats

* `json`
* `xml`

### Commands

Used to fill a dictionary with the help of a third party API providers:

```
php bin/console dictionary:populate {LANGUAGE-CODE} --{FILE-PATH}
```

Used to fill a dictionary from file:
```
php bin/console dictionary:upload {FILE-PATH} 
```

Collections with words for populate can be found: ``cd /data``

## Author
[Dykyi Roman](https://www.linkedin.com/in/roman-dykyi-43428543/), e-mail: [mr.dukuy@gmail.com](mailto:mr.dukuy@gmail.com)
