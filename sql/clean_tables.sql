-- clean_tables.sql
-- Google Transit Feed Specification
-- by William Agnew
-- MyMetro Senior Capstone
-- Miami University, Spring 2013

USE gtfs;
DELETE FROM fare_rules;
DELETE FROM fare_attributes;
DELETE FROM stop_times;
DELETE FROM trips;
DELETE FROM shapes;
DELETE FROM frequencies;
DELETE FROM transfers;
DELETE FROM stops;
DELETE FROM routes;
DELETE FROM calendar_dates;
DELETE FROM calendar;
DELETE FROM agency;
DELETE FROM feed_info;
