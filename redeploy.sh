#!/bin/sh

app/console doctrine:database:drop -n -q --force
app/console doctrine:database:create -q
app/console doctrine:migrations:migrate -n -q
app/console doctrine:fixtures:load -n -q
#app/console doctrine:fixtures:load --fixtures= "src/Checkman/CheckmanBundle/DataFixtures/Test" -n -q
cd web
node /usr/local/bin/r.js -o frontend/app.build.js > /dev/null
cd ..
app/console assets:install --env=prod --symlink web -q
app/console assetic:dump --env=prod web -q
app/console cache:clear --env=prod -q
#app/console budget:spendings:interval-fix `date -v-2m "+%d.%m.%Y"` -q
app/console budget:spendings:interval-fix `date --date="-2 months" "+%d.%m.%Y"` -q
chmod -R 0777 app/cache/ app/logs/