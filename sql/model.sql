CREATE TABLE `explorer` (
  `id` int(11) NOT NULL COMMENT 'Id único del usuario' AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre o nick del usuario' ,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Direccion email del usuario' ,
  `pass` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Contraseña cifrada del usuario' ,
  `credits` int(11) NOT NULL COMMENT 'Cantidad de créditos del usuario' ,
  `current_ship` int(11) NOT NULL COMMENT 'Id de la nave que actualmente está usando el explorador' ,
  `last_save_point` int(11) NOT NULL COMMENT 'Último punto de salvado, Id del sistema' ,
  `auth` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'clave auth para la api' ,
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
  `num_npc` int(11) NOT NULL COMMENT 'Número de NPC en el sistema' ,
  `sun_type` varchar(5) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Tipo de Sol' ,
  `created_at` datetime NOT NULL COMMENT 'Fecha de creación del registro' ,
  `updated_at` datetime NOT NULL COMMENT 'Fecha de última modificación del registro' ,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;


CREATE TABLE `system_distance` (
  `id_system_1` int(11) NOT NULL COMMENT 'Id del primer sistema' ,
  `id_system_2` int(11) NOT NULL COMMENT 'Id del segundo sistema' ,
  `distance` int(11) NOT NULL COMMENT 'Grados de separación entre los dos sistemas' ,
  `created_at` datetime NOT NULL COMMENT 'Fecha de creación del registro' ,
  `updated_at` datetime NOT NULL COMMENT 'Fecha de última modificación del registro' ,
  PRIMARY KEY (`id_system_1`,`id_system_2`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;


CREATE TABLE `explorer_system_connection` (
  `id_explorer` int(11) NOT NULL COMMENT 'Id del explorador' ,
  `id_system_1` int(11) NOT NULL COMMENT 'Id del primer sistema' ,
  `id_system_2` int(11) NOT NULL COMMENT 'Id del segundo sistema' ,
  `created_at` datetime NOT NULL COMMENT 'Fecha de creación del registro' ,
  `updated_at` datetime NOT NULL COMMENT 'Fecha de última modificación del registro' ,
  PRIMARY KEY (`id_explorer`,`id_system_1`,`id_system_2`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;


CREATE TABLE `planet` (
  `id` int(11) NOT NULL COMMENT 'Id único del sistema solar' AUTO_INCREMENT,
  `id_system` int(11) NOT NULL COMMENT 'Id del sistema al que pertenece el planeta' ,
  `id_owner` int(11) NOT NULL COMMENT 'Id del dueño del planeta' ,
  `npc` tinyint(1) NOT NULL COMMENT 'Indica si el dueño del planeta es un NPC 1 o no 0' ,
  `original_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre original del planeta' ,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre dado por el descubridor' ,
  `id_type` int(11) NOT NULL COMMENT 'Id del tipo de planeta' ,
  `radius` int(11) NOT NULL COMMENT 'Radio del planeta en kilómetros' ,
  `survival` int(11) NOT NULL COMMENT 'Indice de supervivencia 0 imposible 1 tipo-tierra' ,
  `has_life` tinyint(1) NOT NULL COMMENT 'Indica si tiene vida 1 o no 0' ,
  `distance` int(11) NOT NULL COMMENT 'Distancia del planeta a su sol' ,
  `num_moons` int(11) NOT NULL COMMENT 'Número de lunas en el planeta' ,
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
  `hull_current_strength` int(11) NOT NULL COMMENT 'Integridad estructural del hull actual' ,
  `hull_mass` int(11) NOT NULL COMMENT 'Peso del hull, para el movimiento' ,
  `gun_ports` tinyint(1) NOT NULL COMMENT 'Número de huecos para introducir armas' ,
  `big_module_ports` int(11) NOT NULL COMMENT 'Número de los posibles módulos grandes' ,
  `small_module_ports` int(11) NOT NULL COMMENT 'Número de los posibles módulos pequeños' ,
  `shield_id_type` int(11) NOT NULL COMMENT 'Id del tipo de shield, para información inicial, nombre...' ,
  `shield_strength` int(11) NOT NULL COMMENT 'Daño que aguanta el shield' ,
  `shield_current_strength` int(11) NOT NULL COMMENT 'Daño actual que puede aguantar el shield' ,
  `shield_energy` int(11) NOT NULL COMMENT 'Energía necesaria para que el shield funcione' ,
  `engine_id_type` int(11) NOT NULL COMMENT 'Id del tipo de engine, para información inicial, nombre...' ,
  `engine_power` int(11) NOT NULL COMMENT 'Potencia de empuje del engine' ,
  `engine_energy` int(11) NOT NULL COMMENT 'Energía necesaria para que el engine funcione' ,
  `engine_impulse` int(11) NOT NULL COMMENT 'Cantidad de UA por hora que se mueve' ,
  `engine_fuel_cost` int(11) NOT NULL COMMENT 'Cantidad de fuel que consume por movimiento' ,
  `engine_fuel_actual` int(11) NOT NULL COMMENT 'Cantidad de fuel que tiene en un momento dado' ,
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


CREATE TABLE `module` (
  `id` int(11) NOT NULL COMMENT 'Id único del módulo' AUTO_INCREMENT,
  `id_type` int(11) NOT NULL COMMENT 'Id del tipo de módulo' ,
  `id_owner` int(11) NOT NULL COMMENT 'Id del usuario dueño del módulo' ,
  `id_ship` int(11) NOT NULL COMMENT 'Id de la nave en la que está equipada o NULL si no está equipada' ,
  `size` int(11) NOT NULL COMMENT 'Tamaño del módulo 0 small 1 big' ,
  `enables` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Lista de habilidades que tener el módulo permite' ,
  `crew` int(11) NOT NULL COMMENT 'Número de tripulantes que puede alojar o pueden trabajar' ,
  `mass` int(11) NOT NULL COMMENT 'Peso del módulo, para el movimiento' ,
  `storage` int(11) NOT NULL COMMENT 'Capacidad de almacenamiento del módulo' ,
  `energy` int(11) NOT NULL COMMENT 'Energía necesaria para que el módulo funcione' ,
  `credits` int(11) NOT NULL COMMENT 'Precio del módulo' ,
  `created_at` datetime NOT NULL COMMENT 'Fecha de creación del registro' ,
  `updated_at` datetime NOT NULL COMMENT 'Fecha de última modificación del registro' ,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;


CREATE TABLE `npc` (
  `id` int(11) NOT NULL COMMENT 'Id único del NPC' AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre del NPC' ,
  `id_race` int(11) NOT NULL COMMENT 'Id del tipo de raza del NPC' ,
  `guns_start` varchar(200) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Armas que tiene a la venta por defecto' ,
  `guns_actual` varchar(200) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Armas que tiene actualmente a la venta' ,
  `modules_start` varchar(200) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Módulos que tiene a la venta por defecto' ,
  `modules_actual` varchar(200) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Módulos que tiene actualmente a la venta' ,
  `crew_start` varchar(200) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Tripulación que tiene a la venta por defecto' ,
  `crew_actual` varchar(200) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Tripulación que tiene actualmente a la venta' ,
  `resources_start` varchar(200) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Recursos que tiene a la venta por defecto' ,
  `resources_actual` varchar(200) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Recursos que tiene actualmente a la venta' ,
  `last_reset` datetime NOT NULL COMMENT 'Fecha y hora de la última vez que se ha reseteado' ,
  `created_at` datetime NOT NULL COMMENT 'Fecha de creación del registro' ,
  `updated_at` datetime NOT NULL COMMENT 'Fecha de última modificación del registro' ,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;


CREATE TABLE `resources` (
  `id_planet` int(11) NOT NULL COMMENT 'Id del planeta donde está el recurso o NULL si es una luna' ,
  `id_moon` int(11) NOT NULL COMMENT 'Id de la luna donde está el recurso o NULL si es un planeta' ,
  `id_resource_type` int(11) NOT NULL COMMENT 'Id del tipo de recurso' ,
  `value` int(11) NOT NULL COMMENT 'Armas que tiene a la venta por defecto' ,
  `created_at` datetime NOT NULL COMMENT 'Fecha de creación del registro' ,
  `updated_at` datetime NOT NULL COMMENT 'Fecha de última modificación del registro' ,
  PRIMARY KEY (`id_planet`,`id_moon`,`id_resource_type`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;


CREATE TABLE `ship_crew` (
  `id_ship` int(11) NOT NULL COMMENT 'Id de la nave donde va el tripulante' ,
  `id_crew` int(11) NOT NULL COMMENT 'Id del tripulante' ,
  `created_at` datetime NOT NULL COMMENT 'Fecha de creación del registro' ,
  `updated_at` datetime NOT NULL COMMENT 'Fecha de última modificación del registro' ,
  PRIMARY KEY (`id_ship`,`id_crew`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;


CREATE TABLE `crew` (
  `id` int(11) NOT NULL COMMENT 'Id único del tripulante' AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre del tripulante' ,
  `race` int(11) NOT NULL COMMENT 'Id de la raza del tripulante' ,
  `created_at` datetime NOT NULL COMMENT 'Fecha de creación del registro' ,
  `updated_at` datetime NOT NULL COMMENT 'Fecha de última modificación del registro' ,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;


CREATE TABLE `commerce` (
  `id` int(11) NOT NULL COMMENT 'Id único del mensaje' AUTO_INCREMENT,
  `id_first` int(11) NOT NULL COMMENT 'Id del usuario que envía el mensaje' ,
  `first_offers` text COLLATE utf8_unicode_ci  NOT NULL COMMENT 'Id del usuario que recibe el mensaje' ,
  `first_asks` text COLLATE utf8_unicode_ci  NOT NULL COMMENT 'Contenido del mensaje' ,
  `id_second` int(11) NOT NULL COMMENT 'Contenido del mensaje' ,
  `second_offers` text COLLATE utf8_unicode_ci  NOT NULL ,
  `created_at` datetime NOT NULL COMMENT 'Fecha de creación del registro' ,
  `updated_at` datetime NOT NULL COMMENT 'Fecha de última modificación del registro' ,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;


CREATE TABLE `message` (
  `id` int(11) NOT NULL COMMENT 'Id único del mensaje' AUTO_INCREMENT,
  `from` int(11) NOT NULL COMMENT 'Id del usuario que envía el mensaje' ,
  `to` int(11) NOT NULL COMMENT 'Id del usuario que recibe el mensaje' ,
  `content` text COLLATE utf8_unicode_ci  NOT NULL COMMENT 'Contenido del mensaje' ,
  `created_at` datetime NOT NULL COMMENT 'Fecha de creación del registro' ,
  `updated_at` datetime NOT NULL COMMENT 'Fecha de última modificación del registro' ,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;


CREATE TABLE `notification` (
  `id` int(11) NOT NULL COMMENT 'Id único del mensaje' AUTO_INCREMENT,
  `id_explorer` int(11) NOT NULL COMMENT 'Id del usuario que envía el mensaje' ,
  `type` int(11) NOT NULL COMMENT 'Id del usuario que recibe el mensaje' ,
  `value` text COLLATE utf8_unicode_ci  NOT NULL COMMENT 'Contenido del mensaje' ,
  `discarded` tinyint(1) NOT NULL COMMENT 'Contenido del mensaje' ,
  `created_at` datetime NOT NULL COMMENT 'Fecha de creación del registro' ,
  `updated_at` datetime NOT NULL COMMENT 'Fecha de última modificación del registro' ,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;


CREATE TABLE `npc_note` (
  `id` int(11) NOT NULL COMMENT 'Id única de la nota' AUTO_INCREMENT,
  `id_explorer` int(11) NOT NULL COMMENT 'Id del usuario que pone la nota' ,
  `id_npc` int(11) NOT NULL COMMENT 'Id del NPC que tiene la nota' ,
  `note` text COLLATE utf8_unicode_ci  NOT NULL COMMENT 'Nota que el explorador pone al NPC' ,
  `created_at` datetime NOT NULL COMMENT 'Fecha de creación del registro' ,
  `updated_at` datetime NOT NULL COMMENT 'Fecha de última modificación del registro' ,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;


