sudo git pull origin ussd_refactor

sudo chown -R $USER:www-data .

sudo chmod -R 775 storage/ bootstrap/cache/

sudo supervisorctl reread

sudo supervisorctl update

sudo supervisorctl start laravel-worker:*

#TODO: Should I use the following in the cron tab instead?
#* * * * * php /path-to-your-project/artisan schedule:run >> /dev/null 2>&1
