
INSERT INTO `modules` (`id`, `parent_id`, `module_name`, `module_controller`, `module_action`, `module_icon`, `sort_order`, `status_id`, `added_date`, `added_by`, `added_ip`, `modify_date`, `modify_by`, `modify_ip`) 
VALUES (NULL, '2', 'Purpose Of Updates', 'purpose_of_updates', '', '', '11.00', '1', '2024-07-14 05:09:12', '0', '', '2024-07-13 06:38:45', '', '');

INSERT INTO `module_sections` (`id`, `module_id`, `section_id`, `page_modal`) VALUES (NULL, '72', '1', '1'), (NULL, '72', '2', '1'), (NULL, '72', '3', '1'), (NULL, '72', '4', '1');

CREATE TABLE `purpose_of_updates` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `is_money_mandatory` tinyint NOT NULL,
  `is_fuel_mandatory` tinyint NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

ALTER TABLE `bookings_trip_updates` CHANGE `purpose_of_update` `purpose_of_update_id` INT(11) NOT NULL;
