Checkman
=================

Tool for resource management and project budget control.
Under construction and not production ready, yet.

Demo
====

http://budget.codemonkeys.ru

Demo login: Admin

Demo password: Admin

Demo app reinstalls every night, so feel free to play around as you wish :)

Installation
====

- Clone repo: ``` git clone git@github.com:iVariable/Checkman.git checkman.local```
- Install backend packages thru [composer](composer|https://getcomposer.org/): ``` cd checkman.local && composer install```
- Install frontent packages with [bower](http://bower.io/): ``` cd web/frontend/ && bower install```
- Fill parameters.yml with correct DSN: ``` cd ../../app/config && cp parameters.yml.dist parameters.yml && nano parameters.yml```
- Install requirejs: ``` npm install -g requirejs ```
- Run deploy script: ``` cd ../../ && ./redeploy.sh```

Done! Now you have a fully functional copy of Checkman, populated with test data.

If you want to clear all test data, then the easiest way is:

- ``` app/console doctrine:database:drop --force```
- ``` app/console doctrine:database:create```
- ``` app/console doctrine:migrations:migrate```

Changelog
====

More info will be available later