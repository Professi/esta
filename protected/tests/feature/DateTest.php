<?php
include_once __DIR__ . '/FeatureTest.php';

/**
 * @group feature
 */
class DateTest extends FeatureTest
{

    public function start()
    {
        parent::start();
        $this->adminLogin();
    }

    public function testCreate()
    {
        $this->visit('/index.php?r=date/create');
        $this->find('#Date_date')->setValue('10.10.2038');
        $this->find('#date_lockAt')->setValue('09.10.2038');
        $this->find('#time_lockAt')->setValue('23:59');
        $this->find('#lockAt_value')->setValue('09.10.2038 23:59');
        $this->find('#Date_begin')->setValue('15:00');
        $this->find('#Date_end')->setValue('17:00');
        $this->find('#Date_durationPerAppointment')->setValue('10');
        $this->find('#Date_title')->setValue('FeatureTestedEST');
        $this->find('#date-form input[type="submit"]')->press();
        $title = $this->find('h2.text-center');
        $this->assertContains('FeatureTestedEST', $title->getText());
        $d = Date::model()->find('title=:title',array(':title'=>'FeatureTestedEST'));
        $d->delete();
        
    }
}
