# custom-dama-extension
Note: this must be used on top of https://github.com/dmaicher/doctrine-test-bundle

Allows to disable automatic transaction rollback after test is executed.

### Usage example 1: You want to execute a series of inter-dependant tests
You must call CustomDamaExtension::CustomDamaExtension::setManualOperationsEnabled(true) before the end of the first test,
and CustomDamaExtension::CustomDamaExtension::setManualOperationsEnabled(false) before the end of the last test

### Usage example 2: You have a class dedicated to a test scenario (with all tests inter-dependant)
You must use setUpBeforeClass() and tearDownAfterClass():
```
public static function setUpBeforeClass(): void
{
    CustomDamaExtension::setManualOperationsEnabled(true);
    StaticDriver::beginTransaction();
}

public static function tearDownAfterClass(): void
{
    StaticDriver::rollBack();
    CustomDamaExtension::setManualOperationsEnabled(false);
}
```
