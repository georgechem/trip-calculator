
```
1. updated necessary packages to lastest version
- app.php required little of modification because of breaking changes
```
```php
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();
//instead
(new Dotenv\Dotenv(__DIR__.'/../'))->load();
```

```
Initiated git repository, added .gitignore
normally .env is excluded from repo as contains sensitive data. That is the case when working with public repository. My team has different approach.
As we store repos on private server where only authorized personel has access usually we version .env with git.
```

Also, added in composer
```json
"classmap": [
            "tests/TestCase.php"
        ]
```
to allow auto-loading classes for test environment

As updated phpunit test to latest version, xml schema become deprecated. Migrated configuration to the new one.

After all those changes environment got ready for development. After running the test got all test failing and no other errors.
