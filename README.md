Adjacency List
==============

Simple implementation with [nestedSortable](http://mjsarfatti.com/sandbox/nestedSortable/) plugin.

How to start?
-------------

- Set database config in ``appliaction/config/database.php``
- Set ``encryption_key`` in ``application/config/config.php``
- Autoload ``database``, ``session``, ``url`` and ``form`` in ``application/config/autoload.php``
- Import ``database.sql`` file to your database

You're ready to go - ``http://localhost/your_project/index.php/al``

CodeIgniter v3 Compatibility
----------------------------

Starting with CodeIgniter 3.0, all class filenames (libraries, drivers, controllers and models) must be named in a Ucfirst-like manner or in other words - they must start with a capital letter. So, you have to rename following files:

    controllers/al.php              => controllers/Al.php
    models/adjacency_list_model.php => models/Adjacency_list_model.php
    libraries/adjacency_list.php    => libraries/Adjacency_list.php

Last thing - please add ``security`` helper to your autoload file.


Screenshots
-----------

![](https://github.com/michalsn/CodeIgniter-Adjacency-List/blob/master/_screenshots/navigation.png)