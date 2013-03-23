CREATE TABLE backstage (id BIGINT AUTO_INCREMENT, categoria_id BIGINT, titulo VARCHAR(255) NOT NULL, contenido text NOT NULL, descripcion_corta text NOT NULL, is_active TINYINT(1) DEFAULT '0', thumbnail VARCHAR(255) DEFAULT 'sin_imagen.jpg' NOT NULL, position INT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, slug VARCHAR(255), UNIQUE INDEX backstage_sluggable_idx (slug), INDEX categoria_id_idx (categoria_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE backstage_galeria (id BIGINT AUTO_INCREMENT, publicacion_id BIGINT, titulo VARCHAR(255) DEFAULT NULL, contenido text DEFAULT NULL, tipo_archivo VARCHAR(255) DEFAULT '1', archivo VARCHAR(255) NOT NULL, thumbnail VARCHAR(255) DEFAULT 'sin_imagen.jpg' NOT NULL, position INT, INDEX publicacion_id_idx (publicacion_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE categorias_backstage (id BIGINT AUTO_INCREMENT, categoria VARCHAR(255) NOT NULL, slug VARCHAR(255), is_active TINYINT(1) DEFAULT '0', created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, position BIGINT, UNIQUE INDEX categorias_backstage_position_sortable_idx (position), UNIQUE INDEX categorias_backstage_sluggable_idx (slug), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE categorias_publicaciones (id BIGINT AUTO_INCREMENT, categoria VARCHAR(255) NOT NULL, slug VARCHAR(255), is_active TINYINT(1) DEFAULT '0', created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, position BIGINT, UNIQUE INDEX categorias_publicaciones_position_sortable_idx (position), UNIQUE INDEX categorias_publicaciones_sluggable_idx (slug), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE categorias_talento (id BIGINT AUTO_INCREMENT, categoria VARCHAR(255) NOT NULL, slug VARCHAR(255), is_active TINYINT(1) DEFAULT '0', created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, position BIGINT, UNIQUE INDEX categorias_talento_position_sortable_idx (position), UNIQUE INDEX categorias_talento_sluggable_idx (slug), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE categorias_ventas (id BIGINT AUTO_INCREMENT, bloque BIGINT DEFAULT 1, categoria VARCHAR(255), created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, slug VARCHAR(255), UNIQUE INDEX categorias_ventas_sluggable_idx (slug), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE configuracion (id BIGINT AUTO_INCREMENT, seccion VARCHAR(255) NOT NULL, contenido text NOT NULL, imagen VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, slug VARCHAR(255), UNIQUE INDEX configuracion_sluggable_idx (slug), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE movimientos_newsletters (id BIGINT AUTO_INCREMENT, fecha_enviados DATE, cuantos_enviados INT DEFAULT 0, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE newsletter (id BIGINT AUTO_INCREMENT, nombre VARCHAR(255) NOT NULL, email text NOT NULL, is_active TINYINT(1) DEFAULT '1', created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, position BIGINT, UNIQUE INDEX newsletter_position_sortable_idx (position), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE publicaciones (id BIGINT AUTO_INCREMENT, categoria_id BIGINT, titulo VARCHAR(255) NOT NULL, contenido text NOT NULL, descripcion_corta text NOT NULL, is_active TINYINT(1) DEFAULT '0', thumbnail VARCHAR(255) DEFAULT 'sin_imagen.jpg' NOT NULL, position INT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, slug VARCHAR(255), UNIQUE INDEX publicaciones_sluggable_idx (slug), INDEX categoria_id_idx (categoria_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE publicaciones_galeria (id BIGINT AUTO_INCREMENT, publicacion_id BIGINT, titulo VARCHAR(255) DEFAULT NULL, contenido text DEFAULT NULL, tipo_archivo VARCHAR(255) DEFAULT '1', archivo VARCHAR(255) NOT NULL, thumbnail VARCHAR(255) DEFAULT 'sin_imagen.jpg' NOT NULL, position INT, INDEX publicacion_id_idx (publicacion_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE publicaciones_newsletters (id BIGINT AUTO_INCREMENT, template_id BIGINT, titulo VARCHAR(255) NOT NULL, contenido text NOT NULL, tipo_archivo BIGINT DEFAULT 1, archivo VARCHAR(255) NOT NULL, thumbnail VARCHAR(255) DEFAULT 'sin_imagen.jpg' NOT NULL, is_active TINYINT(1) DEFAULT '0', position INT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, slug VARCHAR(255), UNIQUE INDEX publicaciones_newsletters_sluggable_idx (slug), INDEX template_id_idx (template_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE talento (id BIGINT AUTO_INCREMENT, categoria_id BIGINT, titulo VARCHAR(255) NOT NULL, contenido text NOT NULL, actualmente text, pagina_web VARCHAR(150), twitter VARCHAR(150) NOT NULL, is_active TINYINT(1) DEFAULT '0', thumbnail VARCHAR(255) DEFAULT 'sin_imagen.jpg' NOT NULL, position INT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, slug VARCHAR(255), UNIQUE INDEX talento_sluggable_idx (slug), INDEX categoria_id_idx (categoria_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE talento_galeria (id BIGINT AUTO_INCREMENT, publicacion_id BIGINT, titulo VARCHAR(255) DEFAULT NULL, contenido text DEFAULT NULL, tipo_archivo VARCHAR(255) DEFAULT '1', archivo VARCHAR(255) NOT NULL, thumbnail VARCHAR(255) DEFAULT 'sin_imagen.jpg' NOT NULL, position INT, INDEX publicacion_id_idx (publicacion_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE templates_newsletters (id BIGINT AUTO_INCREMENT, titulo VARCHAR(255) NOT NULL, date_newsletter DATE, slug VARCHAR(255), is_active TINYINT(1) DEFAULT '0', created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, position BIGINT, UNIQUE INDEX templates_newsletters_position_sortable_idx (position), UNIQUE INDEX templates_newsletters_sluggable_idx (slug), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE ventas (id BIGINT AUTO_INCREMENT, categoria_id BIGINT, titulo VARCHAR(255) NOT NULL, categorias VARCHAR(255) DEFAULT 'Actriz/Conductora' NOT NULL, contenido text NOT NULL, disponible_para text NOT NULL, is_active TINYINT(1) DEFAULT '0', thumbnail VARCHAR(255) DEFAULT 'sin_imagen.jpg' NOT NULL, position INT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, slug VARCHAR(255), UNIQUE INDEX ventas_sluggable_idx (slug), INDEX categoria_id_idx (categoria_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE ventas_galeria (id BIGINT AUTO_INCREMENT, ventas_id BIGINT, titulo VARCHAR(255) DEFAULT NULL, contenido text DEFAULT NULL, tipo_archivo VARCHAR(255) DEFAULT '1', archivo VARCHAR(255) NOT NULL, thumbnail VARCHAR(255) DEFAULT 'sin_imagen.jpg' NOT NULL, position INT, INDEX ventas_id_idx (ventas_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE sf_guard_forgot_password (id BIGINT AUTO_INCREMENT, user_id BIGINT NOT NULL, unique_key VARCHAR(255), expires_at DATETIME NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX user_id_idx (user_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE sf_guard_group (id BIGINT AUTO_INCREMENT, name VARCHAR(255) UNIQUE, description TEXT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE sf_guard_group_permission (group_id BIGINT, permission_id BIGINT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(group_id, permission_id)) ENGINE = INNODB;
CREATE TABLE sf_guard_permission (id BIGINT AUTO_INCREMENT, name VARCHAR(255) UNIQUE, description TEXT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE sf_guard_remember_key (id BIGINT AUTO_INCREMENT, user_id BIGINT, remember_key VARCHAR(32), ip_address VARCHAR(50), created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX user_id_idx (user_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE sf_guard_user (id BIGINT AUTO_INCREMENT, first_name VARCHAR(255), last_name VARCHAR(255), email_address VARCHAR(255) NOT NULL UNIQUE, username VARCHAR(128) NOT NULL UNIQUE, algorithm VARCHAR(128) DEFAULT 'sha1' NOT NULL, salt VARCHAR(128), password VARCHAR(128), is_active TINYINT(1) DEFAULT '1', is_super_admin TINYINT(1) DEFAULT '0', last_login DATETIME, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX is_active_idx_idx (is_active), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE sf_guard_user_group (user_id BIGINT, group_id BIGINT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(user_id, group_id)) ENGINE = INNODB;
CREATE TABLE sf_guard_user_permission (user_id BIGINT, permission_id BIGINT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(user_id, permission_id)) ENGINE = INNODB;
ALTER TABLE backstage ADD CONSTRAINT backstage_categoria_id_categorias_backstage_id FOREIGN KEY (categoria_id) REFERENCES categorias_backstage(id) ON DELETE CASCADE;
ALTER TABLE backstage_galeria ADD CONSTRAINT backstage_galeria_publicacion_id_backstage_id FOREIGN KEY (publicacion_id) REFERENCES backstage(id) ON DELETE CASCADE;
ALTER TABLE publicaciones ADD CONSTRAINT publicaciones_categoria_id_categorias_publicaciones_id FOREIGN KEY (categoria_id) REFERENCES categorias_publicaciones(id) ON DELETE CASCADE;
ALTER TABLE publicaciones_galeria ADD CONSTRAINT publicaciones_galeria_publicacion_id_publicaciones_id FOREIGN KEY (publicacion_id) REFERENCES publicaciones(id) ON DELETE CASCADE;
ALTER TABLE publicaciones_newsletters ADD CONSTRAINT publicaciones_newsletters_template_id_templates_newsletters_id FOREIGN KEY (template_id) REFERENCES templates_newsletters(id) ON DELETE CASCADE;
ALTER TABLE talento ADD CONSTRAINT talento_categoria_id_categorias_talento_id FOREIGN KEY (categoria_id) REFERENCES categorias_talento(id) ON DELETE CASCADE;
ALTER TABLE talento_galeria ADD CONSTRAINT talento_galeria_publicacion_id_talento_id FOREIGN KEY (publicacion_id) REFERENCES talento(id) ON DELETE CASCADE;
ALTER TABLE ventas ADD CONSTRAINT ventas_categoria_id_categorias_ventas_id FOREIGN KEY (categoria_id) REFERENCES categorias_ventas(id) ON DELETE CASCADE;
ALTER TABLE ventas_galeria ADD CONSTRAINT ventas_galeria_ventas_id_ventas_id FOREIGN KEY (ventas_id) REFERENCES ventas(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_forgot_password ADD CONSTRAINT sf_guard_forgot_password_user_id_sf_guard_user_id FOREIGN KEY (user_id) REFERENCES sf_guard_user(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_group_permission ADD CONSTRAINT sf_guard_group_permission_permission_id_sf_guard_permission_id FOREIGN KEY (permission_id) REFERENCES sf_guard_permission(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_group_permission ADD CONSTRAINT sf_guard_group_permission_group_id_sf_guard_group_id FOREIGN KEY (group_id) REFERENCES sf_guard_group(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_remember_key ADD CONSTRAINT sf_guard_remember_key_user_id_sf_guard_user_id FOREIGN KEY (user_id) REFERENCES sf_guard_user(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_user_group ADD CONSTRAINT sf_guard_user_group_user_id_sf_guard_user_id FOREIGN KEY (user_id) REFERENCES sf_guard_user(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_user_group ADD CONSTRAINT sf_guard_user_group_group_id_sf_guard_group_id FOREIGN KEY (group_id) REFERENCES sf_guard_group(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_user_permission ADD CONSTRAINT sf_guard_user_permission_user_id_sf_guard_user_id FOREIGN KEY (user_id) REFERENCES sf_guard_user(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_user_permission ADD CONSTRAINT sf_guard_user_permission_permission_id_sf_guard_permission_id FOREIGN KEY (permission_id) REFERENCES sf_guard_permission(id) ON DELETE CASCADE;
