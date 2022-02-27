---
title: Session02
layout: default
---

## Resources

- [PHP: PHP Manual - Manual](https://www.php.net/manual/en/)
- [MySQL Tutorial](https://www.w3schools.com/mysql)
- [REST Introduction](https://www.infoq.com/articles/rest-introduction/)
- [Building RESTful Web Services with PHP 7](http://ez-scv.statsbiblioteket.dk:2048/login?url=https://search.ebscohost.com/login.aspx?direct=true&db=nlebk&AN=1593447&site=ehost-live&ebv=EB&ppid=pp_Cover)

## Exercises

The code for these exercises can be found in the repo at [dma_0920_workshop_php/session02](https://github.com/UCNProf/dma_0920_workshop_php/tree/main/session02).

Finish the `/notes` endpoint
:   As the code is now, you can get all notes, get a note by id and update a note by id. Now we are missing: Create a new note and delete a note by id. And while you are at it: You also need to add the functionality to the front-end JavaScript.

New entity with an endpoint
:   Alter the database with a new entity. The entity should be accessible through the API. Examples: category, tag, comment, user.
    Consider the data structure. Example: "Notes are in a category" or "Notes can have comments". Make the entity accessible with an endpoint that matches your data structure.

    Make the new data visible on the frontend.

The JSON data type
:   One of the new features in MySQL 8.0 is the JSON data type. Now that we are sending JSON fourth and back between client and server this would be a grate opportunity to make use of that data type.

    Alter the database so that notes are stored as JSON. Documentation: [MySQL :: The JSON Data Type](https://dev.mysql.com/doc/refman/8.0/en/json.html).