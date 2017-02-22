<?php
/**
 * @namespace
 */
namespace Yandex\Tests;

use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\Test;
use PHPUnit\Framework\TestListener as PHPUnitFrameworkTestListener;
use PHPUnit\Framework\TestSuite;
use PHPUnit\Framework\Warning;

/**
 * @category Yandex
 * @package  Tests
 */
class TestListener implements PHPUnitFrameworkTestListener
{
    /**
     * time of test
     *
     * @var integer
     */
    protected $timeTest = 0;

    /**
     * time of suite
     *
     * @var integer
     */
    protected $timeSuite = 0;

    /**
     * @param Test $test
     * @param Warning $e
     * @param $time
     * @return void
     */
    public function addWarning(Test $test, Warning $e, $time)
    {
        echo "\t[";
        echo $this->colorize("warning", "blue");
        echo "]-";
    }

    /**
     * @param Test $test
     * @param \Exception $e
     * @param $time
     * @return void
     */
    public function addError(Test $test, \Exception $e, $time)
    {
        echo "\t[";
        echo $this->colorize("error", "red");
        echo "]-";
    }

    /**
     * @param Test $test
     * @param AssertionFailedError $e
     * @param $time
     * @return void
     */
    public function addFailure(Test $test, AssertionFailedError $e, $time)
    {
        echo "\t[";
        echo $this->colorize("failed", "red");
        echo "]-";
    }

    /**
     * @param Test $test
     * @param \Exception $e
     * @param $time
     * @return void
     */
    public function addIncompleteTest(Test $test, \Exception $e, $time)
    {
        echo "\t\t[";
        echo $this->colorize("incomplete");
        echo "]-";
    }

    /**
     * @param Test $test
     * @param \Exception $e
     * @param $time
     * @return void
     */
    public function addSkippedTest(Test $test, \Exception $e, $time)
    {
        echo "\t[";
        echo $this->colorize("skipped");
        echo "]-";
    }

    /**
     * Risky test.
     *
     * @param Test $test
     * @param \Exception $e
     * @param float $time
     *
     * @return void
     *
     * @since  Method available since Release 4.0.0
     */
    public function addRiskyTest(Test $test, \Exception $e, $time)
    {
        echo "\t[";
        echo $this->colorize("risky");
        echo "]-";
    }

    /**
     * @param Test $test
     * @return void
     */
    public function startTest(Test $test)
    {
        $this->timeTest = microtime(1);
        $method = $this->colorize($test->getName(), 'green');

        echo "\n\t-> " . $method;
    }

    /**
     * @param Test $test
     * @param $time
     * @return void
     */
    public function endTest(Test $test, $time)
    {
        $time = sprintf('%0.3f sec', microtime(1) - $this->timeTest);

        echo "\t\t" . $test->getCount() . '(Assertions)';
        echo $this->colorize("\t" . $time, 'green');
    }

    /**
     * @param TestSuite $suite
     * @return void
     */
    public function startTestSuite(TestSuite $suite)
    {
        $this->timeSuite = microtime(1);
        echo "\n\n" . $this->colorize($suite->getName(), 'blue');
    }

    /**
     * @param TestSuite $suite
     * @return void
     */
    public function endTestSuite(TestSuite $suite)
    {
        $time = sprintf('%0.3f sec', microtime(1) - $this->timeSuite);

        echo $this->colorize("\nTime: " . $time, 'green');
    }

    /**
     * @param $text
     * @param string $color
     * @return string
     */
    private function colorize($text, $color = 'yellow')
    {
        switch ($color) {
            case 'red':
                $color = "1;31";
                break;
            case 'green':
                $color = "1;32";
                break;
            case 'blue':
                $color = "1;34";
                break;
            case 'white':
                $color = "1;37";
                break;
            default:
                $color = "1;33";
                break;
        }
        return "\033[" . $color . 'm' . $text . "\033[0m";
    }
}
