#!/usr/bin/env bash

#helper function
log_message()
{
    LOGPREFIX="[$(date '+%Y-%m-%d %H:%M:%S')][up]"
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

log_message "INFO, run machine docker containers"
cd /Docker
sudo docker-compose up -d
check_errors $?
