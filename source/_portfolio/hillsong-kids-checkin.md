---
extends: _layouts.portfolio
section: content

title: Hillsong Kids Checkin
date: 2013-2016
sort: 1
---

Created a web application for managing children, in groups during
services. Children is checked in by a parent, gets a badge, printed with
the [Raspberry Pi Printer server for LabelWriter](/2013/05/raspberry-pi-printer-server-for-labelwriter),
and can only be checked out by one of the child\'s parents after the
service.

The application has support for user with different roles and access
levels. Statistics, reports and charts of check in and family data.
Feature rich tools to manage families, children and parents with logs
and history.

The system is currently build on [Laravel 5](https://laravel.com/)
with [Bootstrap 3 less](https://getbootstrap.com/)
and [React](https://facebook.github.io/react/),
running on nginx, php7-fpm with mysql.
Using features of Laravel such as mail sending with
[Mailgun](https://www.mailgun.com/),
local development mail trapping with [mailtrap.io](https://mailtrap.io/),
queue handling with AWS SQS/Redis
and backups to AWS S3.
Exception logging and monitoring with
[DataDog](https://www.datadoghq.com/).
Application and access logging with syslog and
[Papertrail](https://papertrailapp.com/).

![Hillsong Kids Checkin](/media/2015/03/Selection_663.png)
