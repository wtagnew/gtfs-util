-- create_tables.sql
-- Google Transit Feed Specification
-- by William Agnew
-- MyMetro Senior Capstone
-- Miami University, Spring 2013

DROP DATABASE gtfs;
CREATE DATABASE gtfs;
USE gtfs;

CREATE TABLE feed_info(
feed_publisher_name VARCHAR(45),
feed_publisher_url VARCHAR(120) NOT NULL,
feed_lang VARCHAR(45) NOT NULL,
feed_start_date CHAR(8),
feed_end_date CHAR(8),
feed_version VARCHAR(45),
PRIMARY KEY(feed_publisher_name)
);

CREATE TABLE agency(
agency_id VARCHAR(45),
agency_name VARCHAR(45) NOT NULL,
agency_url VARCHAR(140) NOT NULL,
agency_timezone VARCHAR(45) NOT NULL,
agency_lang VARCHAR(45),
agency_phone VARCHAR(20),
agency_fare_url VARCHAR(120),
PRIMARY KEY(agency_id)
);

CREATE TABLE calendar(
service_id VARCHAR(15),
monday CHAR(1) NOT NULL,
tuesday CHAR(1) NOT NULL,
wednesday CHAR(1) NOT NULL,
thursday CHAR(1) NOT NULL,
friday CHAR(1) NOT NULL,
saturday CHAR(1) NOT NULL,
sunday CHAR(1) NOT NULL,
start_date CHAR(8) NOT NULL,
end_date CHAR(8) NOT NULL,
PRIMARY KEY(service_id)
);

CREATE TABLE calendar_dates(
service_id VARCHAR(15),
date CHAR(8) NOT NULL,
exception_type CHAR(1) NOT NULL,
PRIMARY KEY(service_id),
FOREIGN KEY(service_id) REFERENCES calendar(service_id)
);

CREATE TABLE routes(
route_id VARCHAR(10),
agency_id VARCHAR(45) NOT NULL,
route_short_name VARCHAR(45) NOT NULL,
route_long_name VARCHAR(70) NOT NULL,
route_desc VARCHAR(230),
route_type CHAR(1) NOT NULL,
route_url VARCHAR(45),
route_color VARCHAR(6),
route_text_color VARCHAR(6),
PRIMARY KEY(route_id),
FOREIGN KEY(agency_id) REFERENCES agency(agency_id)
);

CREATE TABLE stops(
stop_id VARCHAR(45),
stop_code VARCHAR(45),
stop_name VARCHAR(45) NOT NULL,
stop_desc VARCHAR(45),
stop_lat VARCHAR(45) NOT NULL,
stop_lon VARCHAR(45) NOT NULL,
zone_id VARCHAR(45),
stop_url VARCHAR(120),
location_type CHAR(1),
parent_station CHAR(1),
stop_timezone VARCHAR(45),
wheelchair_boarding CHAR(1),
INDEX(zone_id),
PRIMARY KEY(stop_id)
);

CREATE TABLE transfers(
from_stop_id VARCHAR(45) NOT NULL,
to_stop_id VARCHAR(45) NOT NULL,
transfer_type CHAR(1) NOT NULL,
min_transfer_time INT,
FOREIGN KEY(from_stop_id) REFERENCES stops(stop_id),
FOREIGN KEY(to_stop_id) REFERENCES stops(stop_id)
);

CREATE TABLE shapes(
shape_id VARCHAR(25),
shape_pt_lat VARCHAR(45) NOT NULL,
shape_pt_lon VARCHAR(45) NOT NULL,
shape_pt_sequence INT NOT NULL,
shape_dist_traveled FLOAT
-- PRIMARY KEY(shape_id)
);

CREATE TABLE trips(
route_id VARCHAR(10) NOT NULL,
service_id VARCHAR(15) NOT NULL,
trip_id VARCHAR(45),
trip_headsign VARCHAR(250),
trip_short_name VARCHAR(45),
direction_id CHAR(1),
block_id VARCHAR(45),
shape_id VARCHAR(25),
wheelchair_accessible CHAR(1),
PRIMARY KEY(trip_id),
FOREIGN KEY(route_id) REFERENCES routes(route_id),
FOREIGN KEY(service_id) REFERENCES calendar(service_id)
-- FOREIGN KEY(shape_id) REFERENCES shapes(shape_id)
);

CREATE TABLE frequencies(
trip_id VARCHAR(45) NOT NULL,
start_time CHAR(8) NOT NULL,
end_time CHAR(8) NOT NULL,
headway_secs INT NOT NULL,
exact_times CHAR(1),
PRIMARY KEY(trip_id),
FOREIGN KEY(trip_id) REFERENCES trips(trip_id)
);

CREATE TABLE stop_times(
trip_id VARCHAR(45) NOT NULL,
arrival_time CHAR(8) NOT NULL,
departure_time CHAR(8) NOT NULL,
stop_id VARCHAR(45) NOT NULL,
stop_sequence INT NOT NULL,
stop_headsign VARCHAR(250),
pickup_type CHAR(1),
drop_off_type CHAR(1),
shape_dist_traveled FLOAT,
FOREIGN KEY(trip_id) REFERENCES trips(trip_id),
FOREIGN KEY(stop_id) REFERENCES stops(stop_id)
);

CREATE TABLE fare_attributes(
fare_id VARCHAR(20),
price FLOAT NOT NULL,
currency_type CHAR(3) NOT NULL,
payment_method CHAR(1) NOT NULL,
transfers CHAR(1) NOT NULL,
transfer_duration INT,
PRIMARY KEY(fare_id)
);

CREATE TABLE fare_rules(
fare_id VARCHAR(20) NOT NULL,
route_id VARCHAR(10),
origin_id VARCHAR(45),
destination_id VARCHAR(45),
contains_id VARCHAR(45),
PRIMARY KEY(fare_id),
FOREIGN KEY (fare_id) REFERENCES fare_attributes(fare_id),
FOREIGN KEY (route_id) REFERENCES routes(route_id),
FOREIGN KEY (origin_id) REFERENCES stops(zone_id),
FOREIGN KEY (destination_id) REFERENCES stops(zone_id),
FOREIGN KEY (contains_id) REFERENCES stops(zone_id)
);
