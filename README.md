CGPBootstrap
============

Collectd Graph Panel with Twitter Bootstrap Style

![Dashboard Screenshot](https://raw2.github.com/dbeuchler/CGPBootstrap/master/misc/Dashboard-Photo.png)


### Install

The first step is to install collectd, rrdtool and git on your server or personal computer.

```sh
$ sudo apt-get update
$ sudo apt-get install rrdtool collectd git
```

Then clone the CGPBootstrap repository to your local webroot:

```sh
$ cd /var/www
$ git clone https://github.com/dbeuchler/CGPBootstrap.git
```

*The webroot can be on another path. Check it for your distribution*

![CPU Detail Screenshot](https://raw2.github.com/dbeuchler/CGPBootstrap/master/misc/CPU-Detail.png)