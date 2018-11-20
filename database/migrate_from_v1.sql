/* IMPORT USERS */
INSERT INTO serieall.users (id, username, user_url, email, password, role, suspended, activated, edito, website, twitter, facebook, created_at, updated_at)
  SELECT
    id,
    login,
    trim(login),
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
  FROM serieall_old.users;

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
  FROM serieall_old.shows;

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
  FROM serieall_old.seasons;

DELETE FROM serieall_old.episodes WHERE id = 31282;

/* IMPORT EPISODES */
INSERT INTO serieall.episodes (id, thetvdb_id, numero, name, name_fr, resume, diffusion_us, diffusion_fr, ba, moyenne, nbnotes, season_id, created_at, updated_at)
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
  FROM serieall_old.episodes;

SELECT * FROM serieall_old.episodes LIMIT 29990,1;