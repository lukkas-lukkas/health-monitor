setup:
	cp ./application/.env.example ./application/.env
	docker build . -t image-health-monitor
	docker run --rm -v ./application:/application image-health-monitor composer install
	docker run --rm -v ./application:/application image-health-monitor php artisan key:generate
	make up

up:
	docker-compose up -d

migrate:
	make exec php artisan migrate

exec:
	docker exec api-health-monitor $(filter-out $@,$(MAKECMDGOALS))

ifndef quantity
    quantity := 100
endif

ifndef delay
    delay := 1
endif
run-simulator:
	docker exec api-health-monitor php artisan simulator:init --quantity $(quantity) --delay $(delay)

run-analyser:
	docker exec api-health-monitor php artisan anomalies:analyse