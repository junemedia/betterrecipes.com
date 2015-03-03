<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('admin', ProjectConfiguration::getEnv(), ProjectConfiguration::isDebugging());
sfContext::createInstance($configuration)->dispatch();