<?php
require('AppHeaders.php');
include_once('DBConnection.php');
include_once('utils.php');

echo createCheckSum($_POST['str']);