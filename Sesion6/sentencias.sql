SELECT B1.latitude, B1.longitude, L2.city_name
FROM (SELECT DISTINCT latitude, longitude, geoname_id FROM citiesblocks WHERE network BETWEEN '83.43.1.0/25' AND '83.43.204.0/24') AS B1
JOIN (SELECT city_name, geoname_id FROM citieslocations) AS L2
ON B1.geoname_id = L2.geoname_id