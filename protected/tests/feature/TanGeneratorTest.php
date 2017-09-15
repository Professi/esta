<?php

include_once __DIR__ . '/FeatureTest.php';

/**
 * @group feature
 */
class TanGeneratorTest extends FeatureTest
{
    public function testGenerateTanList()
    {
        $this->visit('/');

        $this->find('#LoginForm_email')->setValue('admin');
        $this->find('#LoginForm_password')->setValue('admin');
        $this->find('#login-form input[type="submit"]')->press();

        $this->find('a:contains("TAN")')->click();

        $this->find('#Tan_tan_count')->setValue('5');
        $this->find('input[name="csv"]')->press();
    }
}
