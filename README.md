# Introduction

Simply business trips management app.

Services and technologies
- Traefik 3.0 (as routing proxy)
- Api 
  - Apache 2.4 + PHP 8.2 + Symfony 6.3
  - Architecture: Symfony Skeleton + Framework Agnostic + DDD elements
- Mariadb 11

# Project setup & use

## 1. Clone repository

``
git clone git@github.com:Pilsenerek/mindento.git
``

## 2. Prepare environment

### Option 1: Vagrant + Docker

- Install Virtualbox (https://www.virtualbox.org/)
- Install Vagrant (https://www.vagrantup.com/)
- Install Vagrant plugins
````
vagrant plugin install vagrant-vbguest vagrant-hostmanager vagrant-disksize vagrant-docker-compose
````
- Adjust /Vagrant/Vagrantfile (obligatory map sync folders: Api & Docker from host to vm)

````
# edit this line, replace the first path with your workspace windows dir, leave the second path unchanged!
node.vm.synced_folder "F:/DEV/mindento/Api", "/Api"
node.vm.synced_folder "F:/DEV/mindento/Docker", "/Docker"
````
- Run & ensure, that machine is ready and Docker containers are working inside 
````
cd vagrant
vagrant box update
vagrant up
vagrant ssh
````

### Option 2: Only Docker

- Prepare hosts
````
api.mindento.local (obligatory)
proxy.mindento.local (optional)
test.mindento.local (optional)
````
- Ensure that Volume in docker-compose.yml is correctly sync with Api local dir
````
volumes:
  - /Api:/var/www/app/
````

- Build & run containers
````
docker-compose up -d
````

## 3. Prepare application

````
docker-compose exec api bash
composer install
bin/console doctrine:schema:create
bin/console doctrine:fixtures:load -n
````

## 4. Tests

````
docker-compose exec api bash
bin/phpunit
````

## 5. Api

### Endpoints

- http://api.mindento.local/worker/ POST []
- http://api.mindento.local/trip/worker/{int workerId} GET
- http://api.mindento.local/trip/ POST form-data [start string Y-m-d H:i:s, end string Y-m-d H:i:s, country string(2), worker int]
