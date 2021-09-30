# This scripts adds a tmdb_id on shows, seasons, and episodes from a dump of a database migrated with the job AddTMDBID.
# The job was run on a dump of the production database to reduce the time of the final release.
# After the execution of this script, the job must be rerun to add the new tmdb id.
# Import the dump database "base.sql" into the mysql of production with a database name at serieall-base and execute this script.

UPDATE `serieall-base`.shows
SET tmdb_id = null
where tmdb_id = 0;

UPDATE `serieall-base`.seasons
SET tmdb_id = null
where tmdb_id = 0;

UPDATE `serieall-base`.episodes
SET tmdb_id = null
where tmdb_id = 0;

UPDATE serieall.shows as prod, `serieall-base`.shows as dev
SET prod.tmdb_id = dev.tmdb_id
WHERE prod.id = dev.id;

UPDATE serieall.seasons as prod, `serieall-base`.seasons as dev
SET prod.tmdb_id = dev.tmdb_id
WHERE prod.id = dev.id;

UPDATE serieall.episodes as prod, `serieall-base`.episodes as dev
SET prod.tmdb_id = dev.tmdb_id
WHERE prod.id = dev.id;
