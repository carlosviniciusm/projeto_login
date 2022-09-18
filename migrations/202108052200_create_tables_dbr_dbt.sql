CREATE TABLE receiveit.dbr_debtor
(
    dbr_id INT PRIMARY KEY AUTO_INCREMENT,
    dbr_name VARCHAR(255) NOT NULL,
    dbr_email VARCHAR(100) NOT NULL,
    dbr_cpf_cnpj VARCHAR(14) NOT NULL UNIQUE,
    dbr_birthdate DATE NOT NULL,
    dbr_phone_number VARCHAR(20) NOT NULL,
    dbr_zipcode VARCHAR(10) NOT NULL,
    dbr_address VARCHAR(255) NOT NULL,
    dbr_number VARCHAR(10) NOT NULL,
    dbr_complement VARCHAR(255),
    dbr_neighborhood VARCHAR(255) NOT NULL,
    dbr_city VARCHAR(255) NOT NULL,
    dbr_state VARCHAR(5) NOT NULL,
    dbr_status CHAR(1) NOT NULL DEFAULT 1,
    dbr_active CHAR(1) NOT NULL DEFAULT 1,
    dbr_created DATETIME NOT NULL DEFAULT NOW(),
    dbr_updated DATETIME NULL
);

CREATE TABLE receiveit.dbt_debt
(
    dbt_id INT PRIMARY KEY AUTO_INCREMENT,
    dbr_id INT,
    dbt_description VARCHAR(255) NOT NULL,
    dbt_amount DECIMAL NOT NULL,
    dbt_due_date DATETIME NOT NULL,
    dbt_status CHAR(1) NOT NULL DEFAULT 0,
    dbt_active CHAR(1) NOT NULL DEFAULT 1,
    dbt_created DATETIME NOT NULL DEFAULT NOW(),
    dbt_updated DATETIME NULL
);

ALTER TABLE receiveit.dbt_debt ADD CONSTRAINT dbr_dbt_id_fk FOREIGN KEY (dbr_id) REFERENCES receiveit.dbr_debtor (dbr_id);

