# Sidooh

[sidooh.co.ke](https://sidooh.co.ke)

Built on Laravel 6. Run on App Engine, Cloud Build, Cloud SQL e.t.c.

## Requirements

### Project

- PHP 7.4
- ext-json
- ext-openssl
- ext-intl
- composer

### Tools

- lampp
- cloud_sql_proxy (if you wish to connect to live db)
- gcloud (if you wish to run gcloud commands straight from dev machine)
- docker (if you wish to run on docker)

## Getting Started

- Clone the project
- Run `Composer install`
- Modify env. variables accordingly
- Run `php artisan migrate --seed`
- Run `php artisan serve`
- Voilà! Should be running on port `8000` if all went well.

## Running on Docker

Coming soon

## Running on App Engine

### Requirements

- GCP Project - will hold all required resources
- App Engine - VM to hold our code/app
- Cloud SQL - Will deal with our db
- Cloud Build - For simple CD (Continuous Deployment)
- Cloud APIs

### Steps

#### 1. Create a GCP Project

- Create a project on GCP and enable billing. Billing will be required for appengine to run on flex environment


- Enable APIS
    - Compute Engine API (App Engine and SQL instances)
    - Cloud Build API
    - Cloud SQL Admin API
    - App Engine Admin API
    - Google App Engine Flexible Environment
    - Cloud Deployment Manager V2 API

#### 2. Set up App engine

- Create an App Engine app with flex and other type selected
- Deploy cron job after the first build with the following command on project directory `gcloud app deploy cron.yaml`

#### 3. Set up Cloud SQL

- Create an instance of mysql 8.0, 1vCPU, 3.75 GB Machine, and 10 GB SSD.
- Create a database and take note of the connection string

#### 4. Set up Cloud Build

- In settings enable the `App Engine Admin` and `Service Account User` roles


- Connect to the repository containing code


- Optionally create a sample build trigger and modify as follows:
    - ```
      Name: appengine-cd-trigger (or name of branch-trigger)
      Description: Invokes a build every time code is pushed to appengine-cd branch
      Event: Push to new branch
      Source: Repository connected earlier
      Branch: ^appengine-cd$ (or otherwise)
      Type: Cloud Build file
      Location: Repository (__deployment__/cloudbuild.yaml) 
      ```

- Once all this is done, run the trigger manually for the first time and watch for any errors.

## Debugging

### App Engine

- ssh into the instance on cloud console

```shell
======================
--- APPENGINE DEBUG---
======================

---List containers

sudo docker ps


---Log a container

sudo docker logs <container-name>


---Start shell in container (like a terminal session)

sudo docker exec -it <container-name> /bin/bash

```

### To Note:

Built using PhpStorm IDE

Run 5 terminals as follows:

1. lampp terminal
    - `./lampp.sh`
      used to manage lampp server for local dev, has the following content:
    ```bash
      #!/bin/bash
        
        sudo service mysql stop
        sudo service apache2 stop
        
        #cd /opt/lampp
        #sudo ./manager-linux-x64.run &
        
        # Alternatively
        
        if [ "$1" != "" ]; then
        echo "Stopping lampp"
        sudo /opt/lampp/lampp stop
        else
        echo "Starting lampp"
        sudo /opt/lampp/lampp start
        fi
      ```

2. ngrok terminal
    - `ngrok http 8000`
      used to expose port 8000 for mpesa and africastalking dev

3. remote terminal
    - `ssh drh@104.154.166.69`
      used to ssh into compute engine on GCP

4. cloudsql terminal
    - `./cloud_sql_proxy -instances=sidooh2:europe-west3:sidooh=tcp:3309`
      used to connect to cloud sql instance on GCP. Needs gcloud installed

5. Terminal
    - local terminal for all other commands
