<?php
class DemoSchedulerTest extends PHPUnit_Extensions_SeleniumTestCase
{
  protected function setUp()
  {
    $this->setBrowser("*chrome");
    $this->setBrowserUrl("http://www.vaddiodev.com/");
  }

  public function testMyTestCase()
  {
    $this->open("/demos/schedule");
    $this->click("css=#room-selection-4 > input[name=\"room-select\"]");
    $idsSelected = $this->getValue("css=input[name=room_ids]");
    $roomsSelected = $this->getValue("css=input[name=room_names]");
    $roomsSelected = $this->getValue("css=input[name=room_names]");
    $this->click("id=continue-select-room");
    for ($second = 0; ; $second++) {
        if ($second >= 60) $this->fail("timeout");
        try {
            if ($this->isVisible("css=#step2 > h1")) break;
        } catch (Exception $e) {}
        sleep(1);
    }

    //print("Rooms Selected: " + $roomsSelected . "\n");
    $this->click("id=view-calendar-button");
    $this->assertTrue($this->isElementPresent("css=.fancybox-overlay"));
    $this->selectFrame("css=.fancybox-iframe");
    for ($second = 0; ; $second++) {
        if ($second >= 60) $this->fail("timeout");
        try {
            if ($this->isVisible("css=.fc-content .fc-event:last-child .fc-event-inner")) break;
        } catch (Exception $e) {}
        sleep(1);
    }

    $this->assertTrue($this->isVisible("css=.fc-content .fc-event:last-child .fc-event-inner"));
    sleep(1);
    $this->mouseOver("css=.fc-content .fc-event:last-child .fc-event-inner");
    $this->click("css=.fc-content .fc-event:last-child .fc-event-inner");
    for ($second = 0; ; $second++) {
        if ($second >= 60) $this->fail("timeout");
        try {
            if ($this->isVisible("css=.ui-dialog[aria-labelledby=ui-dialog-title-dialog-modal]")) break;
        } catch (Exception $e) {}
        sleep(1);
    }

    $this->assertTrue($this->isVisible("css=.ui-dialog[aria-labelledby=ui-dialog-title-dialog-modal]"));
    //print("CALENDAR DATA = ${calendarData}" . "\n");
    $this->selectFrame("relative=top");
    $this->click("xpath=//button[contains(., 'Ok')]");
    $calendarData = $this->getValue("css=input[name=calendar_data]");
    $startTime = $this->getValue("css=input[name=startTime]");
    $endTime = $this->getValue("css=input[name=endTime]");
    //print("~~~~~~~>   START: " + $startTime + " - END: ${endTime}" . "\n");
    for ($second = 0; ; $second++) {
        if ($second >= 60) $this->fail("timeout");
        try {
            if ($this->isVisible("css=#step3 > h1")) break;
        } catch (Exception $e) {}
        sleep(1);
    }

    $this->assertTrue($this->isVisible("css=#step3 > h1"));
    try {
        $this->assertTrue($this->isVisible("css=#detailStep2 .confirm-box"));
    } catch (PHPUnit_Framework_AssertionFailedError $e) {
        array_push($this->verificationErrors, $e->toString());
    }
    $this->type("id=company", "Test Co. Inc");
    $this->type("id=website", "http://www.test.com");
    $this->type("id=dealer_or_user_name", "Paul (TEST)");
    $this->type("id=contact_name", "Stroot");
    $this->type("id=address", "123 Test Street");
    $this->type("id=address2", "Suite 34");
    $this->type("id=city", "Minneapolis");
    $this->type("id=state", "MN");
    $this->type("id=zip", "55408");
    $this->type("id=phone_office", "555-555-5555");
    $this->type("id=phone_mobile", "666-666-6666");
    $this->type("id=phone_fax", "777-777-7777");
    $this->type("id=comments", "This is a test");
    $this->type("id=email", "");
    $this->click("name=submit");
    $this->assertTrue($this->isVisible("css=div.warning-message"));
    $this->type("id=email", "paul@dancingpaul.com");
   /*
    $this->click("name=submit");
    for ($second = 0; ; $second++) {
        if ($second >= 60) $this->fail("timeout");
        try {
            if ($this->isVisible("css=#step4 > #submitting-form")) break;
        } catch (Exception $e) {}
        sleep(1);
    }

    $this->assertTrue($this->isVisible("css=#step4 > #submitting-form"));
    print("~~~~~~~> SUBMITTING FORM" . "\n");
    for ($second = 0; ; $second++) {
        if ($second >= 60) $this->fail("timeout");
        try {
            if ($this->isVisible("css=#step4 > #form-submit-success")) break;
        } catch (Exception $e) {}
        sleep(1);
    }

    $this->assertTrue($this->isVisible("css=#step4 > #form-submit-success"));
    print("~~~~~~~> SUBMIT SUCCESS" . "\n");
    $this->assertFalse($this->isVisible("css=#step4 > #submitting-form"));
    try {
        $this->assertTrue($this->isVisible("css=#detailStep3 .confirm-box"));
    } catch (PHPUnit_Framework_AssertionFailedError $e) {
        array_push($this->verificationErrors, $e->toString());
    }
    try {
        $this->assertTrue($this->isVisible("css=#detailStep4 .confirm-box"));
    } catch (PHPUnit_Framework_AssertionFailedError $e) {
        array_push($this->verificationErrors, $e->toString());
    }
    try {
        $this->assertTrue($this->isElementPresent("id=thankyou-date"));
    } catch (PHPUnit_Framework_AssertionFailedError $e) {
        array_push($this->verificationErrors, $e->toString());
    }
    $successText = $this->getText("id=thankyou-date");
    try {
        $this->assertTrue($this->isElementPresent("css=#confirmation-rooms-list > li"));
    } catch (PHPUnit_Framework_AssertionFailedError $e) {
        array_push($this->verificationErrors, $e->toString());
    }
    $successRooms = $this->getText("css=#confirmation-rooms-list > li");
	*/
  }
}
?>