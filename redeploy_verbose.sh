#!/bin/sh

app/console doctrine:database:drop -n  --force
app/console doctrine:database:create
app/console doctrine:migrations:migrate -n
app/console doctrine:fixtures:load -n
#app/console doctrine:fixtures:load --fixtures= "src/Checkman/CheckmanBundle/DataFixtures/Test" -n
#cd web
#node /usr/local/bin/r.js -o frontend/app.build.js > /dev/null
#cd ..
app/console assets:install --env=prod --symlink web
app/console assetic:dump --env=prod web
app/console cache:clear --env=prod
#app/console budget:spendings:interval-fix `date -v-2m "+%d.%m.%Y"`
app/console budget:spendings:interval-fix `date --date="-2 months" "+%d.%m.%Y"`
chmod -R 0777 app/cache/ app/logs/