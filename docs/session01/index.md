---
title: Session01
layout: default
---

## Resources

- [PHP: PHP Manual - Manual](https://www.php.net/manual/en/)
- [w3schools PHP Tutorial](https://www.w3schools.com/php/)
- [Learn PHP 8 : Using MySQL, JavaScript, CSS3, and HTML5](http://ez-scv.statsbiblioteket.dk:2048/login?url=https://search.ebscohost.com/login.aspx?direct=true&db=nlebk&AN=2642716&site=ehost-live&ebv=EB&ppid=pp_C1)

### SQLite

- [SQLite Tutorial](https://www.tutorialspoint.com/sqlite)
- [PHP: SQLite3 - Manual](https://www.php.net/manual/en/class.sqlite3.php)

## Exercises

Install Docker 🤯
:   Some of you may have Docker Desktop installed already -- if not, here is the guide: [Install Docker Desktop on Windows](https://docs.docker.com/desktop/windows/install/). One of the prerequisites is that you enable virtualization on your PC. This is done in the BIOS -- here is a bit of help: [Virtual machine Windows 10 tutorial "Enable VM in your Computer BIOS"](https://youtu.be/m7cHUNXB7j4). More general help for getting started can be found here: [WSL 2 with Docker getting started](https://youtu.be/5RQbdMn04Oc).

Create a project
:   Before you can setup the web server you need a directory for your project. One option is to create an empty directory and place your HTML file/s in that directory. Make sure that you have a file with the name `index.html` in the root directory. Another option is to copy the files from the repository [UCNProf/dma_0920_workshop_php/session01](https://github.com/UCNProf/dma_0920_workshop_php/tree/main/session01) (I'm not going to introduce Git and GitHub here, so it is up to you, how you fetch the files 😉).

Install the web server
:   Now that you have a directory for your project, you can install the web server. In this session we will make use of a Docker Image with Apache and PHP. I made a Docker Image that also includes the basic web application from the repo with a SQLite database. Do the following:
    
    1. Open a terminal in the directory for your project.
    2. Download the Docker Image for this session: `> docker pull chrwahl/workshop:2202php01`.
    3. Create a container based on the image:
       - (linux) `> docker run -d -p 80:80 --name phpworkshop -v "$(PWD)":/var/www/html chrwahl/workshop:2202php01`.
       - (PowerShell) `> docker run -d -p 80:80 --name phpworkshop -v ${PWD}:/var/www/html chrwahl/workshop:2202php01`.
       
       If you have something else watching port 80 you can change the port: `-p 81:80`
    4. Open a browser with the URL: `http://localhost` (or if you changed the port: `http://localhost:81`). You should now see your `index.html` file content.

Make the todo app work
:   In the repository [UCNProf/dma_0920_workshop_php/session01](https://github.com/UCNProf/dma_0920_workshop_php/tree/main/session01) you find the basic code for creating a todo app. Copy the files and make the app work (create new todo items and refresh the database).

Extend the todo app
:   Alter the database and modify the form, so that you can add more data to a todo item 🎋. It is up to you to decide *what* data (examples: mark as done, description, category, tags).

Todo item page and update a todo item
:   Make a separate page for displaying and editing a todo item. The page should display a todo item based on a GET request. The URL could look something like this: `/todo/item.php?id=2`. In the PHP code you can access the id from the array `$_GET` (try printing the array using `print_r($GET)`).
    
    1. Make a SQL query that uses the id for getting the data.
    2. Display the data in HTML.
    3. Make a HTML form that has all the data as values.
    4. When the form is submitted (with a POST request 📬), the database should be updated.

Delete todo items
:   You can also implement a button on the todo item page, so that the todo item can be deleted ❌.

    1. Create a HTML form with a button (input element with the value "delete"). It should do a POST request to the todo item page.
    2. In PHP, test if the request is a POST request (and the value is "delete"), if so delete the item in the database and redirect the user to the list page.

## Useful Docker commands

| Command | Description|
|--------------------------------|---------------------------------------------------------------------|
| `docker images`                | List all images                                                     |
| `docker rmi httpd:latest`      | Remove the image "httpd" (after removing containers depending on it)|
| `docker container ls -a`       | List all containers incl. not running                               |
| `docker start simplewebserver` | Start the container "simplewebserver"                               |
| `docker stop simplewebserver`  | Stop the container "simplewebserver"                                |
| `docker rm simplewebserver`    | Remove the container "simplewebserver" (after stopping it)          |