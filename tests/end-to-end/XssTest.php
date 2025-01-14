<?php

declare(strict_types=1);

namespace PhpMyAdmin\Tests\Selenium;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Group;

#[CoversNothing]
class XssTest extends TestBase
{
    /**
     * Create a test database for this test class
     */
    protected static bool $createDatabase = false;

    protected function setUp(): void
    {
        parent::setUp();

        $this->login();
    }

    /**
     * Tests the SQL query tab with a null query
     */
    #[Group('large')]
    public function testQueryTabWithNullValue(): void
    {
        if ($this->isSafari()) {
            self::markTestSkipped('Alerts not supported on Safari browser.');
        }

        $this->waitForElement('partialLinkText', 'SQL')->click();
        $this->waitAjax();

        $this->waitForElement('id', 'querybox');
        $this->byId('button_submit_query')->click();
        self::assertEquals('Missing value in the form!', $this->alertText());
    }
}
