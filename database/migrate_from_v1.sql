/*
 * DUMP DATABASE WITH THIS COMMAND
 * mysqldump c1serieall2 -p --skip-set-charset --default-character-set=latin1 > dump_db_v2.sql
 * Try to use this for slug urls: LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(TRIM('My String'), ':', ''), ')', ''), '(', ''), ',', ''), '\\', ''), '\/', ''), '\"', ''), '?', ''), '\'', ''), '&', ''), '!', ''), '.', ''), ' ', '-'), '--', '-'), '--', '-')) AS `post_name`
 */

/* IMPORT SLOGANS */
INSERT INTO serieall.slogans(id, message, source, url, created_at, updated_at)
  SELECT id, name, source, url, NOW(), NOW() FROM serieall_restore.slogans;

/* IMPORT USERS
 * Rename old username
 */
INSERT INTO serieall.users (id, username, user_url, email, password, role, suspended, activated, edito, website, twitter, facebook, created_at, updated_at)
  SELECT
    id,
    CASE WHEN id = 760
    THEN 'chloe1'
    WHEN id = 8577
    THEN 'celia1'
    WHEN id = 1902
    THEN 'lo1'
    ELSE
      login
    END,
     CASE WHEN id = 760
    THEN trim('chloe1')
    WHEN id = 760
    THEN trim('celia1')
    WHEN id = 1902
    THEN trim('lo1')
    ELSE
      trim(login)
    END,
    email,
    password,
    role,
    suspended,
    1,
    edito,
    website,
    twitter,
    facebook,
    created,
    created
  FROM serieall_restore.users;

/* IMPORT NATIONALITIES */
INSERT INTO serieall.nationalities(name, nationality_url, created_at, updated_at)
SELECT DISTINCT(nationalite), TRIM(nationalite), NOW(), NOW() FROM serieall_restore.shows;

/* IMPORT SHOWS */
INSERT INTO serieall.shows (id, thetvdb_id, show_url, name, name_fr, synopsis, format, annee, encours, diffusion_us, diffusion_fr, particularite, moyenne, moyenne_redac, nbnotes, taux_erectile, avis_rentree, created_at, updated_at)
  SELECT
    id,
    CASE WHEN tvdb_id = 0
      THEN NULL
    WHEN id = 339
      THEN 353968
    WHEN id = 396
      THEN NULL
    WHEN id = 538
      THEN 82438
    WHEN id = 239
      THEN 142861
    WHEN id = 659
      THEN NULL
    ELSE tvdb_id END,
    CASE WHEN id = 1923
      THEN 'star-trek-discovery2'
    ELSE
      menu
    END,
    name,
    titrefr,
    synopsis,
    format,
    annee,
    encours,
    diffusionus,
    diffusionfr,
    particularite,
    moyenne,
    moyenne_redac,
    nbnotes,
    te_rentree,
    avis_rentree,
    NOW(),
    NOW()
  FROM serieall_restore.shows;

/* IMPORT SEASONS */
INSERT INTO serieall.seasons (id, thetvdb_id, name, ba, moyenne, nbnotes, show_id, created_at, updated_at)
  SELECT
    id,
    tvdb_id,
    name,
    ba,
    moyenne,
    nbnotes,
    show_id,
    NOW(),
    NOW()
  FROM serieall_restore.seasons;

/* IMPORT EPISODES
 * ignore incorect 0000-00-00 date
 */
INSERT IGNORE INTO serieall.episodes (id, thetvdb_id, numero, name, name_fr, resume, diffusion_us, diffusion_fr, ba, moyenne, nbnotes, season_id, created_at, updated_at)
  SELECT
    id,
    tvdb_id,
    numero,
    name,
    titrefr,
    resume,
    diffusionus,
    diffusionfr,
    ba,
    moyenne,
    nbnotes,
    season_id,
    NOW(),
    NOW()
  FROM serieall_restore.episodes;