sudo git pull origin ussd_refactor

sudo chown -R $USER:www-data .

sudo chmod -R 775 storage/ bootstrap/cache/

sudo supervisorctl reread

sudo supervisorctl update

sudo supervisorctl start laravel-worker:*
