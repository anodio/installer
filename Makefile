build:
	docker build -t local/anod-installer:latest .

install:
	make build
	mkdir -p installation
	rm -rf installation/php/system
	rm -rf installation/php/vendor
	rm -rf installation/php/composer.lock
	rm -rf installation/php/composer.json
	rm -rf installation/php/.env
	rm -rf installation/php/.gitignore
	rm -rf installation/frock.override.yaml
	rm -rf installation/frock.yaml
	docker run --rm -it -e PROJECT_NAME="anodio" -v $(PWD)/installation:/var/www local/anod-installer:latest /installer/installer-http.php

push:
	docker build -t vladitot/anod-installer:latest .
	docker push vladitot/anod-installer:latest