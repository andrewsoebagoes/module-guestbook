CREATE TABLE gb_events(
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    start_at DATETIME NOT NULL,
    end_at DATETIME NOT NULL
);

CREATE TABLE gb_guests(
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    graduation_year YEAR NOT NULL,
    registration_date DATE NOT NULL,
    seat_number INT NOT NULL,
    qrcode_value TEXT NOT NULL,
    CONSTRAINT fk_gb_guests_event_id FOREIGN KEY (event_id) REFERENCES gb_events(id) ON DELETE CASCADE
);

CREATE TABLE gb_attendances(
    id INT AUTO_INCREMENT PRIMARY KEY,
    guest_id INT NOT NULL,
    created_by INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_gb_attendances_guest_id FOREIGN KEY (guest_id) REFERENCES gb_guests(id) ON DELETE CASCADE,
    CONSTRAINT fk_gb_attendances_created_by FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL
);