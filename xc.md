# Welcome to your beautiful project
#### Project based on anod framework

You can use this document as a readme, but as you can see, there is information for run some commands to start your project.

You can write them manually, or, you can install the "xc" tool.
https://xcfile.dev/getting-started/#installation

## Tasks

### upTraefik
Starts traefik
```sh
docker network create traefik-net || true
docker run --rm --privileged --network traefik-net --name=traefik-main -d -p 8080:8080 -p 80:80 -v /var/run/docker.sock:/var/run/docker.sock traefik:v3.1.2 --api.insecure=true --providers.docker=true --entrypoints.web.address=:80
```

### downTraefik
Stops traefik
```sh
docker network rm traefik-net || true
docker stop traefik-main
```

### up
Starts the project
```sh
docker compose up -d --remove-orphans
```

### down
Stops the project
```sh
docker compose down
```

### restart
Restarts the project
```sh
docker compose down
docker compose up -d --remove-orphans
```

### logs
Shows the logs
```sh
docker compose logs -f
```

### bash
Enters the shell
interactive: true
```sh
docker compose exec -it http bash -c "cd /var/www/php && bash -l -c bash"
```

### debug
Enters the shell with xdebug
interactive: true
```sh
docker compose exec -it -e XDEBUG_SESSION=PHPSTORM -e XDEBUG_MODE=debug http bash -c "cd /var/www/php && bash -l -c bash"
```