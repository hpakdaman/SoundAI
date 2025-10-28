# SoundAI - Database Design & Architecture

## 📊 Database Structure Overview

All music-related tables use the prefix `music_` for better organization and namespace separation.

---

## 🗄️ Core Tables

### 1. `music_genres`

Stores predefined music genres managed by admins. Users can also input custom genres.

**Columns:**
```
id                  - bigint, primary key, auto increment
name                - string(100), unique, indexed
slug                - string(100), unique, indexed
description         - text, nullable
icon                - string(255), nullable (path to icon/emoji)
prompt_keywords     - text, nullable (keywords to enhance AI prompt)
is_active           - boolean, default true
sort_order          - integer, default 0
created_at          - timestamp
updated_at          - timestamp
```

**Indexes:**
- PRIMARY KEY (`id`)
- UNIQUE (`name`)
- UNIQUE (`slug`)
- INDEX (`is_active`)
- INDEX (`sort_order`)

**Relationships:**
- `hasMany` Compositions

**Examples:**
- Rock, Jazz, Electronic, Classical, Hip-Hop, Country, Blues, Metal, Pop, Reggae, Folk, R&B, Disco, Techno, House, Ambient, Dubstep, Trap, Lo-Fi, Cinematic, Orchestral

---

### 2. `music_vibes`

Stores emotional tones/moods. Users can select multiple vibes or input custom ones.

**Columns:**
```
id                  - bigint, primary key, auto increment
name                - string(100), unique, indexed
slug                - string(100), unique, indexed
description         - text, nullable
color               - string(7), nullable (hex color for UI badges)
prompt_keywords     - text, nullable
is_active           - boolean, default true
sort_order          - integer, default 0
created_at          - timestamp
updated_at          - timestamp
```

**Indexes:**
- PRIMARY KEY (`id`)
- UNIQUE (`name`)
- UNIQUE (`slug`)
- INDEX (`is_active`)
- INDEX (`sort_order`)

**Relationships:**
- `belongsToMany` Compositions (via pivot `music_composition_vibes`)

**Examples:**
- Energetic, Calm, Dark, Happy, Melancholic, Epic, Romantic, Mysterious, Uplifting, Aggressive, Peaceful, Dramatic, Playful, Nostalgic, Triumphant, Somber, Ethereal, Groovy, Intense, Relaxing

---

### 3. `music_instruments`

Stores available instruments. Users can select multiple or input custom instruments.

**Columns:**
```
id                  - bigint, primary key, auto increment
name                - string(100), unique, indexed
slug                - string(100), unique, indexed
category            - enum('keys', 'strings', 'percussion', 'wind', 'electronic', 'vocal', 'other')
description         - text, nullable
icon                - string(255), nullable
prompt_keywords     - text, nullable
is_active           - boolean, default true
sort_order          - integer, default 0
created_at          - timestamp
updated_at          - timestamp
```

**Indexes:**
- PRIMARY KEY (`id`)
- UNIQUE (`name`)
- UNIQUE (`slug`)
- INDEX (`category`)
- INDEX (`is_active`)
- INDEX (`sort_order`)

**Relationships:**
- `belongsToMany` Compositions (via pivot `music_composition_instruments`)

**Examples by Category:**

**Keys:**
- Piano, Organ, Synthesizer, Keyboard, Electric Piano, Harpsichord

**Strings:**
- Guitar, Electric Guitar, Acoustic Guitar, Bass, Violin, Cello, Viola, Harp, Ukulele, Banjo, Mandolin

**Percussion:**
- Drums, Drum Kit, Bongos, Congas, Timpani, Xylophone, Marimba, Cymbals, Tambourine, Shaker

**Wind:**
- Saxophone, Flute, Clarinet, Trumpet, Trombone, French Horn, Tuba, Oboe, Bassoon, Harmonica

**Electronic:**
- Synth Bass, Synth Lead, Synth Pad, 808, Sampler, Drum Machine, Vocoder

**Vocal:**
- Male Vocals, Female Vocals, Choir, Acapella, Harmonies

---

### 4. `music_compositions`

Stores all generated music tracks with metadata and generation parameters.

