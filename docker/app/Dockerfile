FROM harbor.zinza.com.vn/gps-tracking/bislog/base

COPY ./docker/app/custom_cfg.ini /usr/local/etc/php/conf.d

COPY . /var/www/html/

COPY ./cron_job.sh /cron_job.sh

RUN chmod +x /cron_job.sh