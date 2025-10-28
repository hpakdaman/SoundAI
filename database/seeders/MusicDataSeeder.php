<?php

namespace Database\Seeders;

use App\Models\Music\Genre;
use App\Models\Music\Instrument;
use App\Models\Music\Vibe;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MusicDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->seedGenres();
        $this->seedVibes();
        $this->seedInstruments();
    }

    private function seedGenres(): void
    {
        $genres = [
            ['name' => 'Rock', 'description' => 'Rock music with guitars and drums', 'keywords' => 'electric guitar, drums, energetic, powerful'],
            ['name' => 'Jazz', 'description' => 'Smooth jazz with improvisation', 'keywords' => 'saxophone, piano, smooth, improvised, swing'],
            ['name' => 'Electronic', 'description' => 'Electronic dance music', 'keywords' => 'synthesizer, electronic, digital, beats'],
            ['name' => 'Classical', 'description' => 'Classical orchestral music', 'keywords' => 'orchestra, strings, elegant, timeless'],
            ['name' => 'Hip-Hop', 'description' => 'Hip-hop and rap music', 'keywords' => 'beats, bass, rhythm, urban'],
            ['name' => 'Pop', 'description' => 'Popular mainstream music', 'keywords' => 'catchy, melodic, upbeat, mainstream'],
            ['name' => 'Blues', 'description' => 'Blues with soulful expression', 'keywords' => 'guitar, soulful, emotional, expressive'],
            ['name' => 'Country', 'description' => 'Country and western music', 'keywords' => 'acoustic guitar, storytelling, americana'],
            ['name' => 'Metal', 'description' => 'Heavy metal music', 'keywords' => 'distorted guitar, aggressive, heavy, intense'],
            ['name' => 'Reggae', 'description' => 'Reggae with offbeat rhythm', 'keywords' => 'offbeat, bass, relaxed, caribbean'],
            ['name' => 'Folk', 'description' => 'Traditional folk music', 'keywords' => 'acoustic, traditional, storytelling, organic'],
            ['name' => 'R&B', 'description' => 'Rhythm and blues', 'keywords' => 'smooth, soulful, groovy, vocals'],
            ['name' => 'Funk', 'description' => 'Funky groove music', 'keywords' => 'bass, groove, rhythmic, danceable'],
            ['name' => 'Soul', 'description' => 'Soulful emotional music', 'keywords' => 'vocals, emotional, expressive, heartfelt'],
            ['name' => 'Disco', 'description' => 'Disco dance music', 'keywords' => 'danceable, groovy, upbeat, retro'],
            ['name' => 'Techno', 'description' => 'Techno electronic music', 'keywords' => 'repetitive, electronic, minimal, hypnotic'],
            ['name' => 'House', 'description' => 'House electronic music', 'keywords' => 'four-on-floor, electronic, dance, club'],
            ['name' => 'Ambient', 'description' => 'Atmospheric ambient music', 'keywords' => 'atmospheric, spacious, calming, ethereal'],
            ['name' => 'Dubstep', 'description' => 'Bass-heavy dubstep', 'keywords' => 'wobble bass, heavy, electronic, drops'],
            ['name' => 'Trap', 'description' => 'Trap hip-hop music', 'keywords' => '808, hi-hats, bass, modern'],
            ['name' => 'Lo-Fi', 'description' => 'Lo-fi hip-hop beats', 'keywords' => 'relaxed, jazzy, mellow, chill'],
            ['name' => 'Cinematic', 'description' => 'Epic cinematic music', 'keywords' => 'orchestral, dramatic, epic, emotional'],
            ['name' => 'Orchestral', 'description' => 'Full orchestra music', 'keywords' => 'symphony, grand, classical, majestic'],
            ['name' => 'Indie', 'description' => 'Independent alternative music', 'keywords' => 'alternative, authentic, creative, unique'],
            ['name' => 'Punk', 'description' => 'Punk rock music', 'keywords' => 'fast, aggressive, raw, rebellious'],
            ['name' => 'Grunge', 'description' => 'Grunge rock music', 'keywords' => 'distorted, heavy, alternative, raw'],
            ['name' => 'Gospel', 'description' => 'Gospel spiritual music', 'keywords' => 'choir, uplifting, spiritual, soulful'],
            ['name' => 'Latin', 'description' => 'Latin music styles', 'keywords' => 'percussion, rhythmic, lively, cultural'],
            ['name' => 'Afrobeat', 'description' => 'African-influenced beats', 'keywords' => 'percussion, rhythmic, groovy, african'],
            ['name' => 'K-Pop', 'description' => 'Korean pop music', 'keywords' => 'catchy, energetic, modern, polished'],
        ];

        foreach ($genres as $index => $genre) {
            Genre::create([
                'name' => $genre['name'],
                'slug' => Str::slug($genre['name']),
                'description' => $genre['description'],
                'prompt_keywords' => $genre['keywords'],
                'is_active' => true,
                'sort_order' => $index + 1,
            ]);
        }
    }

    private function seedVibes(): void
    {
        $vibes = [
            ['name' => 'Energetic', 'description' => 'High energy and excitement', 'color' => '#FF6B35', 'keywords' => 'upbeat, fast-paced, dynamic, powerful, vigorous'],
            ['name' => 'Calm', 'description' => 'Peaceful and tranquil', 'color' => '#4ECDC4', 'keywords' => 'peaceful, tranquil, serene, soothing, gentle'],
            ['name' => 'Dark', 'description' => 'Mysterious and brooding', 'color' => '#2D3142', 'keywords' => 'mysterious, brooding, ominous, shadowy, intense'],
            ['name' => 'Happy', 'description' => 'Joyful and uplifting', 'color' => '#FFD93D', 'keywords' => 'joyful, cheerful, bright, positive, uplifting'],
            ['name' => 'Melancholic', 'description' => 'Sad and reflective', 'color' => '#6C5B7B', 'keywords' => 'sad, emotional, reflective, bittersweet, wistful'],
            ['name' => 'Epic', 'description' => 'Grand and powerful', 'color' => '#C84B31', 'keywords' => 'grand, powerful, dramatic, triumphant, majestic'],
            ['name' => 'Romantic', 'description' => 'Loving and tender', 'color' => '#FF69B4', 'keywords' => 'loving, tender, intimate, passionate, warm'],
            ['name' => 'Mysterious', 'description' => 'Enigmatic and intriguing', 'color' => '#5D4E6D', 'keywords' => 'enigmatic, intriguing, cryptic, suspenseful, curious'],
            ['name' => 'Uplifting', 'description' => 'Inspiring and motivating', 'color' => '#F5A623', 'keywords' => 'inspiring, motivating, hopeful, optimistic, positive'],
            ['name' => 'Aggressive', 'description' => 'Intense and forceful', 'color' => '#D32F2F', 'keywords' => 'intense, forceful, angry, fierce, hostile'],
            ['name' => 'Peaceful', 'description' => 'Calm and harmonious', 'color' => '#8BC6EC', 'keywords' => 'calm, harmonious, relaxed, balanced, zen'],
            ['name' => 'Dramatic', 'description' => 'Theatrical and intense', 'color' => '#8E44AD', 'keywords' => 'theatrical, intense, emotional, powerful, expressive'],
            ['name' => 'Playful', 'description' => 'Fun and lighthearted', 'color' => '#FF9FF3', 'keywords' => 'fun, lighthearted, quirky, whimsical, bouncy'],
            ['name' => 'Nostalgic', 'description' => 'Sentimental and reminiscent', 'color' => '#A0826D', 'keywords' => 'sentimental, reminiscent, vintage, wistful, memory'],
            ['name' => 'Triumphant', 'description' => 'Victorious and celebratory', 'color' => '#FFD700', 'keywords' => 'victorious, celebratory, glorious, heroic, winning'],
            ['name' => 'Somber', 'description' => 'Serious and gloomy', 'color' => '#696969', 'keywords' => 'serious, gloomy, heavy, solemn, grave'],
            ['name' => 'Ethereal', 'description' => 'Otherworldly and dreamy', 'color' => '#B0E0E6', 'keywords' => 'otherworldly, dreamy, celestial, floating, heavenly'],
            ['name' => 'Groovy', 'description' => 'Funky and rhythmic', 'color' => '#FF6F61', 'keywords' => 'funky, rhythmic, danceable, smooth, flowing'],
            ['name' => 'Intense', 'description' => 'Powerful and concentrated', 'color' => '#E74C3C', 'keywords' => 'powerful, concentrated, fierce, extreme, focused'],
            ['name' => 'Relaxing', 'description' => 'Stress-free and easy', 'color' => '#98D8C8', 'keywords' => 'stress-free, easy, comfortable, laid-back, mellow'],
            ['name' => 'Suspenseful', 'description' => 'Tense and anticipatory', 'color' => '#34495E', 'keywords' => 'tense, anticipatory, thrilling, edge-of-seat, nervous'],
            ['name' => 'Dreamy', 'description' => 'Soft and imaginary', 'color' => '#D4A5A5', 'keywords' => 'soft, imaginary, surreal, hazy, ambient'],
            ['name' => 'Confident', 'description' => 'Bold and assured', 'color' => '#3498DB', 'keywords' => 'bold, assured, strong, self-assured, determined'],
            ['name' => 'Melancholy', 'description' => 'Gently sad', 'color' => '#9B59B6', 'keywords' => 'gently sad, thoughtful, pensive, introspective'],
            ['name' => 'Futuristic', 'description' => 'Modern and forward-looking', 'color' => '#00D9FF', 'keywords' => 'modern, forward-looking, sci-fi, technological, advanced'],
        ];

        foreach ($vibes as $index => $vibe) {
            Vibe::create([
                'name' => $vibe['name'],
                'slug' => Str::slug($vibe['name']),
                'description' => $vibe['description'],
                'color' => $vibe['color'],
                'prompt_keywords' => $vibe['keywords'],
                'is_active' => true,
                'sort_order' => $index + 1,
            ]);
        }
    }

    private function seedInstruments(): void
    {
        $instruments = [
            // Keys
            ['name' => 'Piano', 'category' => 'keys', 'keywords' => 'acoustic piano, grand piano, keys, melodic', 'sort' => 1],
            ['name' => 'Electric Piano', 'category' => 'keys', 'keywords' => 'rhodes, electric, vintage, warm', 'sort' => 2],
            ['name' => 'Organ', 'category' => 'keys', 'keywords' => 'church organ, hammond, deep, rich', 'sort' => 3],
            ['name' => 'Synthesizer', 'category' => 'keys', 'keywords' => 'synth, electronic, modern, versatile', 'sort' => 4],
            ['name' => 'Keyboard', 'category' => 'keys', 'keywords' => 'digital keyboard, electronic keys', 'sort' => 5],
            ['name' => 'Harpsichord', 'category' => 'keys', 'keywords' => 'baroque, classical, plucked strings', 'sort' => 6],
            ['name' => 'Accordion', 'category' => 'keys', 'keywords' => 'bellows, folk, traditional, expressive', 'sort' => 7],

            // Strings
            ['name' => 'Guitar', 'category' => 'strings', 'keywords' => 'acoustic guitar, strumming, fingerpicking', 'sort' => 10],
            ['name' => 'Electric Guitar', 'category' => 'strings', 'keywords' => 'distorted, amplified, rock, solo', 'sort' => 11],
            ['name' => 'Acoustic Guitar', 'category' => 'strings', 'keywords' => 'unplugged, natural, warm, folk', 'sort' => 12],
            ['name' => 'Bass', 'category' => 'strings', 'keywords' => 'bass guitar, low-end, groove, rhythm', 'sort' => 13],
            ['name' => 'Electric Bass', 'category' => 'strings', 'keywords' => 'bass, funk, groove, low frequencies', 'sort' => 14],
            ['name' => 'Violin', 'category' => 'strings', 'keywords' => 'strings, classical, expressive, high-pitched', 'sort' => 15],
            ['name' => 'Cello', 'category' => 'strings', 'keywords' => 'deep strings, rich, emotional, classical', 'sort' => 16],
            ['name' => 'Viola', 'category' => 'strings', 'keywords' => 'middle strings, warm, orchestral', 'sort' => 17],
            ['name' => 'Double Bass', 'category' => 'strings', 'keywords' => 'upright bass, jazz, orchestral, deep', 'sort' => 18],
            ['name' => 'Harp', 'category' => 'strings', 'keywords' => 'angelic, plucked, ethereal, classical', 'sort' => 19],
            ['name' => 'Ukulele', 'category' => 'strings', 'keywords' => 'tropical, bright, cheerful, small', 'sort' => 20],
            ['name' => 'Banjo', 'category' => 'strings', 'keywords' => 'folk, bluegrass, twangy, country', 'sort' => 21],
            ['name' => 'Mandolin', 'category' => 'strings', 'keywords' => 'folk, bright, quick, traditional', 'sort' => 22],

            // Percussion
            ['name' => 'Drums', 'category' => 'percussion', 'keywords' => 'drum kit, rhythm, beats, backbeat', 'sort' => 30],
            ['name' => 'Drum Kit', 'category' => 'percussion', 'keywords' => 'full kit, rock, pop, complete', 'sort' => 31],
            ['name' => 'Snare Drum', 'category' => 'percussion', 'keywords' => 'sharp, crack, marching, accent', 'sort' => 32],
            ['name' => 'Kick Drum', 'category' => 'percussion', 'keywords' => 'bass drum, thump, low, punch', 'sort' => 33],
            ['name' => 'Cymbals', 'category' => 'percussion', 'keywords' => 'crash, ride, shimmer, metallic', 'sort' => 34],
            ['name' => 'Bongos', 'category' => 'percussion', 'keywords' => 'latin, hand drums, tropical, rhythmic', 'sort' => 35],
            ['name' => 'Congas', 'category' => 'percussion', 'keywords' => 'latin, hand drums, deep, resonant', 'sort' => 36],
            ['name' => 'Timpani', 'category' => 'percussion', 'keywords' => 'orchestral, kettle drums, deep, resonant', 'sort' => 37],
            ['name' => 'Xylophone', 'category' => 'percussion', 'keywords' => 'melodic, wooden, bright, percussive', 'sort' => 38],
            ['name' => 'Marimba', 'category' => 'percussion', 'keywords' => 'wooden, warm, melodic, resonant', 'sort' => 39],
            ['name' => 'Tambourine', 'category' => 'percussion', 'keywords' => 'jingle, shake, accent, bright', 'sort' => 40],

            // Wind
            ['name' => 'Saxophone', 'category' => 'wind', 'keywords' => 'jazzy, smooth, expressive, brass', 'sort' => 50],
            ['name' => 'Flute', 'category' => 'wind', 'keywords' => 'airy, high, light, woodwind', 'sort' => 51],
            ['name' => 'Clarinet', 'category' => 'wind', 'keywords' => 'smooth, woodwind, classical, mellow', 'sort' => 52],
            ['name' => 'Trumpet', 'category' => 'wind', 'keywords' => 'bright, fanfare, brass, powerful', 'sort' => 53],
            ['name' => 'Trombone', 'category' => 'wind', 'keywords' => 'slide, brass, deep, smooth', 'sort' => 54],
            ['name' => 'French Horn', 'category' => 'wind', 'keywords' => 'mellow, brass, warm, orchestral', 'sort' => 55],
            ['name' => 'Harmonica', 'category' => 'wind', 'keywords' => 'blues, folk, breathy, expressive', 'sort' => 56],

            // Electronic
            ['name' => 'Synth Bass', 'category' => 'electronic', 'keywords' => 'electronic bass, deep, modern, punchy', 'sort' => 70],
            ['name' => 'Synth Lead', 'category' => 'electronic', 'keywords' => 'lead synth, melodic, bright, electronic', 'sort' => 71],
            ['name' => 'Synth Pad', 'category' => 'electronic', 'keywords' => 'ambient, atmospheric, sustained, background', 'sort' => 72],
            ['name' => '808', 'category' => 'electronic', 'keywords' => 'drum machine, bass, trap, boom', 'sort' => 73],
            ['name' => 'Drum Machine', 'category' => 'electronic', 'keywords' => 'programmed drums, electronic, precise', 'sort' => 74],

            // Vocal
            ['name' => 'Male Vocals', 'category' => 'vocal', 'keywords' => 'male voice, singing, lead vocals', 'sort' => 80],
            ['name' => 'Female Vocals', 'category' => 'vocal', 'keywords' => 'female voice, singing, lead vocals', 'sort' => 81],
            ['name' => 'Choir', 'category' => 'vocal', 'keywords' => 'chorus, harmony, group vocals, angelic', 'sort' => 82],

            // Other
            ['name' => 'Orchestra', 'category' => 'other', 'keywords' => 'full orchestra, symphonic, grand, complete', 'sort' => 90],
        ];

        foreach ($instruments as $instrument) {
            Instrument::create([
                'name' => $instrument['name'],
                'slug' => Str::slug($instrument['name']),
                'category' => $instrument['category'],
                'prompt_keywords' => $instrument['keywords'],
                'is_active' => true,
                'sort_order' => $instrument['sort'],
            ]);
        }
    }
}
