#!/bin/sh

cd web
node /usr/local/bin/r.js -o frontend/app.build.js
cd ..
app/console assets:install --env=prod --symlink web
app/console assetic:dump --env=prod web
app/console cache:clear --env=prod
chmod -R 0777 app/cache/ app/logs/