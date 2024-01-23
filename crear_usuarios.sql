-- Usuario 'insertador'
CREATE USER IF NOT EXISTS 'insertador'@'localhost';
GRANT INSERT, SELECT ON cibershop.* TO 'insertador'@'localhost';

-- Usuario 'seleccionador'
CREATE USER IF NOT EXISTS 'seleccionador'@'localhost';
GRANT SELECT ON cibershop.* TO 'seleccionador'@'localhost';

-- Usuario 'eliminador'
CREATE USER IF NOT EXISTS 'eliminador'@'localhost';
GRANT DELETE, UPDATE, SELECT, INSERT ON cibershop.* TO 'eliminador'@'localhost';
