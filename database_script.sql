-- Create the database (if it doesn't already exist)
CREATE DATABASE IF NOT EXISTS kicper;
USE kicper;


-- Drop all the tables (if they already exist)
DROP TABLE IF EXISTS albums;
DROP TABLE IF EXISTS artists;
DROP TABLE IF EXISTS music_events;
DROP TABLE IF EXISTS genres;
DROP TABLE IF EXISTS password_reset_tokens;
DROP TABLE IF EXISTS users;


-- 1. Table for categories (music genres)
CREATE TABLE genres (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    color VARCHAR(7) DEFAULT '#000000',  -- Hex color code for genre
    icon_url VARCHAR(255)  -- URL for genre icon
);

-- 2. Table for artists (musicians or bands)
CREATE TABLE artists (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,  -- Name of the artist or band
    bio TEXT,  -- Short biography or description of the artist
    birth_date DATE,  -- Birth date of the artist (for individuals) or formation date (for bands)
    death_date DATE NULL,  -- Death date of the artist, if applicable
    genre_id INT,  -- Foreign key referencing the genre of the artist
    image_url VARCHAR(255),  -- URL to the artist or band image
    FOREIGN KEY (genre_id) REFERENCES genres(id) ON DELETE SET NULL
);

-- 3. Table for albums (created by artists)
CREATE TABLE albums (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,  -- Album title
    release_date DATE,  -- Release date of the album
    genre_id INT,  -- Foreign key referencing the genre of the album
    artist_id INT,  -- Foreign key referencing the artist who created the album
    cover_image_url VARCHAR(255),  -- URL to the album cover
    description TEXT,  -- Short description of the album
    FOREIGN KEY (genre_id) REFERENCES genres(id) ON DELETE SET NULL,
    FOREIGN KEY (artist_id) REFERENCES artists(id) ON DELETE CASCADE
);

-- 4. Table for music events (music history events)
CREATE TABLE music_events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,  -- Event name
    description TEXT,  -- Event description
    start_date DATE NOT NULL,  -- Event start date
    end_date DATE,  -- Event end date (can be NULL if it's a one-day event)
    image_url VARCHAR(255),  -- URL for the event illustration
    genre_id INT,  -- Foreign key linking to genre (category)
    FOREIGN KEY (genre_id) REFERENCES genres(id) ON DELETE SET NULL
);

-- 5. Table for users (administrators and readers)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,  -- Username for login
    password VARCHAR(255) NOT NULL,  -- Password hash
    role ENUM('admin', 'reader') DEFAULT 'reader'  -- Role of the user (admin/reader)
);


-- 1. Insert a few genres
INSERT INTO genres (name, description, color, icon_url) VALUES
('Pop', 'A genre characterized by catchy melodies and mainstream appeal.', '#FF4081', '/images/pop.jpg'),
('Folk', 'A genre rooted in cultural traditions with storytelling lyrics.', '#FFD54F', '/images/folk.jpg'),
('Jazz', 'A genre known for its improvisation and complex harmonies.', '#FFEB3B', '/images/jazz.jpg'),
('Rock', 'A genre characterized by a strong beat and the use of electric guitars.', '#4CAF50', '/images/rock.jpg'),
('Hip-Hop', 'A genre focused on rhythm, rhyme, and street culture.', '#FF9800', '/images/hiphop.jpg'),
('Classical', 'A genre relating to the art music of the Western world.', '#3257EF', '/images/classical.jpg');

