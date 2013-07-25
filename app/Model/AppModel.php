<?php
App::uses('Model', 'Model');
class AppModel extends Model {
	var $actsAs = array('Containable');
	var $recursive = -1;
	var $cacheQueries = false;
}