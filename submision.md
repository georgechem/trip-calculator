To start testing:
```bash
composer run test
```
```
1. updated necessary packages to lastest version
- app.php required modifications because of breaking changes
```
```php
// inserted
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();
// --------
//removed
(new Dotenv\Dotenv(__DIR__.'/../'))->load();
// --------
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

I used Abstract Class for Scenarios as think that is a good fit in this project.
I created ScenarioInterface only to show inheritance and use of interface in action however in this project method 
getPrice() should also go to abstract class Scenario.

Project needs some refactoring, and it is little to much complicated. However, the main idea behind this is to keep 
the highest level of abstraction in CalculatorTest.php and ability to quickly modify internal work of the trip calculator.
Also, when new scenarios appear they should be easily added to existing project.

For scenario B & C the lowest billing period was changed for 1 hour for simplicity.
Limitations of applied constrains in Scenario 3:
- if constrains overlap there is a risk to overcharge customer,
- also order of constrains may matter and give different results.

Probably mistake here as value should be as follows:
- 1h between 7am - 7pm weekdays = 665
- 5h between 7pm - 0am weekdays = 2000
- 4h weekend 0am - 4am weekend = 800 

Total 3465
Friday                              Saturday
[new c('2016-05-13 18:00'), new c('2016-05-14 04:00'), 0, 2400, 0],