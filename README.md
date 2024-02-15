# Health Monitor

Application to receive health data from smart devices and use AI to found anomalies.

You can send health data of some activity by an endpoint and get some anomalies find by AI running asynchronously
in another one.

## Components

| Component     | Address               |
|---------------|-----------------------|
| api           | http://localhost:9501 |
| worker        | Background job        |
| Apache kafka  | http://localhost:7002 |
| Mysql         | http://localhost:8080 |

## Get started

### Install

Just clone this repository, run setup and migrations

``` shell
git clone https://github.com/lukkas-lukkas/health-monitor.git
cd health-monitor
make setup
make migrate
```
🚩 **Tip:** If you see an error when try to run the migrations, just wait a second and try again, take container need this time.

## Usage

First of all, you need now that **AI is disabled** by default. And with this you can use the simulator to have some fun
seeing a job sending a lot of data and consuming it on background.

### Enable AI

We use OpenAI API, so to enable it you must have an api-key provided by OpenAI. 

Then set the environment variables `ENABLE_AI=true` and `OPENAI_API_TOKEN=(your-api-key)`

After that restart the containers running:
``` shell
docker-compose down
docker-compose up -d
```

### Sending data
``` curl
curl --location 'http://localhost:9501/api/v1/users/{userID}/health-data' \
--header 'Content-Type: application/json' \
--data '{
    "started_at": "2024-02-09T15:00:30",
    "finished_at": "2024-02-09T16:00:00",
    "avg_bpm": 500,
    "steps_total": 5000
}'
```
| Field               | Description                                      |
|---------------------|--------------------------------------------------|
| userID              | Any string id, you will use it to get the result |
| started_at          | When the activity started                        |
| finished_at         | When the activity finished                       |
| avg_bpm             | Average bit per minute                           |
| steps_total         | Total of steps during the activity               |

### Getting the result
``` curl
curl --location 'http://localhost:9501/api/v1/users/{userID}/health-data'
```
The anomalies can have some seconds to appear, you can check the execution running `docker logs -f worker-health-monitor`

## Simulator

As mentioned, you can run a simulator to see the app sending a lot of random information to be processed.
As long as the AI is disabled.

``` shell
make run-simulator quantity=10 delay=2
```
The parameters quantity and delay are optionals, with 100 and 1 as default respectively.

Now you can check the values on the database table ``health_data`` and the logs of the worker.
