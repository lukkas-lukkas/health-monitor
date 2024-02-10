setup:
	cp ./application/.env.example ./application/.env
	docker build . -t image-health-monitor
	docker run --rm -v ./application:/application image-health-monitor composer install
	docker run --rm -v ./application:/application image-health-monitor php artisan key:generate
	make up

up:
	docker-compose up -d