#!/usr/bin/env bash

#helper function
log_message()
{
    LOGPREFIX="[$(date '+%Y-%m-%d %H:%M:%S')][provision]"
    MESSAGE=$1
    echo "$LOGPREFIX $MESSAGE"
}

#check for errors
check_errors()
{
    EXITCODE=$1
    if [[ ${EXITCODE} -ne 0 ]]; then
        log_message "ERROR: there were some errors, check the output for details."
        exit 1
    else
        log_message "OK, operation successfully completed."
    fi
}

# update system libs
log_message "INFO, update system libs"
sudo apt-get -y update
check_errors $?
sudo apt-get -y upgrade
check_errors $?

# install common system libs
log_message "INFO, install common system libs"
sudo apt-get install -y mc joe git multitail screen nmap python-pip htop iotop jnettop elinks pydf zip
check_errors $?

# build docker containers if not exist
cd /Docker
if [[ -z $(sudo docker-compose ps -q) ]]; then
  log_message "INFO, build docker containers"
  sudo docker-compose build
  check_errors $?
fi
