==================
Mini PHP Framework
==================


Introduction
============
This project is a mini PHP framework.
It does not have the pretension to create a new framework to use
but is just a test of knowledge for myself.

Installation
============
This framework needs PHP > 5.6.* as well as composer.
You need to set up a virtualhost in Apache and allow override for it to work.
You finally need SQLite3 for the DB part.

Quick notes
===========
* This framework is a quick MVC framework in PHP.
* This framework is suited for small APIs and accept GET, POST, PUT, DELETE as verbs
* Improvements to do:
  - Better routing management. For now the routing layer only takes care of the URI
  - Cleaner SQLite queries, set up prepared statements.
  - Better management of http status codes.
  - Add a Request object that encapsulates post, put data, etc...
  - Extract the framework part to make a possible vendor installable through composer
