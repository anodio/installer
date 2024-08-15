## Anod IO installer

### How to install?

```podman run --rm -it -e PROJECT_NAME="anodio" -v $(PWD)/installation:/var/www local/anod-installer:latest /installer/installer-http.php```

You also can change PROJECT_NAME variable to set the project name.

You also can use docker:

```docker run --rm -it -e PROJECT_NAME="anodio" -v $(PWD)/installation:/var/www local/anod-installer:latest /installer/installer-http.php```