-- 2. Insert a few artists
INSERT INTO artists (name, bio, birth_date, death_date, genre_id, image_url) VALUES 
-- Pop Artists
('Ed Sheeran', 'English singer-songwriter known for his melodic pop hits.', '1991-02-17', NULL, (SELECT id FROM genres WHERE name='Pop'), '/images/ed_sheeran.jpg'),
('Dua Lipa', 'British singer and songwriter known for her disco-influenced pop.', '1995-08-22', NULL, (SELECT id FROM genres WHERE name='Pop'), '/images/dua_lipa.jpg'),
('Michael Jackson', 'American singer, songwriter, and dancer, known as the King of Pop.', '1958-08-29', '2009-06-25', (SELECT id FROM genres WHERE name='Pop'), '/images/michael_jackson.jpg'),
-- Folk Artists
('Bob Dylan', 'American singer-songwriter known for his influential folk music.', '1941-05-24', NULL, (SELECT id FROM genres WHERE name='Folk'), '/images/bob_dylan.jpg'),
('The Lumineers', 'American folk band known for their hit single "Ho Hey".', '2005-04-25', NULL, (SELECT id FROM genres WHERE name='Folk'), '/images/the_lumineers.jpg'),
-- Jazz Artists
('Miles Davis', 'American jazz trumpeter and composer known for his influential style.', '1926-05-26', '1991-09-28', (SELECT id FROM genres WHERE name='Jazz'), '/images/miles_davis.jpg'),
('John Coltrane', 'American jazz saxophonist and composer known for his innovative work.', '1926-09-23', '1967-07-17', (SELECT id FROM genres WHERE name='Jazz'), '/images/john_coltrane.jpg'),
('Louis Armstrong', 'American trumpeter and singer known for his influential jazz style.', '1901-08-04', '1971-07-06', (SELECT id FROM genres WHERE name='Jazz'), '/images/louis_armstrong.jpg'),
-- Rock Artists
('Led Zeppelin', 'British rock band known for their heavy sound and complex compositions.', '1968-01-01', NULL, (SELECT id FROM genres WHERE name='Rock'), '/images/led_zeppelin.jpg'),
('Nirvana', 'American rock band known for bringing grunge music to mainstream.', '1987-01-01', '1994-04-05', (SELECT id FROM genres WHERE name='Rock'), '/images/nirvana.jpg'),
('Queen', 'British rock band known for their theatrical style and hits like "Bohemian Rhapsody".', '1970-01-01', '1991-11-24', (SELECT id FROM genres WHERE name='Rock'), '/images/queen.jpg'),
-- Hip-Hop Artists
('Kendrick Lamar', 'American rapper known for his profound lyrics and storytelling.', '1987-06-17', NULL, (SELECT id FROM genres WHERE name='Hip-Hop'), '/images/kendrick_lamar.jpg'),
('Nicki Minaj', 'Trinidadian-American rapper known for her dynamic flow and versatility.', '1982-12-08', NULL, (SELECT id FROM genres WHERE name='Hip-Hop'), '/images/nicki_minaj.jpg'),
-- Classical Artists
('Fryderyk Chopin', 'Polish composer and virtuoso pianist of the Romantic period.', '1810-03-01', '1849-10-17', (SELECT id FROM genres WHERE name='Classical'), '/images/fryderyk_chopin.jpg'),
('Claude Debussy', 'French composer, considered the first Impressionist composer', '1862-08-22', '1918-03-25', (SELECT id FROM genres WHERE name='Classical'), '/images/claude_debussy.jpg');

