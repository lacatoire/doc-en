<p align="center"><a href="https://www.php.net/docs.php" target="_blank">
    <img src="https://www.php.net/images/logos/new-php-logo.svg" alt="PHP" width="140">
</a></p>

<h3 align="center">
  The PHP Manual (English)
</h3>

<p align="center">
  <a href="https://www.php.net/docs.php">Read the manual</a>
  <span> | </span>
  <a href="https://github.com/php/doc-base/blob/master/docs/contributing.md">Contributing</a>
  <span> | </span>
  <a href="https://github.com/php/doc-base/blob/master/docs/overview.md">Documentation pipeline</a>
  <span> | </span>
  <a href="#translations">Translations</a>
</p>

<p align="center">
  <a href="https://github.com/php/doc-en/actions/workflows/integrate.yaml"><img src="https://github.com/php/doc-en/actions/workflows/integrate.yaml/badge.svg" alt="Integrate"></a>
  <a href="https://github.com/php/doc-en/actions/workflows/docbook-cs.yaml"><img src="https://github.com/php/doc-en/actions/workflows/docbook-cs.yaml/badge.svg" alt="DocBook Lint"></a>
</p>

This repository contains the source of the English PHP manual, published on
[php.net](https://www.php.net/docs.php).

Contributing
------------

Please read the
[contribution guidelines](https://github.com/php/doc-base/blob/master/docs/contributing.md)
and the [README file](https://github.com/php/doc-base/blob/master/README.md)
of the [doc-base repository](https://github.com/php/doc-base) before sending a
pull request.

For information related to creating a local setup, see the contribution
guidelines or [this page](https://doc.php.net/tutorial/local-setup.php) on our
documentation website.

Build the documentation locally
-------------------------------

This is not needed for contributing, but it is useful to check how your changes
render.

1. Install [Docker](https://docs.docker.com/get-docker/).
2. Rebuild the documentation with `make`.
3. Open `output/php-chunked-xhtml/` in your browser.

```bash
make
```

If the `doc-base` or `phd` repositories are available in directories adjacent
to this one, they are used for building.

> [!NOTE]
> The Docker image is only built if it does not already exist. To force a
> rebuild, run `make -B build`.

You can also build the `web` version of the documentation with `make php`; the
output is placed in `output/php-web`.

Translations
------------

- [Brazilian Portuguese](https://github.com/php/doc-pt_br) (doc-pt_br)
- [Chinese (Simplified)](https://github.com/php/doc-zh) (doc-zh)
- [French](https://github.com/php/doc-fr) (doc-fr)
- [German](https://github.com/php/doc-de) (doc-de)
- [Italian](https://github.com/php/doc-it) (doc-it)
- [Japanese](https://github.com/php/doc-ja) (doc-ja)
- [Polish](https://github.com/php/doc-pl) (doc-pl)
- [Romanian](https://github.com/php/doc-ro) (doc-ro)
- [Russian](https://github.com/php/doc-ru) (doc-ru)
- [Spanish](https://github.com/php/doc-es) (doc-es)
- [Turkish](https://github.com/php/doc-tr) (doc-tr)
- [Ukrainian](https://github.com/php/doc-uk) (doc-uk)
