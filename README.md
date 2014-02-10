calender_table
==============

PHP-Script that returns a month in form of a table

This script helps you when you want to create your own calender.

Usage:
======

You can get data via 2 various methods (both return a json format):

First method: get
=================

http://www.example.com/get_calendar.php?month={month}&year={year}

For instance, when you want to get the table of the date February 2014 then it looks like this:

http://www.example.com/get_calendar.php?month=2&year=2014

If there are no parameters, then the month of the current date is returned.

Second method: post
==============

This method is mostly used in ajax application.

So when you use jQuery as examle, then it looks like this:

$.post("get_calendar.php", {"month" : 2, "year" : 2014}, function(data){
// ...
});
