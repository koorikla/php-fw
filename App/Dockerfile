FROM php:apache-buster
RUN apt-get update \
  && apt-get install -y postgresql postgresql-contrib libpq-dev \
  && apt-get install -y zlib1g-dev libzip-dev sendmail \
  && docker-php-ext-install pgsql 

  

COPY ./www/ /var/www/html/



#For emails
RUN echo "sendmail_path=/usr/sbin/sendmail -t -i" >> /usr/local/etc/php/conf.d/sendmail.ini 
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install zip
RUN sed -i '/#!\/bin\/sh/aservice sendmail restart' /usr/local/bin/docker-php-entrypoint
RUN sed -i '/#!\/bin\/sh/aecho "$(hostname -i)\t$(hostname) $(hostname).localhost" >> /etc/hosts' /usr/local/bin/docker-php-entrypoint
RUN rm -rf /var/lib/apt/lists/*



#Default creds
ENV postgre_host="db-master"
ENV postgre_user="postgres"
ENV postgre_pass="my_password"
ENV postgre_db="my_database"
ENV alerts_email="test@domain.com;"
