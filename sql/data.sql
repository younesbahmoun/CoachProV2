-- ==========================================
-- SUPPRIMER ET RECRÉER LA BASE DE DONNÉES
-- ==========================================
DROP DATABASE IF EXISTS coachpro;
CREATE DATABASE coachpro;
USE coachpro;

-- ============================================
-- TABLE: users (Utilisateurs - Coachs et Sportifs)
-- ============================================

CREATE TABLE roles (
    role_id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100)
);

CREATE TABLE users (
    user_id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    adresse VARCHAR(255),
    age TINYINT UNSIGNED NOT NULL,
    phone VARCHAR(20) UNIQUE NOT NULL,
    date_inscription DATETIME DEFAULT CURRENT_TIMESTAMP,
    derniere_connexion DATETIME,
    role_id INT UNSIGNED NOT NULL,
    FOREIGN KEY (role_id) REFERENCES roles(role_id)
);

-- ============================================
-- TABLE: sportifs (Profils des sportifs)
-- ============================================
CREATE TABLE sportifs (
    sportif_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    niveau ENUM('débutant', 'intermédiaire', 'avancé', 'compétiteur') DEFAULT 'débutant',
    photo_profil VARCHAR(255) DEFAULT 'default-sportif.jpg',
    user_id INT UNSIGNED NOT NULL UNIQUE,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- ============================================
-- TABLE: coachs (Profils des coachs)
-- ============================================
CREATE TABLE coachs (
    coach_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    niveau ENUM('débutant', 'intermédiaire', 'avancé', 'expert', 'professionnel') DEFAULT 'débutant',
    annees_experience TINYINT UNSIGNED DEFAULT 0,
    photo VARCHAR(255) DEFAULT 'default-coach.jpg',
    tarif_horaire DECIMAL(10,2),
    note_moyenne DECIMAL(3,2) DEFAULT 0.00,
    nombre_avis INT UNSIGNED DEFAULT 0,
    user_id INT UNSIGNED NOT NULL UNIQUE,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- ============================================
-- TABLE: disciplines (Sports disponibles)
-- ============================================
CREATE TABLE disciplines (
    discipline_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL UNIQUE
);

-- ============================================
-- TABLE: disciplines_sportives (Liaison Coach-Disciplines)
-- ============================================
CREATE TABLE disciplines_sportives (
    discipline_id INT UNSIGNED NOT NULL,
    coach_id INT UNSIGNED NOT NULL,
    PRIMARY KEY (discipline_id, coach_id),
    FOREIGN KEY (discipline_id) REFERENCES disciplines(discipline_id) ON DELETE CASCADE,
    FOREIGN KEY (coach_id) REFERENCES coachs(coach_id) ON DELETE CASCADE
);

-- ============================================
-- TABLE: certifications (Certifications des coachs)
-- ============================================
CREATE TABLE certifications (
    certification_id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(255) NOT NULL,
    date_obtenu DATE NOT NULL,
    coach_id INT UNSIGNED NOT NULL,
    FOREIGN KEY (coach_id) REFERENCES coachs(coach_id) ON DELETE CASCADE
);

-- ============================================
-- TABLE: disponibilites (Créneaux disponibles des coachs)
-- ============================================
CREATE TABLE disponibilites (
    disponibilite_id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    jour_semaine ENUM('lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche') NOT NULL,
    heure_debut TIME NOT NULL,
    heure_fin TIME NOT NULL,
    est_disponible BOOLEAN DEFAULT TRUE,
    coach_id INT UNSIGNED NOT NULL,
    FOREIGN KEY (coach_id) REFERENCES coachs(coach_id) ON DELETE CASCADE
);

-- ============================================
-- TABLE: reservations (Réservations de séances)
-- ============================================
CREATE TABLE reservations (
    reservation_id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    date_seance DATETIME NOT NULL,
    duree_minutes SMALLINT UNSIGNED DEFAULT 60,
    statut ENUM('en_attente', 'acceptée', 'refusée', 'annulée', 'terminée') DEFAULT 'en_attente',
    prix DECIMAL(10,2),
    lieu VARCHAR(255),
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    sportif_id INT UNSIGNED NOT NULL,
    coach_id INT UNSIGNED NOT NULL,
    discipline_id INT UNSIGNED NOT NULL,
    FOREIGN KEY (sportif_id) REFERENCES sportifs(sportif_id) ON DELETE CASCADE,
    FOREIGN KEY (coach_id) REFERENCES coachs(coach_id) ON DELETE CASCADE,
    FOREIGN KEY (discipline_id) REFERENCES disciplines(discipline_id) ON DELETE RESTRICT
);


-- ============================================
-- 1. INSERTION DES RÔLES
-- ============================================
INSERT INTO roles (role_id, nom) VALUES 
(1, 'Admin'),
(2, 'Coach'),
(3, 'Sportif');

-- ============================================
-- 2. INSERTION DES DISCIPLINES
-- ============================================
INSERT INTO disciplines (nom) VALUES 
('Musculation'),
('Cardio'),
('Yoga'),
('Pilates'),
('Crossfit'),
('Boxe'),
('Natation'),
('Préparation physique'),
('Fitness'),
('Running'),
('Stretching'),
('HIIT'),
('Cyclisme'),
('Tennis'),
('Football');

-- ============================================
-- 3. INSERTION DES UTILISATEURS
-- ============================================

-- ADMIN
INSERT INTO users (nom, prenom, email, password_hash, adresse, age, phone, role_id) VALUES 
('Admin', 'Super', 'admin@coachingsport.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Paris 1er', 30, '+33600000000', 1);
-- Password: password

-- COACHS (8 coachs)
INSERT INTO users (nom, prenom, email, password_hash, adresse, age, phone, role_id) VALUES 
('Dupont', 'Jean', 'jean.dupont@coach.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Paris 15ème', 35, '+33601020304', 2),
('Laurent', 'Marie', 'marie.laurent@coach.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Paris 8ème', 32, '+33601020305', 2),
('Martin', 'Thomas', 'thomas.martin@coach.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Paris 12ème', 28, '+33601020306', 2),
('Rousseau', 'Paul', 'paul.rousseau@coach.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Paris 18ème', 40, '+33601020307', 2),
('Petit', 'Laura', 'laura.petit@coach.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Paris 9ème', 29, '+33601020308', 2),
('Bernard', 'Lucas', 'lucas.bernard@coach.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Paris 11ème', 38, '+33601020309', 2),
('Dubois', 'Sophie', 'sophie.dubois@coach.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Paris 5ème', 34, '+33601020310', 2),
('Moreau', 'Alexandre', 'alex.moreau@coach.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Paris 16ème', 42, '+33601020311', 2);

-- SPORTIFS (15 sportifs)
INSERT INTO users (nom, prenom, email, password_hash, adresse, age, phone, role_id) VALUES 
('Martin', 'Sophie', 'sophie.martin@sport.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Paris 10ème', 25, '+33602030405', 3),
('Leblanc', 'Marc', 'marc.leblanc@sport.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Paris 14ème', 30, '+33602030406', 3),
('Petit', 'Julie', 'julie.petit@sport.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Paris 7ème', 22, '+33602030407', 3),
('Dubois', 'Laura', 'laura.dubois@sport.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Paris 13ème', 27, '+33602030408', 3),
('Moreau', 'Pierre', 'pierre.moreau@sport.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Paris 17ème', 33, '+33602030409', 3),
('Bernard', 'Emma', 'emma.bernard@sport.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Paris 6ème', 24, '+33602030410', 3),
('Roux', 'Nicolas', 'nicolas.roux@sport.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Paris 19ème', 28, '+33602030411', 3),
('Fournier', 'Camille', 'camille.fournier@sport.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Paris 3ème', 26, '+33602030412', 3),
('Girard', 'Julien', 'julien.girard@sport.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Paris 20ème', 31, '+33602030413', 3),
('Bonnet', 'Léa', 'lea.bonnet@sport.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Paris 4ème', 23, '+33602030414', 3),
('Lambert', 'Maxime', 'maxime.lambert@sport.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Paris 2ème', 29, '+33602030415', 3),
('Fontaine', 'Chloé', 'chloe.fontaine@sport.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Paris 11ème', 25, '+33602030416', 3),
('Chevalier', 'Hugo', 'hugo.chevalier@sport.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Paris 15ème', 32, '+33602030417', 3),
('Garnier', 'Manon', 'manon.garnier@sport.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Paris 8ème', 21, '+33602030418', 3),
('Faure', 'Thomas', 'thomas.faure@sport.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Paris 12ème', 27, '+33602030419', 3);

-- ============================================
-- 4. INSERTION DES PROFILS COACHS
-- ============================================
INSERT INTO coachs (user_id, niveau, annees_experience, tarif_horaire, note_moyenne, nombre_avis) VALUES 
(2, 'expert', 12, 45.00, 4.80, 156),          -- Jean Dupont
(3, 'professionnel', 8, 40.00, 5.00, 203),    -- Marie Laurent
(4, 'avancé', 5, 38.00, 4.50, 89),            -- Thomas Martin
(5, 'expert', 10, 42.00, 4.60, 124),          -- Paul Rousseau
(6, 'professionnel', 7, 40.00, 4.90, 178),    -- Laura Petit
(7, 'expert', 15, 50.00, 4.70, 201),          -- Lucas Bernard
(8, 'avancé', 6, 35.00, 4.40, 67),            -- Sophie Dubois
(9, 'professionnel', 18, 55.00, 4.85, 245);   -- Alexandre Moreau

-- ============================================
-- 5. INSERTION DES PROFILS SPORTIFS
-- ============================================
INSERT INTO sportifs (user_id, niveau) VALUES 
(10, 'intermédiaire'),    -- Sophie Martin
(11, 'avancé'),           -- Marc Leblanc
(12, 'débutant'),         -- Julie Petit
(13, 'débutant'),         -- Laura Dubois
(14, 'intermédiaire'),    -- Pierre Moreau
(15, 'avancé'),           -- Emma Bernard
(16, 'intermédiaire'),    -- Nicolas Roux
(17, 'débutant'),         -- Camille Fournier
(18, 'avancé'),           -- Julien Girard
(19, 'débutant'),         -- Léa Bonnet
(20, 'intermédiaire'),    -- Maxime Lambert
(21, 'débutant'),         -- Chloé Fontaine
(22, 'compétiteur'),      -- Hugo Chevalier
(23, 'débutant'),         -- Manon Garnier
(24, 'intermédiaire');    -- Thomas Faure

-- ============================================
-- 6. LIAISON COACHS-DISCIPLINES
-- ============================================
-- Jean Dupont (coach_id: 1) - Musculation, Fitness, Préparation physique, Cardio
INSERT INTO disciplines_sportives (coach_id, discipline_id) VALUES 
(1, 1), (1, 9), (1, 8), (1, 2);

-- Marie Laurent (coach_id: 2) - Yoga, Pilates, Stretching
INSERT INTO disciplines_sportives (coach_id, discipline_id) VALUES 
(2, 3), (2, 4), (2, 11);

-- Thomas Martin (coach_id: 3) - Crossfit, Cardio, HIIT
INSERT INTO disciplines_sportives (coach_id, discipline_id) VALUES 
(3, 5), (3, 2), (3, 12);

-- Paul Rousseau (coach_id: 4) - Cardio, Running, Fitness
INSERT INTO disciplines_sportives (coach_id, discipline_id) VALUES 
(4, 2), (4, 10), (4, 9);

-- Laura Petit (coach_id: 5) - Pilates, Stretching, Yoga, Fitness
INSERT INTO disciplines_sportives (coach_id, discipline_id) VALUES 
(5, 4), (5, 11), (5, 3), (5, 9);

-- Lucas Bernard (coach_id: 6) - Boxe, Préparation physique, Musculation
INSERT INTO disciplines_sportives (coach_id, discipline_id) VALUES 
(6, 6), (6, 8), (6, 1);

-- Sophie Dubois (coach_id: 7) - Natation, Cardio, Fitness
INSERT INTO disciplines_sportives (coach_id, discipline_id) VALUES 
(7, 7), (7, 2), (7, 9);

-- Alexandre Moreau (coach_id: 8) - Musculation, Crossfit, HIIT, Préparation physique
INSERT INTO disciplines_sportives (coach_id, discipline_id) VALUES 
(8, 1), (8, 5), (8, 12), (8, 8);

-- ============================================
-- 7. CERTIFICATIONS DES COACHS
-- ============================================
INSERT INTO certifications (coach_id, nom, date_obtenu) VALUES 
-- Jean Dupont
(1, 'BPJEPS AGFF - Brevet Professionnel de la Jeunesse', '2012-06-15'),
(1, 'CQP Instructeur Fitness', '2014-03-20'),
(1, 'Formation Nutrition Sportive', '2018-09-10'),

-- Marie Laurent
(2, 'Certification Yoga Alliance RYT 500', '2016-05-12'),
(2, 'Formation Pilates Matwork', '2015-02-20'),
(2, 'Diplôme Instructeur Stretching', '2017-11-05'),

-- Thomas Martin
(3, 'Crossfit Level 1 Trainer', '2019-08-15'),
(3, 'HIIT Specialist Certification', '2020-01-22'),

-- Paul Rousseau
(4, 'Coach Sportif Diplômé d\'État', '2013-07-10'),
(4, 'Formation Course à Pied', '2015-04-18'),

-- Laura Petit
(5, 'Pilates Comprehensive Certification', '2017-09-25'),
(5, 'Yoga Teacher Training 200h', '2016-06-30'),

-- Lucas Bernard
(6, 'Brevet d\'État Boxe Française', '2008-12-15'),
(6, 'Préparateur Physique Professionnel', '2010-05-20'),
(6, 'Formation Force Athlétique', '2012-09-10'),

-- Sophie Dubois
(7, 'Maître-Nageur Sauveteur', '2017-06-20'),
(7, 'Coach Aquagym', '2018-03-15'),

-- Alexandre Moreau
(8, 'BPJEPS Force', '2005-06-10'),
(8, 'Crossfit Level 2 Trainer', '2015-11-20'),
(8, 'Préparateur Physique Elite', '2008-09-15');


-- ============================================
-- 8. DISPONIBILITÉS DES COACHS
-- ============================================
-- Jean Dupont (coach_id: 1)
INSERT INTO disponibilites (coach_id, jour_semaine, heure_debut, heure_fin, est_disponible) VALUES 
(1, 'lundi', '09:00:00', '12:00:00', TRUE),
(1, 'lundi', '14:00:00', '19:00:00', TRUE),
(1, 'mardi', '09:00:00', '12:00:00', TRUE),
(1, 'mardi', '14:00:00', '19:00:00', TRUE),
(1, 'mercredi', '09:00:00', '12:00:00', TRUE),
(1, 'jeudi', '09:00:00', '12:00:00', TRUE),
(1, 'jeudi', '14:00:00', '19:00:00', TRUE),
(1, 'vendredi', '09:00:00', '12:00:00', TRUE),
(1, 'vendredi', '14:00:00', '19:00:00', TRUE),
(1, 'samedi', '09:00:00', '13:00:00', TRUE);

-- Marie Laurent (coach_id: 2)
INSERT INTO disponibilites (coach_id, jour_semaine, heure_debut, heure_fin, est_disponible) VALUES 
(2, 'lundi', '10:00:00', '13:00:00', TRUE),
(2, 'lundi', '15:00:00', '20:00:00', TRUE),
(2, 'mardi', '10:00:00', '13:00:00', TRUE),
(2, 'mardi', '15:00:00', '20:00:00', TRUE),
(2, 'mercredi', '10:00:00', '20:00:00', TRUE),
(2, 'jeudi', '10:00:00', '13:00:00', TRUE),
(2, 'jeudi', '15:00:00', '20:00:00', TRUE),
(2, 'vendredi', '10:00:00', '13:00:00', TRUE),
(2, 'samedi', '10:00:00', '14:00:00', TRUE);

-- Thomas Martin (coach_id: 3)
INSERT INTO disponibilites (coach_id, jour_semaine, heure_debut, heure_fin, est_disponible) VALUES 
(3, 'lundi', '08:00:00', '12:00:00', TRUE),
(3, 'lundi', '17:00:00', '21:00:00', TRUE),
(3, 'mardi', '08:00:00', '12:00:00', TRUE),
(3, 'mardi', '17:00:00', '21:00:00', TRUE),
(3, 'mercredi', '08:00:00', '12:00:00', TRUE),
(3, 'jeudi', '08:00:00', '12:00:00', TRUE),
(3, 'jeudi', '17:00:00', '21:00:00', TRUE),
(3, 'vendredi', '08:00:00', '12:00:00', TRUE),
(3, 'samedi', '08:00:00', '12:00:00', TRUE);

-- Paul Rousseau (coach_id: 4)
INSERT INTO disponibilites (coach_id, jour_semaine, heure_debut, heure_fin, est_disponible) VALUES 
(4, 'lundi', '07:00:00', '11:00:00', TRUE),
(4, 'mardi', '07:00:00', '11:00:00', TRUE),
(4, 'mercredi', '07:00:00', '11:00:00', TRUE),
(4, 'jeudi', '07:00:00', '11:00:00', TRUE),
(4, 'vendredi', '07:00:00', '11:00:00', TRUE),
(4, 'samedi', '07:00:00', '12:00:00', TRUE),
(4, 'dimanche', '08:00:00', '11:00:00', TRUE);

-- Laura Petit (coach_id: 5)
INSERT INTO disponibilites (coach_id, jour_semaine, heure_debut, heure_fin, est_disponible) VALUES 
(5, 'lundi', '09:00:00', '19:00:00', TRUE),
(5, 'mardi', '09:00:00', '19:00:00', TRUE),
(5, 'mercredi', '09:00:00', '13:00:00', TRUE),
(5, 'jeudi', '09:00:00', '19:00:00', TRUE),
(5, 'vendredi', '09:00:00', '19:00:00', TRUE),
(5, 'samedi', '10:00:00', '15:00:00', TRUE);

-- Lucas Bernard (coach_id: 6)
INSERT INTO disponibilites (coach_id, jour_semaine, heure_debut, heure_fin, est_disponible) VALUES 
(6, 'lundi', '14:00:00', '21:00:00', TRUE),
(6, 'mardi', '14:00:00', '21:00:00', TRUE),
(6, 'mercredi', '14:00:00', '21:00:00', TRUE),
(6, 'jeudi', '14:00:00', '21:00:00', TRUE),
(6, 'vendredi', '14:00:00', '21:00:00', TRUE),
(6, 'samedi', '09:00:00', '13:00:00', TRUE);

-- Sophie Dubois (coach_id: 7)
INSERT INTO disponibilites (coach_id, jour_semaine, heure_debut, heure_fin, est_disponible) VALUES 
(7, 'lundi', '08:00:00', '13:00:00', TRUE),
(7, 'lundi', '16:00:00', '20:00:00', TRUE),
(7, 'mardi', '08:00:00', '13:00:00', TRUE),
(7, 'mercredi', '08:00:00', '13:00:00', TRUE),
(7, 'jeudi', '08:00:00', '13:00:00', TRUE),
(7, 'jeudi', '16:00:00', '20:00:00', TRUE),
(7, 'vendredi', '08:00:00', '13:00:00', TRUE),
(7, 'samedi', '08:00:00', '12:00:00', TRUE);

-- Alexandre Moreau (coach_id: 8)
INSERT INTO disponibilites (coach_id, jour_semaine, heure_debut, heure_fin, est_disponible) VALUES 
(8, 'lundi', '06:00:00', '10:00:00', TRUE),
(8, 'lundi', '18:00:00', '22:00:00', TRUE),
(8, 'mardi', '06:00:00', '10:00:00', TRUE),
(8, 'mardi', '18:00:00', '22:00:00', TRUE),
(8, 'mercredi', '06:00:00', '10:00:00', TRUE),
(8, 'jeudi', '06:00:00', '10:00:00', TRUE),
(8, 'jeudi', '18:00:00', '22:00:00', TRUE),
(8, 'vendredi', '06:00:00', '10:00:00', TRUE),
(8, 'vendredi', '18:00:00', '22:00:00', TRUE),
(8, 'samedi', '06:00:00', '11:00:00', TRUE);

-- ============================================
-- 9. RÉSERVATIONS / SÉANCES
-- ============================================

-- Séances TERMINÉES (passées)
INSERT INTO reservations (sportif_id, coach_id, discipline_id, date_seance, duree_minutes, statut, prix, lieu, date_creation) VALUES 
-- Sophie Martin avec Jean Dupont
(1, 1, 1, '2025-01-03 10:00:00', 60, 'terminée', 45.00, 'Salle Sport Plus', '2024-12-28 09:00:00'),
(1, 1, 1, '2025-01-06 10:00:00', 60, 'terminée', 45.00, 'Salle Sport Plus', '2025-01-02 14:00:00'),
(1, 1, 1, '2025-01-10 10:00:00', 60, 'terminée', 45.00, 'Salle Sport Plus', '2025-01-05 11:00:00'),

-- Marc Leblanc avec Paul Rousseau
(2, 4, 2, '2025-01-04 09:00:00', 60, 'terminée', 42.00, 'Parc Monceau', '2024-12-30 10:00:00'),
(2, 4, 2, '2025-01-08 09:00:00', 60, 'terminée', 42.00, 'Parc Monceau', '2025-01-03 15:00:00'),

-- Julie Petit avec Marie Laurent
(3, 2, 3, '2025-01-05 16:00:00', 60, 'terminée', 40.00, 'Studio Zen', '2025-01-02 12:00:00'),
(3, 2, 3, '2025-01-08 16:00:00', 60, 'terminée', 40.00, 'Studio Zen', '2025-01-04 10:00:00'),

-- Emma Bernard avec Thomas Martin
(6, 3, 5, '2025-01-07 19:00:00', 90, 'terminée', 57.00, 'CrossBox Paris', '2025-01-02 16:00:00'),

-- Pierre Moreau avec Jean Dupont
(5, 1, 1, '2025-01-09 11:00:00', 60, 'terminée', 45.00, 'Salle Sport Plus', '2025-01-05 13:00:00');

-- Séances CONFIRMÉES (à venir - aujourd'hui et demain)
INSERT INTO reservations (sportif_id, coach_id, discipline_id, date_seance, duree_minutes, statut, prix, lieu, date_creation) VALUES 
-- Aujourd'hui 13 Jan 2025
(1, 1, 1, '2025-01-13 14:00:00', 60, 'acceptée', 45.00, 'Salle Sport Plus', '2025-01-08 10:00:00'),
(6, 3, 12, '2025-01-13 18:00:00', 60, 'acceptée', 38.00, 'CrossBox Paris', '2025-01-09 14:00:00'),

-- Demain 14 Jan 2025
(2, 4, 2, '2025-01-14 09:00:00', 60, 'acceptée', 42.00, 'Parc Monceau', '2025-01-10 11:00:00'),
(3, 2, 3, '2025-01-14 16:00:00', 60, 'acceptée', 40.00, 'Studio Zen', '2025-01-11 09:00:00'),
(7, 8, 1, '2025-01-14 19:00:00', 60, 'acceptée', 55.00, 'Gym Elite', '2025-01-10 15:00:00'),

-- Séances dans les prochains jours
(1, 1, 1, '2025-01-15 10:00:00', 60, 'acceptée', 45.00, 'Salle Sport Plus', '2025-01-10 12:00:00'),
(5, 1, 1, '2025-01-17 11:00:00', 60, 'acceptée', 45.00, 'Salle Sport Plus', '2025-01-12 10:00:00'),
(3, 2, 3, '2025-01-17 14:00:00', 60, 'acceptée', 40.00, 'Studio Zen', '2025-01-12 14:00:00'),
(8, 5, 4, '2025-01-18 10:00:00', 60, 'acceptée', 40.00, 'Studio Harmonie', '2025-01-13 09:00:00'),
(6, 3, 5, '2025-01-20 18:00:00', 90, 'acceptée', 57.00, 'CrossBox Paris', '2025-01-13 11:00:00'),
(11, 6, 6, '2025-01-20 19:00:00', 60, 'acceptée', 50.00, 'Boxing Club', '2025-01-13 10:00:00'),
(4, 5, 3, '2025-01-22 16:00:00', 60, 'acceptée', 40.00, 'Studio Harmonie', '2025-01-13 15:00:00'),
(9, 8, 12, '2025-01-23 20:00:00', 60, 'acceptée', 55.00, 'Gym Elite', '2025-01-13 16:00:00');

-- Séances EN ATTENTE (demandes à accepter/refuser)
INSERT INTO reservations (sportif_id, coach_id, discipline_id, date_seance, duree_minutes, statut, prix, lieu, date_creation) VALUES 
(4, 2, 3, '2025-01-22 16:00:00', 60, 'en_attente', 40.00, 'Studio Zen', '2025-01-13 08:00:00'),
(5, 1, 1, '2025-01-23 11:00:00', 60, 'en_attente', 45.00, 'Salle Sport Plus', '2025-01-13 09:30:00'),
(6, 8, 5, '2025-01-25 19:00:00', 90, 'en_attente', 82.50, 'Gym Elite', '2025-01-13 10:15:00'),
(10, 4, 10, '2025-01-24 08:00:00', 60, 'en_attente', 42.00, 'Jardin du Luxembourg', '2025-01-13 11:00:00'),
(12, 5, 4, '2025-01-26 15:00:00', 60, 'en_attente', 40.00, 'Studio Harmonie', '2025-01-13 12:00:00');

-- Séances DISPONIBLES (créneaux libres créés par les coachs)
INSERT INTO reservations (sportif_id, coach_id, discipline_id, date_seance, duree_minutes, statut, prix, lieu, date_creation) VALUES 
(1, 1, 1, '2025-01-20 10:00:00', 60, 'en_attente', 45.00, 'Salle Sport Plus', '2025-01-10 14:00:00'),
(1, 2, 3, '2025-01-21 17:00:00', 60, 'en_attente', 40.00, 'Studio Zen', '2025-01-10 15:00:00'),
(1, 4, 2, '2025-01-22 09:00:00', 60, 'en_attente', 42.00, 'Parc des Buttes-Chaumont', '2025-01-10 16:00:00'),
(1, 5, 4, '2025-01-23 11:00:00', 90, 'en_attente', 60.00, 'Studio Harmonie', '2025-01-11 10:00:00'),
(1, 3, 12, '2025-01-24 19:00:00', 60, 'en_attente', 38.00, 'CrossBox Paris', '2025-01-11 11:00:00'),
(1, 6, 6, '2025-01-25 20:00:00', 60, 'en_attente', 50.00, 'Boxing Club', '2025-01-11 12:00:00'),
(1, 7, 7, '2025-01-26 10:00:00', 60, 'en_attente', 35.00, 'Piscine Keller', '2025-01-11 13:00:00');

-- Séances ANNULÉES
INSERT INTO reservations (sportif_id, coach_id, discipline_id, date_seance, duree_minutes, statut, prix, lieu, date_creation) VALUES 
(3, 1, 1, '2025-01-05 14:00:00', 60, 'annulée', 45.00, 'Salle Sport Plus', '2025-01-02 10:00:00'),
(7, 3, 5, '2025-01-07 18:00:00', 60, 'annulée', 38.00, 'CrossBox Paris', '2025-01-03 15:00:00');

-- Séances REFUSÉES
INSERT INTO reservations (sportif_id, coach_id, discipline_id, date_seance, duree_minutes, statut, prix, lieu, date_creation) VALUES 
(10, 1, 1, '2025-01-12 22:00:00', 60, 'refusée', 45.00, 'Salle Sport Plus', '2025-01-10 20:00:00'),
(13, 8, 1, '2025-01-15 05:00:00', 60, 'refusée', 55.00, 'Gym Elite', '2025-01-11 21:00:00');

-- ============================================
-- RÉSUMÉ DES DONNÉES
-- ============================================
-- 1 Admin
-- 8 Coachs avec profils complets
-- 15 Sportifs avec différents niveaux
-- 15 Disciplines sportives
-- 26 Certifications pour les coachs
-- 60+ Disponibilités pour les coachs
-- 40+ Réservations avec différents statuts:
--    - Terminées (passées)
--    - Acceptées (confirmées à venir)
--    - En attente (à traiter)
--    - Disponibles (créneaux libres)
--    - Annulées
--    - Refusées

-- ============================================
-- COMPTES DE TEST
-- ============================================
-- Email: admin@coachingsport.fr | Password: password | Rôle: Admin
-- 
-- COACHS:
-- Email: jean.dupont@coach.fr | Password: password
-- Email: marie.laurent@coach.fr | Password: password
-- Email: thomas.martin@coach.fr | Password: password
-- Email: paul.rousseau@coach.fr | Password: password
-- Email: laura.petit@coach.fr | Password: password
-- Email: lucas.bernard@coach.fr | Password: password
-- Email: sophie.dubois@coach.fr | Password: password
-- Email: alex.moreau@coach.fr | Password: password
--
-- SPORTIFS:
-- Email: sophie.martin@sport.fr | Password: password
-- Email: marc.leblanc@sport.fr | Password: password
-- Email: julie.petit@sport.fr | Password: password
-- Email: laura.dubois@sport.fr | Password: password
-- Email: pierre.moreau@sport.fr | Password: password
-- Email: emma.bernard@sport.fr | Password: password
-- (+ 9 autres sportifs avec le même mot de passe)