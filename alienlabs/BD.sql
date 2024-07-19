drop database if exists alienlabs;
CREATE DATABASE alienlabs;

USE alienlabs;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


select * from users;


CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total DECIMAL(10, 2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE order_details (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

INSERT INTO products (name, description, price, image_url) VALUES
('Creatina R.C', 'Utilizando el monohidrato de creatina xs de Ronnie Coleman, mejora la capacidad anaerobia aumentando los niveles de fuerza y resistencia y los entrenamientos de alta intensidad.', 29990, 'image/CreatineXS.jpg'),
('Creatina Turbo', 'Un producto formulado con creatina mono-hidratada y con el carbohidrato maltodextrina. Cada dosis posee solamente 12 calorías y entrega 3 g de cada substancia.', 25990, 'image/creatina3.webp'),
('Creatina Monohidratada', 'La creatina es un derivado de los aminoácidos que ayuda a aumentar el rendimiento deportivo durante el entrenamiento y a incrementar la masa muscular. 100 porciones por envase. Con cuchara medidora incluida. Producto vegano. Producto sin sabor.', 34990, 'image/Monohidratada.webp'),
('Creatina en Gomitas', 'Creatina en gomitas está creada con la más alta calidad y tecnología de foodtech te entrega. Cómodo y delicioso: disfruta de los beneficios de la creatina en una sabrosa forma de gomita con nuestra nueva fórmula anti-fusión. Perfecto para estilos de vida en movimiento de fácil integración en las rutinas diarias sin el desorden de los polvos. Disfruta de un cuerpo lleno de vitalidad.', 18990, 'image/gomitas.webp'),
('Creatine 100% Pure Monohydrated', 'Creatine 100% Pure Monohydrate de Foodtech es un alimento en polvo de creatina, ideal para deportistas o personas fitness que desean complementar su alimentación.', 27990, 'image/pron.webp'),
('Creatina O.P', 'La Creatina Micronizada en Polvo de Optimum Nutrition es un suplemento de alta calidad diseñado para favorecer el desarrollo muscular y mejorar el rendimiento en actividades físicas.', 23990, 'image/creatina4.jpg');


INSERT INTO products (name, description, price, image_url) VALUES
('Proteína Whey protein Gold Standard', 'Contribuye a la protección, recuperación y reconstrucción de las fibras musculares después de la práctica deportiva. Contiene 100% proteína aislada de suero, es hidrolizada y posee una alta concentración de aminoácidos ramificados y glutamina.', 79990, 'image/prote1.jpg'),
('Proteína Iron Whey', 'Una fórmula de alta calidad que ofrece una gran cantidad de aminoácidos de origen natural que el cuerpo necesita diariamente. Sin importar la edad o el nivel de actividad física, la proteína de suero de leche es esencial para cada régimen de nutrición.', 69990, 'image/arnold-iron-whey.jpg'),
('Proteína Rawfusion (vsg)', 'Ofrece proteínas de origen vegetal densas en nutrientes con una fórmula de proteína inigualable, NO OGM, aprobada para veganos que satisface sus necesidades diarias de proteínas. ¡La fórmula de proteína no láctea de RAWFUSION es fácil de digerir y tiene un sabor increíble!', 24900, 'image/proteraw.webp'),
('VEGAN PROTEIN + B12', 'La primera Proteína Vegana de su nueva línea de productos. Con un exquisito sabor y fácil disolución, Vegan Protein te entrega 26 gramos de proteína por porción, siendo una de las primeras proteínas veganas en entregarte esta alta dosis.', 27990, 'image/veganmulti.webp'),
('Vegan Gainer Mass', 'Para deportistas que desean llegar a sus necesidades calóricas diarias y aumentar el peso corporal de forma saludable con nutrientes de origen 100% vegetal. El ganador de peso Vegan Gainer Mass es una excelente fuente de calorías de rápida absorción, diseñado con proteína aislada de soya y maltodextrina.', 19990, 'image/vegain.webp'),
('Shake Proteico 1k', 'Fórmula alimenticia en polvo con proteína de arveja y soya sabor chocolate. Este producto vegano es una buena fuente de proteínas; contiene 18 g de proteína de vegetal por porción, lo que ayuda a la recuperación muscular tras el entrenamiento y a obtener una mayor sensación de saciedad.', 24900, 'image/proteshak.webp');



INSERT INTO products (name, description, price, image_url) VALUES
('Pre Workout CBUM', 'Esta fórmula de alta calidad está diseñada para brindarte un impulso de energía, enfoque y resistencia, al tiempo que proporciona nutrientes esenciales para apoyar tu salud y bienestar en general.', 29990, 'image/prework1.jpg'),
('Detox & Prebiotic', 'Tiene un 23% de la fibra diaria recomendada por porción, totalmente natural, regulador del tránsito intestinal, ayuda a prevenir enfermedades cardiovasculares, libre de gluten.', 11990, 'image/azza.webp'),
('Pre Workout Psychotic', 'Cargado con Infinergy, Cafeína y Tirosina, Psychotic BLACK no decepcionará.', 34990, 'image/prework2.jpg'),
('Ares pre-workout palikos', 'Ares pre-workout palikos - cherry, marca palikos fitness. Producto nuevo. Unidad de medida: gramo, garantía: 3 meses, modelo: pre entreno, condición del producto: nuevo, cantidad contenida en el empaque: 600 gr, medida/volumen: 5, peso del producto: 600 gr, forma farmacéutica.', 28990, 'image/preares.webp'),
('VeggiPro One', 'Es un delicioso batido proteico de sabor neutro elaborado de superalimentos, especialmente pensado para que puedas preparar tus recetas favoritas y logres el sabor que quieras en tus batidos, repostería y otras preparaciones.', 25990, 'image/prevegg.webp'),
('Pre Workout Venom Inferno', 'Venom Inferno® está cargado con los ingredientes más avanzados y respaldados por investigaciones para brindarle más energía, concentración mental y maximizar su potencial de entrenamiento como nunca antes lo había experimentado.', 49990, 'image/prework5.png');


select * from order_details;

SELECT 
    u.name AS usuario,
    u.email AS correo,
    o.id AS orden_id,
    o.created_at AS fecha_orden,
    p.name AS producto,
    od.quantity AS cantidad,
    od.price AS precio_unitario,
    (od.quantity * od.price) AS total_producto
FROM 
    users u
JOIN 
    orders o ON u.id = o.user_id
JOIN 
    order_details od ON o.id = od.order_id
JOIN 
    products p ON od.product_id = p.id
ORDER BY 
    o.created_at DESC;
INSERT INTO users (name, email, password, role, created_at) VALUES 
('admin', 'admin@gmail.com', '$2y$10$8.zIBbd2KFIaLa/yzVGHZO9qnyPRoI9mrGDqpsZ5RpgFe9qHbxOmy', 'admin', '2024-07-17 21:28:59');