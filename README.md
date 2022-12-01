# technical test.

This is the project for the techinical test.

It uses [Ddev](https://ddev.readthedocs.io/) with PHP 8.0, MariaDB 10.4, Drupal 9.4.X.

There is one snapshot of the database with the Drupal installation with some products and the images zipped in the file
media.zip in the root of the project.

## Installation

Use [Ddev](https://ddev.readthedocs.io/) to install the project.

```bash
ddev start
ddev composer install
ddev snapshot restore
ddev drush uli
```