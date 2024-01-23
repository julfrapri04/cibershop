SELECT
    v.DNI,
    p.Nombre,
    p.Id_producto,
    v.Unidades,
    CONCAT(p.Precio, '€') AS Precio,
    CONCAT(v.Unidades * p.Precio, '€') AS Total
FROM
    ventas v
JOIN
    productos p ON v.Id_producto = p.Id_producto;
