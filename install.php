<?php
$this->db->query('ALTER TABLE `'.DB_PREFIX.'user_group` ADD `customer_groups` VARCHAR(255) NOT NULL AFTER `permission`;');
?>