-- 3. Insert a few albums
INSERT INTO albums (title, release_date, genre_id, artist_id, cover_image_url, description) VALUES 
-- Pop Albums
('Divide', '2017-03-03', (SELECT id FROM genres WHERE name='Pop'), (SELECT id FROM artists WHERE name='Ed Sheeran'), '/images/divide_album.jpg', 'Ed Sheeran\'s third studio album with hits like "Shape of You".'),
('Future Nostalgia', '2020-03-27', (SELECT id FROM genres WHERE name='Pop'), (SELECT id FROM artists WHERE name='Dua Lipa'), '/images/future_nostalgia_album.jpg', 'Dua Lipa\'s second studio album known for its disco influences.'),
-- Folk Albums
('Highway 61 Revisited', '1965-08-30', (SELECT id FROM genres WHERE name='Folk'), (SELECT id FROM artists WHERE name='Bob Dylan'), '/images/highway_61_revisited_album.jpg', 'Bob Dylan\'s iconic album featuring "Like a Rolling Stone".'),
('The Lumineers', '2012-04-03', (SELECT id FROM genres WHERE name='Folk'), (SELECT id FROM artists WHERE name='The Lumineers'), '/images/the_lumineers_album.jpg', 'The Lumineers\' self-titled debut album featuring "Ho Hey".'),
-- Jazz Albums
('Kind of Blue', '1959-08-17', (SELECT id FROM genres WHERE name='Jazz'), (SELECT id FROM artists WHERE name='Miles Davis'), '/images/kind_of_blue_album.jpg', 'Miles Davis\'s masterpiece and a landmark jazz album.'),
('A Love Supreme', '1965-01-01', (SELECT id FROM genres WHERE name='Jazz'), (SELECT id FROM artists WHERE name='John Coltrane'), '/images/a_love_supreme_album.jpg', 'A Love Supreme is John Coltrane\'s spiritual suite in jazz.'),
('What a Wonderful World', '1967-10-01', (SELECT id FROM genres WHERE name='Jazz'), (SELECT id FROM artists WHERE name='Louis Armstrong'), '/images/what_a_wonderful_world_album.jpg', 'An iconic album featuring Armstrong’s heartfelt performances.'),
-- Rock Albums
('IV', '1971-11-08', (SELECT id FROM genres WHERE name='Rock'), (SELECT id FROM artists WHERE name='Led Zeppelin'), '/images/iv_album.jpg', 'Led Zeppelin IV features the classic "Stairway to Heaven".'),
('Nevermind', '1991-09-24', (SELECT id FROM genres WHERE name='Rock'), (SELECT id FROM artists WHERE name='Nirvana'), '/images/nevermind_album.jpg', 'Nirvana\'s breakthrough album that brought grunge to the mainstream.'),
('A Night at the Opera', '1975-11-21', (SELECT id FROM genres WHERE name='Rock'), (SELECT id FROM artists WHERE name='Queen'), '/images/a_night_at_the_opera_album.jpg', 'Queen\'s legendary album featuring "Bohemian Rhapsody".'),
-- Hip-Hop Albums
('To Pimp a Butterfly', '2015-03-15', (SELECT id FROM genres WHERE name='Hip-Hop'), (SELECT id FROM artists WHERE name='Kendrick Lamar'), '/images/to_pimp_a_butterfly_album.jpg', 'Kendrick Lamar\'s critically acclaimed album addressing racial issues.'),
('The Pinkprint', '2014-12-12', (SELECT id FROM genres WHERE name='Hip-Hop'), (SELECT id FROM artists WHERE name='Nicki Minaj'), '/images/the_pinkprint_album.jpg', 'Nicki Minaj\'s album featuring personal themes and powerful beats.');

-- 4. Insert a few events
INSERT INTO music_events (name, description, start_date, end_date, image_url, genre_id) VALUES
('Birth of Jazz', 'The genre is widely considered to have originated in New Orleans.', '1895-01-01', '1910-01-01', '/images/birth_of_jazz_event.jpg', (SELECT id FROM genres WHERE name='Jazz')),
('Woodstock Festival', 'A music festival in 1969 that is remembered as one of the most significant events in the history of rock music.', '1969-08-15', '1969-08-17', '/images/woodstock_festival_event.jpg', (SELECT id FROM genres WHERE name='Rock')),
('Rise of Hip-Hop', 'The rise of Hip-Hop culture in the 1970s in New York City.', '1973-01-01', '1986-01-01', '/images/rise_of_hiphop_event.jpg', (SELECT id FROM genres WHERE name='Hip-Hop'));

-- 5. Insert a few users
INSERT INTO users (username, password, role) VALUES
('admin', '$2y$10$svBZ5WgQclRZTWuU1oSCduDIIK4QZdaklOm49IYym4tPA1ZnDF4vK', 'admin'),  -- Replace the hash with a proper hashed password
('reader', 'reader', 'reader');
