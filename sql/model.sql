CREATE TABLE `explorer` (
  `id` int(11) NOT NULL COMMENT 'Id único del usuario' AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre o nick del usuario' ,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Direccion email del usuario' ,
  `pass` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Contraseña cifrada del usuario' ,
  `credits` int(11) NOT NULL COMMENT 'Cantidad de créditos del usuario' ,
  `created_at` datetime NOT NULL COMMENT 'Fecha de creación del registro' ,
  `updated_at` datetime NOT NULL COMMENT 'Fecha de última modificación del registro' ,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;


CREATE TABLE `system` (
  `id` int(11) NOT NULL COMMENT 'Id único del sistema solar' AUTO_INCREMENT,
  `id_discoverer` int(11) NOT NULL COMMENT 'Id del usuario que ha descubierto el sistema' ,
  `original_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre original del sistema' ,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre del sistema dado por el usuario' ,
  `num_planets` int(11) NOT NULL COMMENT 'Número de planetas en el sistema' ,
  `sun_id_type` int(11) NOT NULL COMMENT 'Tipo de Sol' ,
  `created_at` datetime NOT NULL COMMENT 'Fecha de creación del registro' ,
  `updated_at` datetime NOT NULL COMMENT 'Fecha de última modificación del registro' ,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;


CREATE TABLE `planet` (
  `id` int(11) NOT NULL COMMENT 'Id único del sistema solar' AUTO_INCREMENT,
  `id_system` int(11) NOT NULL COMMENT 'Id del sistema al que pertenece el planeta' ,
  `id_owner` int(11) NOT NULL COMMENT 'Id del dueño del planeta' ,
  `npc` int(11) NOT NULL COMMENT 'Indica si el dueño del planeta es un NPC 1 o no 0' ,
  `original_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre original del planeta' ,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre dado por el descubridor' ,
  `id_type` int(11) NOT NULL COMMENT 'Id del tipo de planeta' ,
  `radius` int(11) NOT NULL COMMENT 'Radio del planeta en kilómetros' ,
  `survival` int(11) NOT NULL COMMENT 'Indice de supervivencia 0 imposible 1 tipo-tierra' ,
  `has_life` tinyint(1) NOT NULL COMMENT 'Indica si tiene vida 1 o no 0' ,
  `distance` int(11) NOT NULL COMMENT 'Distancia del planeta a su sol' ,
  `created_at` datetime NOT NULL COMMENT 'Fecha de creación del registro' ,
  `updated_at` datetime NOT NULL COMMENT 'Fecha de última modificación del registro' ,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;


CREATE TABLE `moon` (
  `id` int(11) NOT NULL COMMENT 'Id único de la luna' AUTO_INCREMENT,
  `id_planet` int(11) NOT NULL COMMENT 'Id del planeta al que pertenece' ,
  `id_owner` int(11) NOT NULL COMMENT 'Id del dueño de la luna' ,
  `npc` int(11) NOT NULL COMMENT 'Indica si el dueño de la luna es un NPC 1 o no 0' ,
  `original_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre original de la luna' ,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre dado por el descubridor' ,
  `radius` int(11) NOT NULL COMMENT 'Radio de la luna en kilómetros' ,
  `survival` int(11) NOT NULL COMMENT 'Indice de supervivencia 0 imposible 1 tipo-tierra' ,
  `has_life` tinyint(1) NOT NULL COMMENT 'Indica si tiene vida 1 o no 0' ,
  `distance` int(11) NOT NULL COMMENT 'Distancia de la luna a su planeta' ,
  `created_at` datetime NOT NULL COMMENT 'Fecha de creación del registro' ,
  `updated_at` datetime NOT NULL COMMENT 'Fecha de última modificación del registro' ,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;


CREATE TABLE `ship` (
  `id` int(11) NOT NULL COMMENT 'Id única de la nave' AUTO_INCREMENT,
  `id_owner` int(11) NOT NULL COMMENT 'Id del dueño de la nave' ,
  `original_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre original de la nave' ,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre de la nave' ,
  `hull_id_type` int(11) NOT NULL COMMENT 'Id del tipo de hull' ,
  `hull_strength` int(11) NOT NULL COMMENT 'Integridad estructural del hull, aguante ante ataques' ,
  `hull_mass` int(11) NOT NULL COMMENT 'Peso del hull, para el movimiento' ,
  `gun_ports` tinyint(1) NOT NULL COMMENT 'Número de huecos para introducir armas' ,
  `big_facility_ports` int(11) NOT NULL COMMENT 'Número de los posibles facilities grandes' ,
  `small_facility_ports` int(11) NOT NULL COMMENT 'Número de los posibles facilities pequeños' ,
  `shield_id_type` int(11) NOT NULL COMMENT 'Id del tipo de shield, para información inicial, nombre...' ,
  `shield_strength` int(11) NOT NULL COMMENT 'Daño que aguanta el shield' ,
  `shield_energy` int(11) NOT NULL COMMENT 'Energía necesaria para que el shield funcione' ,
  `engine_id_type` int(11) NOT NULL COMMENT 'Id del tipo de engine, para información inicial, nombre...' ,
  `engine_power` int(11) NOT NULL COMMENT 'Potencia de empuje del engine' ,
  `engine_energy` int(11) NOT NULL COMMENT 'Energía necesaria para que el engine funcione' ,
  `engine_impulse` int(11) NOT NULL COMMENT 'Cantidad de UA por hora que se mueve' ,
  `generator_id_type` int(11) NOT NULL COMMENT 'Id del tipo de generator, para información inicial, nombre...' ,
  `generator_power` int(11) NOT NULL COMMENT 'Cantidad de energia que genera' ,
  `credits` int(11) NOT NULL COMMENT 'Precio de la nave' ,
  `created_at` datetime NOT NULL COMMENT 'Fecha de creación del registro' ,
  `updated_at` datetime NOT NULL COMMENT 'Fecha de última modificación del registro' ,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;


CREATE TABLE `gun` (
  `id` int(11) NOT NULL COMMENT 'Id única del gun' AUTO_INCREMENT,
  `id_type` int(11) NOT NULL COMMENT 'Id del tipo de gun' ,
  `id_owner` int(11) NOT NULL COMMENT 'Id del usuario dueño del gun' ,
  `id_ship` int(11) NOT NULL COMMENT 'Id de la nave en la que está equipada o NULL si no está equipada' ,
  `strength` int(11) NOT NULL COMMENT 'Daño que hace' ,
  `accuracy` int(11) NOT NULL COMMENT 'Indice de acierto del gun' ,
  `recharge_time` int(11) NOT NULL COMMENT 'Tiempo que tarda en volver a disparar' ,
  `ignores_shields` tinyint(1) NOT NULL COMMENT 'Indica si el gun esquiva shields 1 o no 0' ,
  `energy` int(11) NOT NULL COMMENT 'Energía necesaria para que el gun funcione' ,
  `credits` int(11) NOT NULL COMMENT 'Precio de la gun' ,
  `created_at` datetime NOT NULL COMMENT 'Fecha de creación del registro' ,
  `updated_at` datetime NOT NULL COMMENT 'Fecha de última modificación del registro' ,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;


CREATE TABLE `facility` (
  `id` int(11) NOT NULL COMMENT 'Id única de la facility' AUTO_INCREMENT,
  `id_type` int(11) NOT NULL COMMENT 'Id del tipo de facility' ,
  `id_owner` int(11) NOT NULL COMMENT 'Id del usuario dueño del facility' ,
  `id_ship` int(11) NOT NULL COMMENT 'Id de la nave en la que está equipada o NULL si no está equipada' ,
  `size` int(11) NOT NULL COMMENT 'Tamaño de la facility 0 small 1 big' ,
  `enables` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Lista de habilidades que tener la facility permite' ,
  `crew` int(11) NOT NULL COMMENT 'Número de tripulantes que puede alojar o pueden trabajar' ,
  `mass` int(11) NOT NULL COMMENT 'Peso del facility, para el movimiento' ,
  `storage` int(11) NOT NULL COMMENT 'Capacidad de almacenamiento del facility' ,
  `energy` int(11) NOT NULL COMMENT 'Energía necesaria para que el facility funcione' ,
  `credits` int(11) NOT NULL COMMENT 'Precio de la facility' ,
  `created_at` datetime NOT NULL COMMENT 'Fecha de creación del registro' ,
  `updated_at` datetime NOT NULL COMMENT 'Fecha de última modificación del registro' ,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;


