Crossword game
=======

# DDD

Domain-driven design is not a technology or a methodology. 
It is a way of thinking and a set of priorities, aimed at accelerating software projects that have to deal with complicated domains.

On a macro level using DDD concepts like Ubiquitous Language and Bounded Contexts can solve complex perspectives on data in to smaller models and clear data ownership.
Follow practices splitting the source code based on bounded contexts we define a next context:

 * `Crossword`
 * `Dictionary`
 * `Game`

For reducing duplication of code we use a `SharedKernel`, it helps share a common code between context.  
 
# Layered Architecture

To make the code organised each context uses Layered Architecture and each functional area is divided on four layers:

 * `Application`
 * `Doman`
 * `Infrastructure`
 * `UI`

# Dictionary

### Rest Api

| Path                                         | Method  | Scheme | Grant |
| -------------------------------------------  | ------- | ------ | ----- |
| /dictionary/languages                        | GET     | ANY    | ALL   |
| /dictionary/words/{LANGUAGE}/word?mask={MASK}| GET     | ANY    | ALL   |

### Commands

Used to fill a dictionary:

```
php bin/console crossword:dictionary:words-storage-populate {LANGUAGE-CODE}
```

# Crossword

# Game

## Stack

* PHP 8.0
* Symfony 5.2
* Elasticsearch
* RabbitMQ
* Redis
* SQLite
 
## Clean code
* phpunit test coverage
* php-cs-fixer
* psalm
* deptrac

## Author
[Dykyi Roman](https://www.linkedin.com/in/roman-dykyi-43428543/), e-mail: [mr.dukuy@gmail.com](mailto:mr.dukuy@gmail.com)