**Columns:**
```
id                      - bigint, primary key, auto increment
user_id                 - bigint, foreign key to users.id
title                   - string(255), indexed
description             - text, nullable
slug                    - string(255), unique, indexed

-- Genre (predefined or custom)
genre_id                - bigint, foreign key to music_genres.id, nullable
custom_genre            - string(100), nullable, indexed

-- Custom inputs (when user types instead of selecting)
custom_vibe             - string(255), nullable
custom_instruments      - json, nullable (array of custom instrument names)

-- Generation Parameters
tempo                   - integer, nullable (BPM)
duration                - integer, nullable (seconds)
key_signature           - string(20), nullable (e.g., "C Major", "A Minor")
time_signature          - string(10), nullable (e.g., "4/4", "3/4")
style_keywords          - text, nullable (additional user input)

-- AI Generation
full_prompt             - text (exact prompt sent to Vertex AI)
prompt_pattern_used     - string(50), default 'standard'
generation_parameters   - json (all params as JSON for reference)

-- File & Processing
audio_file_path         - string(500), nullable
waveform_data           - json, nullable
file_size               - bigint, nullable (bytes)
file_format             - string(10), nullable (mp3, wav, etc.)

-- Status & Results
status                  - enum('pending', 'processing', 'completed', 'failed'), default 'pending', indexed
error_message           - text, nullable
processing_time         - integer, nullable (milliseconds)
cost_estimate           - decimal(8,4), nullable

-- Privacy & Engagement
privacy                 - enum('public', 'private', 'unlisted'), default 'public', indexed
featured                - boolean, default false, indexed
play_count              - bigint, default 0
download_count          - bigint, default 0
like_count              - bigint, default 0

-- Metadata
created_at              - timestamp, indexed
updated_at              - timestamp
deleted_at              - timestamp, nullable (soft deletes)
```

**Indexes:**
- PRIMARY KEY (`id`)
- FOREIGN KEY (`user_id`) REFERENCES `users(id)` ON DELETE CASCADE
- FOREIGN KEY (`genre_id`) REFERENCES `music_genres(id)` ON DELETE SET NULL
- UNIQUE (`slug`)
- INDEX (`title`)
- INDEX (`custom_genre`)
- INDEX (`status`)
- INDEX (`privacy`)
- INDEX (`featured`)
- INDEX (`created_at`)
- INDEX (`user_id`, `created_at`)

**Relationships:**
- `belongsTo` User
- `belongsTo` Genre (nullable)
- `belongsToMany` Vibes (via pivot)
- `belongsToMany` Instruments (via pivot)
- `hasMany` GenerationHistory

**Full-text search on:**
- `title`, `description`, `style_keywords`

---

### 5. `music_generation_history`

Tracks every music generation attempt for analytics, debugging, and cost tracking.

**Columns:**
```
id                      - bigint, primary key, auto increment
user_id                 - bigint, foreign key to users.id
composition_id          - bigint, foreign key to music_compositions.id, nullable
full_prompt             - text
prompt_pattern_used     - string(50)
generation_parameters   - json (snapshot of all parameters)
status                  - enum('pending', 'processing', 'completed', 'failed'), indexed
error_message           - text, nullable
api_response            - json, nullable (full Vertex AI response)
processing_time         - integer, nullable (milliseconds)
cost                    - decimal(8,4), nullable
vertex_ai_job_id        - string(255), nullable
created_at              - timestamp, indexed
updated_at              - timestamp
```

**Indexes:**
- PRIMARY KEY (`id`)
- FOREIGN KEY (`user_id`) REFERENCES `users(id)` ON DELETE CASCADE
- FOREIGN KEY (`composition_id`) REFERENCES `music_compositions(id)` ON DELETE SET NULL
- INDEX (`status`)
- INDEX (`created_at`)
- INDEX (`user_id`, `created_at`)

**Relationships:**
- `belongsTo` User
- `belongsTo` Composition (nullable)

---

### 6. `music_composition_vibes` (Pivot Table)

Links compositions to selected predefined vibes (many-to-many).

**Columns:**
```
id                      - bigint, primary key, auto increment
composition_id          - bigint, foreign key to music_compositions.id
vibe_id                 - bigint, foreign key to music_vibes.id
created_at              - timestamp
```

**Indexes:**
- PRIMARY KEY (`id`)
- FOREIGN KEY (`composition_id`) REFERENCES `music_compositions(id)` ON DELETE CASCADE
- FOREIGN KEY (`vibe_id`) REFERENCES `music_vibes(id)` ON DELETE CASCADE
- UNIQUE (`composition_id`, `vibe_id`)
- INDEX (`composition_id`)
- INDEX (`vibe_id`)

---

### 7. `music_composition_instruments` (Pivot Table)

Links compositions to selected predefined instruments (many-to-many).

**Columns:**
```
id                      - bigint, primary key, auto increment
composition_id          - bigint, foreign key to music_compositions.id
instrument_id           - bigint, foreign key to music_instruments.id
created_at              - timestamp
```

**Indexes:**
- PRIMARY KEY (`id`)
- FOREIGN KEY (`composition_id`) REFERENCES `music_compositions(id)` ON DELETE CASCADE
- FOREIGN KEY (`instrument_id`) REFERENCES `music_instruments(id)` ON DELETE CASCADE
- UNIQUE (`composition_id`, `instrument_id`)
- INDEX (`composition_id`)
- INDEX (`instrument_id`)

---

## 🔗 Entity Relationship Diagram

