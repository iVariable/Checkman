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

Why?
====

**Objective:** to know a prime cost of a project.

**Prerequisites:**

* You are in charge of a business, which has lots of simultaneously running projects.
* Each project has a team with different members: different specialities, different number of team members in each team.
* Each team member has it's own salary and he can be a part of a different teams on different projects (e.g. frontend developer, qa-engineer). Kinda "part-time" team member. 
* Each project also has it's own expenses apart from employees salaries. E.g. business trips, team certification, new furniture/computers for the team, etc.
* Employees are split into different regions/divisions with their own boss (head of division), who has knowledge of their salaries and project involvement.
* Project can has a team members from different regions/divisions

Prime cost = sum of team members salaries (including correctly calculated part-timed members) + "not-salary" spendings + indirect shared (among all projects) expenses (payment for office rent, for lunches, etc) 

**Question:** How to control all this chaos? ![cry baby](http://static-cdn.jtvnw.net/jtv_user_pictures/chansub-global-emoticon-f6c13c7fc0a5c93d-36x30.png)

**Answer:** Checkman ![wuf wuf](http://static-cdn.jtvnw.net/jtv_user_pictures/chansub-global-emoticon-3b96527b46b1c941-40x30.png)

Installation
====

- Clone repo: ``` git clone git@github.com:iVariable/Checkman.git checkman.local```
- Fill parameters.yml with correct DSN: ``` cd ../../app/config && cp parameters.yml.dist parameters.yml && nano parameters.yml```
- Install backend packages thru [composer](composer|https://getcomposer.org/): ``` cd checkman.local && composer install```
- Install frontent packages with [bower](http://bower.io/): ``` cd web/frontend/ && bower install```
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
