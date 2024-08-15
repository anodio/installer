build:
	podman build -t local/anod-installer:latest .

install:
	mkdir -p installation
	rm -rf installation/php/system
	rm -rf installation/php/vendor
	rm -rf installation/php/composer.lock
	rm -rf installation/php/composer.json
	rm -rf installation/php/.env
	rm -rf installation/php/.gitignore
	rm -rf installation/frock.override.yaml
	rm -rf installation/frock.yaml
	podman run --rm -it -e PROJECT_NAME="anodio" -v $(PWD)/installation:/var/www local/anod-installer:latest /installer/installer-http.php

push:
	podman build -t vladitot/anod-installer:latest .
	podman push vladitot/anod-installer:latest