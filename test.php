<?php

require_once("config.php");

class TestSuite
{
  private $_testCases = [];

  public function register($testCaseName, TestCase $testCaseInstance) {
    $this->_testCases[$testCaseName] = $testCaseInstance;
  }

  public function execute() {
    foreach ($this->_testCases as $testCaseName => $testCaseInstance) {
      $result = NULL;
      echo "\n[CASE:{$testCaseName}] Running... ";

      try {
        $result = $testCaseInstance->run();
      } catch (Exception $e) {
        $result = NULL;
      }

      if (!$result) {
        echo "\nFAILED [CASE:{$testCaseName}] ";
        exit(1);
      }

      echo "\nSUCCESS [CASE:{$testCaseName}] ";
      var_export($result);
    }

   exit(0); 
  }
}



abstract class TestCase
{
  private function up() {
    // this code will do the processing before the test is executed. Normally that is for creating the test data in DB, etc.
  }

  private function down() {
    // this code will do the processing after the test is executed. Normally that is for cleaning the test data in DB, etc.
  }

  abstract public function run();

  public function get($url) {
    $req = curl_init($url);
    curl_setopt($req, CURLOPT_RETURNTRANSFER, TRUE);
    $response = curl_exec($req);
    $info = curl_getinfo($req);
    curl_close($req);
    return $response;
  }
}



class TestHomePage extends TestCase
{
  public function run() {
    $page = $this->get(CLIENT_HOST_URL . CLIENT_HOST_PATH_HOME);
    return strpos($page, "Step 1 (current): Initial environment deployment.") !== FALSE;
  }
}

class TestHomePageChanged extends TestCase
{
  public function run() {
    $page = $this->get(CLIENT_HOST_URL . CLIENT_HOST_PATH_HOME);
    return strpos($page, "Step 1 (current): Initial environment deployment.") === FALSE;
  }
}

class TestHomePageActual extends TestCase
{
  public function run() {
    $page = $this->get(CLIENT_HOST_URL . CLIENT_HOST_PATH_HOME);
    return strpos($page, "Step 2 (current): Some minor changes in HTML.") !== FALSE;
  }
}

class TestPostCount extends TestCase
{
  public function run() {
    $page = $this->get(CLIENT_HOST_URL . CLIENT_HOST_PATH_HOME);
    return strpos($page, "Total posts: 0") === FALSE;
  }
}



$testSuite = new TestSuite();
$testHomePage = new TestHomePage();
//$testSuite->register("HomePage", $testHomePage);
$testHomePageChanged = new TestHomePageChanged();
//$testSuite->register("HomePage should be changed", $testHomePageChanged);
$testHomePageActual = new TestHomePageActual();
//$testSuite->register("HomePage should be up to date", $testHomePageActual);
$testPostCount = new TestPostCount();
$testSuite->register("There should be at least 1 post", $testPostCount);
$testSuite->execute();
