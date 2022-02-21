<?php

namespace App\Tests\Extension;

use DAMA\DoctrineTestBundle\PHPUnit\PHPUnitExtension;
use PHPUnit\Runner\AfterLastTestHook;
use PHPUnit\Runner\AfterTestHook;
use PHPUnit\Runner\BeforeFirstTestHook;
use PHPUnit\Runner\BeforeTestHook;

/**
 * Allows to disable automatic transaction rollback after test is executed.
 * 
 * Usage example 1: You want to execute a series of inter-dependant tests
 * You must call CustomDamaExtension::CustomDamaExtension::setManualOperationsEnabled(true) before the end of the first test,
 * and CustomDamaExtension::CustomDamaExtension::setManualOperationsEnabled(false) before the end of the last test
 * 
 * Usage example 2: You have a class dedicated to a test scenario (with all tests inter-dependant)
 * You must use setUpBeforeClass() and tearDownAfterClass():
 * 
 * public static function setUpBeforeClass(): void
 *  {
 *      CustomDamaExtension::setManualOperationsEnabled(true);
 *      StaticDriver::beginTransaction();
 *  }
 *
 *  public static function tearDownAfterClass(): void
 *  {
 *      StaticDriver::rollBack();
 *      CustomDamaExtension::setManualOperationsEnabled(false);
 *  }
 */
class CustomDamaExtension extends PHPUnitExtension implements BeforeFirstTestHook, AfterLastTestHook, BeforeTestHook, AfterTestHook
{
    private static bool $isManualOperationsEnabled = false;

    /**
     * Get the value of isManualOperationsEnabled
     *
     * @return bool
     */
    public static function isManualOperationsEnabled(): bool
    {
        return self::$isManualOperationsEnabled;
    }

    /**
     * Set the value of isManualOperationsEnabled
     *
     * @param bool $isManualOperationsEnabled
     */
    public static function setManualOperationsEnabled(bool $isManualOperationsEnabled)
    {
        self::$isManualOperationsEnabled = $isManualOperationsEnabled;
    }

    public function executeBeforeTest(string $test): void
    {
        if (!self::isManualOperationsEnabled()) {
            parent::executeBeforeTest($test);
        }
    }

    public function executeAfterTest(string $test, float $time): void
    {
        if (!self::isManualOperationsEnabled()) {
            parent::executeAfterTest($test, $time);
        }
    }
}