```
users
  ↓ (1:N)
music_compositions ←─┐
  ↓ (1:N)            │
  │                  │
  ├─→ music_genres (N:1, nullable)
  │
  ├─→ music_composition_vibes (N:N) ←─→ music_vibes
  │
  ├─→ music_composition_instruments (N:N) ←─→ music_instruments
  │
  └─→ music_generation_history (1:N)
```

---

## 📝 Data Flow & Logic

### User Generates Music:

**Step 1: User Selects/Inputs**
- Genre: "Jazz" (from dropdown) OR types "Cyberpunk Jazz"
- Vibes: Selects "Calm" + "Romantic" OR types "Ethereal"
- Instruments: Selects "Piano", "Saxophone" OR types "Theremin"
- Tempo: 90 BPM
- Duration: 120 seconds
- Key: C Minor

**Step 2: System Builds Prompt**
```php
$genre = $composition->genre?->name ?? $composition->custom_genre;
$vibes = $composition->vibes->pluck('name')->merge([$composition->custom_vibe])->filter()->implode(', ');
$instruments = $composition->instruments->pluck('name')->merge($composition->custom_instruments ?? [])->filter()->implode(', ');

$prompt = str_replace(
    ['{genre}', '{vibes}', '{instruments}', '{tempo}', '{duration}', '{key}'],
    [$genre, $vibes, $instruments, $tempo, $duration, $key],
    config('music_generation.prompt_patterns.standard')
);
```

**Step 3: Save to Database**
- Insert `music_compositions` record (status: 'pending')
- Insert `music_generation_history` record
- If predefined genre selected: Set `genre_id`
- If custom genre typed: Set `custom_genre`
- Attach selected vibes to pivot table
- Attach selected instruments to pivot table
- Store custom_vibe and custom_instruments if provided

**Step 4: Send to Vertex AI**
- Queue job for processing
- Update status to 'processing'
- Call Vertex AI API
- Store audio file on success
- Update status to 'completed' or 'failed'
- Log everything in `music_generation_history`

---

## 🎨 Admin Analytics Queries

**Most Popular Genres:**
```sql
SELECT g.name, COUNT(c.id) as usage_count
FROM music_genres g
LEFT JOIN music_compositions c ON c.genre_id = g.id
GROUP BY g.id
ORDER BY usage_count DESC;
```

**Most Popular Custom Genres (candidates for promotion):**
```sql
SELECT custom_genre, COUNT(*) as usage_count
FROM music_compositions
WHERE custom_genre IS NOT NULL
GROUP BY custom_genre
ORDER BY usage_count DESC
LIMIT 20;
```

**Most Popular Vibe Combinations:**
```sql
SELECT
    GROUP_CONCAT(v.name ORDER BY v.name) as vibe_combo,
    COUNT(DISTINCT cv.composition_id) as usage_count
FROM music_composition_vibes cv
JOIN music_vibes v ON v.id = cv.vibe_id
GROUP BY cv.composition_id
ORDER BY usage_count DESC;
```

**Success Rate by Prompt Pattern:**
```sql
SELECT
    prompt_pattern_used,
    COUNT(*) as total,
    SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as successful,
    ROUND(SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) * 100.0 / COUNT(*), 2) as success_rate
FROM music_generation_history
GROUP BY prompt_pattern_used;
```

---

## 🚀 Migration Order

1. `music_genres`
2. `music_vibes`
3. `music_instruments`
4. `music_compositions`
5. `music_generation_history`
6. `music_composition_vibes`
7. `music_composition_instruments`

---

## 💾 Storage Estimates

**Per Composition:**
- Audio file: ~2-5 MB (depending on duration/quality)
- Waveform data: ~50 KB
- Database record: ~2 KB
- Total: ~2-5 MB per composition

**For 10,000 compositions:**
- Storage needed: ~20-50 GB

**Recommendation:** Use cloud storage (S3, DigitalOcean Spaces, Google Cloud Storage) with CDN.

---

## 🔒 Important Notes

1. **Soft Deletes:** `music_compositions` uses soft deletes to preserve data for analytics
2. **Cascading:** Deleting a user cascades to their compositions and history
3. **Nullables:** Genre is nullable to support custom genres
4. **Custom Data:** Always store both predefined (via relationships) and custom (via text fields)
5. **Indexing:** Heavy indexes on frequently queried columns (user_id, status, created_at)
6. **JSON Columns:** Used for flexible storage of arrays and complex data
7. **Prefix Convention:** All tables use `music_` prefix for namespace clarity

---

## 📊 Performance Considerations

- Add composite indexes for common query patterns
- Consider partitioning `music_generation_history` by date if it grows large
- Use eager loading for relationships to avoid N+1 queries
- Cache popular genres/vibes/instruments lists
- Use queues for audio processing (never block HTTP requests)
- Store audio files on CDN with appropriate cache headers
