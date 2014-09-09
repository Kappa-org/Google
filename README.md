# Kappa\Google

Integration [Google API](https://code.google.com/apis/explorer/) into
[Nette Framework](http://nette.org/) for better work with
[service accounts](https://developers.google.com/accounts/docs/OAuth2ServiceAccount)

## Requirements:
* [Google api client](https://github.com/google/google-api-php-client)
* [Nette\DI](github.com/nette/di)

## Installation:

The best way to install Kappa\Google is using Composer

```shell
$ composer require kappa/doctrine:@dev
```

## Usages

### Configuration:
```yaml
google:
	appName: "Your app name"
	scopes:
		- https://www.googleapis.com/auth/calendar
	clientId: "" # Your client ID
	email: "" # Your client email
	key: "" # path to key.p12 file
```

### In presenter:

```php
class BasePresenter  extends Presenter
{
	/**
	 * @var \Kappa\Google\Accounts\ServiceAccount
	 * @inject
	 */
	public $serviceAccount

	public function actionDefault()
	{
		dump($this->serviceAccount->getClient()) // Returns logged client
		die();
	}

	// ...
}
```