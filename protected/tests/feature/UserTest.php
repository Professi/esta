<?php

include_once __DIR__ . '/FeatureTest.php';

/**
 * @group feature
 */
class UserTest extends FeatureTest
{
    public function testLogin()
    {
        $this->visit('/');

        $this->find('#LoginForm_email')->setValue('admin');
        $this->find('#LoginForm_password')->setValue('admin');
        $this->find('#login-form input[type="submit"]')->press();

        $title = $this->find('h2.text-center');
        $this->assertContains('Elternsprechtagsverwaltung', $title->getText());
    }
    
}
