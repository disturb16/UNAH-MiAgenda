-- -----------------------------------------------------
-- Schema miagnd_unah
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `miagnd_unah` DEFAULT CHARACTER SET latin1 ;
USE `miagnd_unah` ;

-- -----------------------------------------------------
-- Table `miagnd_unah`.`tipo_estado`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `miagnd_unah`.`tipo_estado` (
  `tipoEstadoID` INT NOT NULL AUTO_INCREMENT COMMENT '1 = Vigente, 2 = Anulado, 3 = Eliminado, 4 = Pendiente, 5 = Aprobado',
  `descripcion` VARCHAR(45) NOT NULL,
  `fechaCreo` DATETIME NOT NULL,
  `fechaElimino` DATETIME NULL,
  `usuarioElimino` INT NULL,
  PRIMARY KEY (`tipoEstadoID`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `miagnd_unah`.`tipo_usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `miagnd_unah`.`tipo_usuario` (
  `tipoUsuarioID` INT NOT NULL AUTO_INCREMENT,
  `descripcion` VARCHAR(45) NOT NULL,
  `tipoEstadoID` INT NOT NULL,
  `fechaCreo` DATETIME NOT NULL,
  `fechaElimino` DATETIME NULL,
  `usuarioElimino` INT NULL,
  PRIMARY KEY (`tipoUsuarioID`),
  INDEX `fkTPUsuarioEstado_idx` (`tipoEstadoID` ASC),
  CONSTRAINT `fkTPUsuarioEstado`
    FOREIGN KEY (`tipoEstadoID`)
    REFERENCES `miagnd_unah`.`tipo_estado` (`tipoEstadoID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `miagnd_unah`.`usuarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `miagnd_unah`.`usuarios` (
  `usuarioID` INT NOT NULL AUTO_INCREMENT,
  `userName` VARCHAR(90) NOT NULL,
  `nombres` VARCHAR(200) NOT NULL,
  `pass` VARCHAR(300) NOT NULL,
  `noCuenta` BIGINT(20) NOT NULL,
  `fechaNacimiento` DATETIME NOT NULL,
  `tipoUsuarioID` INT NOT NULL,
  `profilePicture` LONGTEXT NULL /*DEFAULT 'imagenes/perfil_pictures/perfil_no_photo.png'*/,
  `fechaCreo` DATETIME NOT NULL,
  `fechaElimino` DATETIME NULL,
  `usuarioElimino` INT NULL,
  `tipoEstadoID` INT NOT NULL,
  PRIMARY KEY (`usuarioID`),
  UNIQUE INDEX `userName_UNIQUE` (`userName` ASC),
  INDEX `fkUsuarioTPUsuario_idx` (`tipoUsuarioID` ASC),
  INDEX `fkUsuarioEstado_idx` (`tipoEstadoID` ASC),
  INDEX `fkUsuario_usuarioDel_idx` (`usuarioElimino` ASC),
  CONSTRAINT `fkUsuarioTPUsuario`
    FOREIGN KEY (`tipoUsuarioID`)
    REFERENCES `miagnd_unah`.`tipo_usuario` (`tipoUsuarioID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fkUsuarioEstado`
    FOREIGN KEY (`tipoEstadoID`)
    REFERENCES `miagnd_unah`.`tipo_estado` (`tipoEstadoID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fkUsuario_usuarioDel`
    FOREIGN KEY (`usuarioElimino`)
    REFERENCES `miagnd_unah`.`usuarios` (`usuarioID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `miagnd_unah`.`tipoFechaCronograma`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `miagnd_unah`.`tipoFechaCronograma` (
  `tipoFechaCronogramaID` INT(11) NOT NULL AUTO_INCREMENT,
  `descripcion` VARCHAR(45) NOT NULL,
  `tipoEstadoID` INT NOT NULL,
  `fechaCreo` DATETIME NOT NULL,
  `fechaElimino` DATETIME NULL,
  `usuarioElimino` INT NULL,
  PRIMARY KEY (`tipoFechaCronogramaID`),
  INDEX `fkFechaCronogramaEstado_idx` (`tipoEstadoID` ASC),
  INDEX `fkFechaCronogramaUsuarioDel_idx` (`usuarioElimino` ASC),
  CONSTRAINT `fkFechaCronogramaEstado`
    FOREIGN KEY (`tipoEstadoID`)
    REFERENCES `miagnd_unah`.`tipo_estado` (`tipoEstadoID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fkFechaCronogramaUsuarioDel`
    FOREIGN KEY (`usuarioElimino`)
    REFERENCES `miagnd_unah`.`usuarios` (`usuarioID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `miagnd_unah`.`periodoAcademico`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `miagnd_unah`.`periodoAcademico` (
  `periodoAcademicoID` INT NOT NULL AUTO_INCREMENT,
  `anioAcademico` INT NOT NULL,
  `descripcion` VARCHAR(45) NULL,
  `tipoEstadoID` INT NOT NULL,
  `fechaCreo` INT NOT NULL,
  `fechaElimino` INT NOT NULL,
  `usuarioElimino` INT NULL,
  PRIMARY KEY (`periodoAcademicoID`),
  INDEX `fkPeriodoEstado_idx` (`tipoEstadoID` ASC),
  INDEX `fkPeriodoUsuarioDel_idx` (`usuarioElimino` ASC),
  CONSTRAINT `fkPeriodoEstado`
    FOREIGN KEY (`tipoEstadoID`)
    REFERENCES `miagnd_unah`.`tipo_estado` (`tipoEstadoID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fkPeriodoUsuarioDel`
    FOREIGN KEY (`usuarioElimino`)
    REFERENCES `miagnd_unah`.`usuarios` (`usuarioID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `miagnd_unah`.`cronogramaAcademico`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `miagnd_unah`.`cronogramaAcademico` (
  `cronogramaAcademicoID` INT(11) NOT NULL AUTO_INCREMENT,
  `periodoAcademicoID` INT(11) NOT NULL,
  `month` INT(11) NOT NULL,
  `fechaCronograma` DATE NOT NULL,
  `tituloCronograma` VARCHAR(45) NOT NULL,
  `description` VARCHAR(200) NOT NULL,
  `tipoFechaCronograma` INT(11) NOT NULL,
  `tipoEstadoID` INT NOT NULL,
  `fechaCreo` DATETIME NOT NULL,
  `fechaElimino` DATETIME NULL,
  `UsuarioElimino` INT NULL,
  PRIMARY KEY (`cronogramaAcademicoID`, `periodoAcademicoID`),
  INDEX `fkCalendarTipo_idx` (`tipoFechaCronograma` ASC),
  INDEX `fkCronogramaEstado_idx` (`tipoEstadoID` ASC),
  INDEX `fkCronogramaUsuarioDel_idx` (`UsuarioElimino` ASC),
  INDEX `fkCronogramaPeriodo_idx` (`periodoAcademicoID` ASC),
  CONSTRAINT `fkCronogramaEstado`
    FOREIGN KEY (`tipoEstadoID`)
    REFERENCES `miagnd_unah`.`tipo_estado` (`tipoEstadoID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fkCronogramaTipoFecha`
    FOREIGN KEY (`tipoFechaCronograma`)
    REFERENCES `miagnd_unah`.`tipoFechaCronograma` (`tipoFechaCronogramaID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fkCronogramaUsuarioDel`
    FOREIGN KEY (`UsuarioElimino`)
    REFERENCES `miagnd_unah`.`usuarios` (`usuarioID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fkCronogramaPeriodo`
    FOREIGN KEY (`periodoAcademicoID`)
    REFERENCES `miagnd_unah`.`periodoAcademico` (`periodoAcademicoID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `miagnd_unah`.`asignaturas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `miagnd_unah`.`asignaturas` (
  `asignaturaID` INT(11) NOT NULL AUTO_INCREMENT,
  `descripcion` VARCHAR(100) NOT NULL,
  `codigoAsignatura` VARCHAR(45) NOT NULL,
  `tipoEstadoID` INT NOT NULL,
  `fechaCreo` DATETIME NOT NULL,
  `fechaElimino` DATETIME NULL,
  `usuarioElimino` INT NULL,
  PRIMARY KEY (`asignaturaID`),
  INDEX `fkAsignaturaEstado_idx` (`tipoEstadoID` ASC),
  INDEX `fkAsignaturaUsuarioDel_idx` (`usuarioElimino` ASC),
  CONSTRAINT `fkAsignaturaEstado`
    FOREIGN KEY (`tipoEstadoID`)
    REFERENCES `miagnd_unah`.`tipo_estado` (`tipoEstadoID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fkAsignaturaUsuarioDel`
    FOREIGN KEY (`usuarioElimino`)
    REFERENCES `miagnd_unah`.`usuarios` (`usuarioID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `miagnd_unah`.`secciones`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `miagnd_unah`.`secciones` (
  `seccionID` INT(11) NOT NULL AUTO_INCREMENT,
  `seccion` VARCHAR(45) NOT NULL,
  `usuarioID` INT(11) NOT NULL,
  `asignaturaID` INT(11) NOT NULL,
  `periodoAcademicoID` INT(11) NOT NULL,
  `horaInicio` INT(11) NOT NULL,
  `horaFin` INT(11) NOT NULL,
  `building` INT(11) NOT NULL,
  `salonClase` INT(11) NOT NULL,
  `tipoEstadoID` INT(11) NOT NULL,
  `fechaCreo` DATETIME NOT NULL,
  `fechaElimino` DATETIME NULL,
  `usuarioElimino` INT NULL,
  PRIMARY KEY (`seccionID`, `usuarioID`, `asignaturaID`, `periodoAcademicoID`),
  INDEX `fkCatedraticoSeccion_idx` (`usuarioID` ASC),
  INDEX `fkMateriaSeccion_idx` (`asignaturaID` ASC),
  INDEX `fkSeccionEstado_idx` (`tipoEstadoID` ASC),
  INDEX `fkSeccionUsuarioDel_idx` (`usuarioElimino` ASC),
  INDEX `fkSeccionPeriodo_idx` (`periodoAcademicoID` ASC),
  CONSTRAINT `fkSeccionUsuario`
    FOREIGN KEY (`usuarioID`)
    REFERENCES `miagnd_unah`.`usuarios` (`usuarioID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fkSeccionAsignatura`
    FOREIGN KEY (`asignaturaID`)
    REFERENCES `miagnd_unah`.`asignaturas` (`asignaturaID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fkSeccionEstado`
    FOREIGN KEY (`tipoEstadoID`)
    REFERENCES `miagnd_unah`.`tipo_estado` (`tipoEstadoID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fkSeccionUsuarioDel`
    FOREIGN KEY (`usuarioElimino`)
    REFERENCES `miagnd_unah`.`usuarios` (`usuarioID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fkSeccionPeriodo`
    FOREIGN KEY (`periodoAcademicoID`)
    REFERENCES `miagnd_unah`.`periodoAcademico` (`periodoAcademicoID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `miagnd_unah`.`publicaciones_asignatura`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `miagnd_unah`.`publicaciones_asignatura` (
  `publicacionAsignaturaID` INT(11) NOT NULL AUTO_INCREMENT,
  `seccionID` INT(11) NOT NULL,
  `usuarioID` INT(11) NOT NULL,
  `tituloPublicacion` VARCHAR(100) NOT NULL,
  `contenidoPublicacion` LONGTEXT NOT NULL,
  `tipoEstadoID` INT NOT NULL,
  `fechaCreo` DATETIME NOT NULL,
  `fechaElimino` DATETIME NULL,
  `UsuarioElimino` INT NULL,
  PRIMARY KEY (`publicacionAsignaturaID`, `seccionID`),
  INDEX `fkPostSeccion_idx` (`seccionID` ASC),
  INDEX `fkPostCatedratico_idx` (`usuarioID` ASC),
  INDEX `fkPublicacionEstado_idx` (`tipoEstadoID` ASC),
  INDEX `fkPublicacionUsuarioDel_idx` (`UsuarioElimino` ASC),
  CONSTRAINT `fkPublicacionSeccion`
    FOREIGN KEY (`seccionID`)
    REFERENCES `miagnd_unah`.`secciones` (`seccionID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fkPublicacionUsuario`
    FOREIGN KEY (`usuarioID`)
    REFERENCES `miagnd_unah`.`usuarios` (`usuarioID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fkPublicacionEstado`
    FOREIGN KEY (`tipoEstadoID`)
    REFERENCES `miagnd_unah`.`tipo_estado` (`tipoEstadoID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fkPublicacionUsuarioDel`
    FOREIGN KEY (`UsuarioElimino`)
    REFERENCES `miagnd_unah`.`usuarios` (`usuarioID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `miagnd_unah`.`solicitud_cuenta`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `miagnd_unah`.`solicitud_cuenta` (
  `solicitudCuentaID` INT(11) NOT NULL,
  `noCuenta` BIGINT(20) NOT NULL,
  `nombres` VARCHAR(200) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `pass` VARCHAR(300) NOT NULL,
  `tipoEstadoID` INT(11) NOT NULL DEFAULT '1',
  `fechaNacimiento` DATETIME NOT NULL,
  `fechaCreo` DATETIME NOT NULL,
  `fechaElimino` DATETIME NULL,
  `usuarioElimino` INT NULL,
  PRIMARY KEY (`solicitudCuentaID`),
  INDEX `fkSolicitudEstado_idx` (`tipoEstadoID` ASC),
  INDEX `fkSolicitudUsuarioDel_idx` (`usuarioElimino` ASC),
  CONSTRAINT `fkSolicitudEstado`
    FOREIGN KEY (`tipoEstadoID`)
    REFERENCES `miagnd_unah`.`tipo_estado` (`tipoEstadoID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fkSolicitudUsuarioDel`
    FOREIGN KEY (`usuarioElimino`)
    REFERENCES `miagnd_unah`.`usuarios` (`usuarioID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `miagnd_unah`.`eventos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `miagnd_unah`.`eventos` (
  `eventoID` INT(11) NOT NULL AUTO_INCREMENT,
  `usuarioID` INT(11) NOT NULL,
  `tituloEvento` VARCHAR(150) NOT NULL,
  `contenidoEvento` LONGTEXT NOT NULL,
  `descripcionNoticia` VARCHAR(200) NOT NULL,
  `imagenPortada` VARCHAR(200) NOT NULL,
  `descripcionImagenPortada` VARCHAR(200) NULL,
  `tipoEstadoID` INT NOT NULL,
  `fechaCreo` DATETIME NOT NULL,
  `fechaElimino` DATETIME NULL,
  `usuarioElimino` INT NULL,
  PRIMARY KEY (`eventoID`),
  INDEX `userID_idx` (`usuarioID` ASC),
  INDEX `fkEventoEstado_idx` (`tipoEstadoID` ASC),
  INDEX `fkEventoUsuarioDel_idx` (`usuarioElimino` ASC),
  CONSTRAINT `fkEventoUsuario`
    FOREIGN KEY (`usuarioID`)
    REFERENCES `miagnd_unah`.`usuarios` (`usuarioID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fkEventoEstado`
    FOREIGN KEY (`tipoEstadoID`)
    REFERENCES `miagnd_unah`.`tipo_estado` (`tipoEstadoID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fkEventoUsuarioDel`
    FOREIGN KEY (`usuarioElimino`)
    REFERENCES `miagnd_unah`.`usuarios` (`usuarioID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `miagnd_unah`.`forma_003`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `miagnd_unah`.`forma_003` (
  `formaID` INT(11) NOT NULL AUTO_INCREMENT,
  `usuarioID` INT(11) NOT NULL,
  `seccionID` INT(11) NOT NULL,
  `tipoEstadoID` INT(11) NOT NULL DEFAULT '1',
  `fechaCreo` DATETIME NOT NULL,
  `fechaElimino` DATETIME NULL,
  `UsuarioElimino` INT NULL,
  PRIMARY KEY (`formaID`, `usuarioID`, `seccionID`),
  INDEX `fkFormaUser_idx` (`usuarioID` ASC),
  INDEX `fkFormaSeccion_idx` (`seccionID` ASC),
  INDEX `fkFormaEstado_idx` (`tipoEstadoID` ASC),
  INDEX `fkFormaUsuarioDel_idx` (`UsuarioElimino` ASC),
  CONSTRAINT `fkFormaUsuario`
    FOREIGN KEY (`usuarioID`)
    REFERENCES `miagnd_unah`.`usuarios` (`usuarioID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fkFormaSeccion`
    FOREIGN KEY (`seccionID`)
    REFERENCES `miagnd_unah`.`secciones` (`seccionID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fkFormaEstado`
    FOREIGN KEY (`tipoEstadoID`)
    REFERENCES `miagnd_unah`.`tipo_estado` (`tipoEstadoID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fkFormaUsuarioDel`
    FOREIGN KEY (`UsuarioElimino`)
    REFERENCES `miagnd_unah`.`usuarios` (`usuarioID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `miagnd_unah`.`noticias`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `miagnd_unah`.`noticias` (
  `noticiaID` INT(11) NOT NULL AUTO_INCREMENT,
  `usuarioID` INT(11) NOT NULL,
  `tituloNoticia` VARCHAR(100) NOT NULL,
  `contenidoNoticia` LONGTEXT NOT NULL,
  `imagenPortada` VARCHAR(200) NOT NULL,
  `descripcionNoticia` VARCHAR(200) NOT NULL,
  `descripcionImagenPortada` VARCHAR(200) NULL,
  `tipoEstadoID` INT NOT NULL,
  `fechaCreo` DATETIME NOT NULL,
  `fechaElimino` DATETIME NULL,
  `usuarioElimino` INT NULL,
  PRIMARY KEY (`noticiaID`),
  INDEX `userID_idx` (`usuarioID` ASC),
  INDEX `fkNoticiaEstado_idx` (`tipoEstadoID` ASC),
  INDEX `fkNoticiaUsuarioDel_idx` (`usuarioElimino` ASC),
  CONSTRAINT `fkNoticiaUsuario`
    FOREIGN KEY (`usuarioID`)
    REFERENCES `miagnd_unah`.`usuarios` (`usuarioID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fkNoticiaEstado`
    FOREIGN KEY (`tipoEstadoID`)
    REFERENCES `miagnd_unah`.`tipo_estado` (`tipoEstadoID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fkNoticiaUsuarioDel`
    FOREIGN KEY (`usuarioElimino`)
    REFERENCES `miagnd_unah`.`usuarios` (`usuarioID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `miagnd_unah`.`comentarios_publicacion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `miagnd_unah`.`comentarios_publicacion` (
  `comentarioPublicacionID` INT(11) NOT NULL AUTO_INCREMENT,
  `publicacionAsignaturaID` INT(11) NOT NULL,
  `usuarioID` INT(11) NOT NULL,
  `comentario` VARCHAR(300) NOT NULL,
  `tipoEstadoID` INT NOT NULL,
  `fechaCreo` DATETIME NOT NULL,
  `fechaElimino` DATETIME NULL,
  `usuarioElimino` INT NULL,
  PRIMARY KEY (`comentarioPublicacionID`, `publicacionAsignaturaID`),
  INDEX `fkUserComment_idx` (`usuarioID` ASC),
  INDEX `fkComentarioPublicacion_idx` (`publicacionAsignaturaID` ASC),
  INDEX `fkComentarioEstado_idx` (`tipoEstadoID` ASC),
  INDEX `fkComentarioUsuarioDel_idx` (`usuarioElimino` ASC),
  CONSTRAINT `fkComentarioPublicacion`
    FOREIGN KEY (`publicacionAsignaturaID`)
    REFERENCES `miagnd_unah`.`publicaciones_asignatura` (`publicacionAsignaturaID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fkComentarioUsuario`
    FOREIGN KEY (`usuarioID`)
    REFERENCES `miagnd_unah`.`usuarios` (`usuarioID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fkComentarioEstado`
    FOREIGN KEY (`tipoEstadoID`)
    REFERENCES `miagnd_unah`.`tipo_estado` (`tipoEstadoID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fkComentarioUsuarioDel`
    FOREIGN KEY (`usuarioElimino`)
    REFERENCES `miagnd_unah`.`usuarios` (`usuarioID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `miagnd_unah`.`calificaciones`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `miagnd_unah`.`calificaciones` (
  `calificacionID` INT(11) NOT NULL,
  `seccionID` INT(11) NOT NULL,
  `usuarioID` INT NOT NULL,
  `periodoAcademicoID` INT(11) NOT NULL,
  `puntajeCalificacion` FLOAT NOT NULL,
  `tipoEstadoID` INT(11) NOT NULL,
  `fechaCreo` DATETIME NOT NULL,
  `fechaElimino` DATETIME NULL,
  `usuarioElimino` INT NULL,
  PRIMARY KEY (`calificacionID`),
  INDEX `fkseccionScore_idx` (`seccionID` ASC),
  INDEX `fkCalificacionNoCuenta_idx` (`usuarioID` ASC),
  INDEX `fkCalificacionEstado_idx` (`tipoEstadoID` ASC),
  INDEX `fkCalificacionUsuarioDel_idx` (`usuarioElimino` ASC),
  INDEX `fkCalificacionPeriodo_idx` (`periodoAcademicoID` ASC),
  CONSTRAINT `fkCalificacionNoCuenta`
    FOREIGN KEY (`usuarioID`)
    REFERENCES `miagnd_unah`.`usuarios` (`usuarioID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fkCalificacionSeccion`
    FOREIGN KEY (`seccionID`)
    REFERENCES `miagnd_unah`.`secciones` (`seccionID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fkCalificacionEstado`
    FOREIGN KEY (`tipoEstadoID`)
    REFERENCES `miagnd_unah`.`tipo_estado` (`tipoEstadoID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fkCalificacionUsuarioDel`
    FOREIGN KEY (`usuarioElimino`)
    REFERENCES `miagnd_unah`.`usuarios` (`usuarioID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fkCalificacionPeriodo`
    FOREIGN KEY (`periodoAcademicoID`)
    REFERENCES `miagnd_unah`.`periodoAcademico` (`periodoAcademicoID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `miagnd_unah`.`solicitud_seccion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `miagnd_unah`.`solicitud_seccion` (
  `solicitudSeccionID` INT(11) NOT NULL AUTO_INCREMENT,
  `asignaturaID` INT(11) NOT NULL,
  `usuarioID` INT(11) NOT NULL,
  `horaSolicitada` INT(11) NOT NULL,
  `fechaCreo` DATETIME NOT NULL,
  `fechaElimino` DATETIME NULL,
  `usuarioElimino` INT NULL,
  PRIMARY KEY (`solicitudSeccionID`),
  INDEX `fkmateriaSeccionRequested_idx` (`asignaturaID` ASC),
  INDEX `fkUserSeccionRequested_idx` (`usuarioID` ASC),
  INDEX `fkSolicitudSeccionUsuarioDel_idx` (`usuarioElimino` ASC),
  CONSTRAINT `fkSolicitudSeccionAsignatura`
    FOREIGN KEY (`asignaturaID`)
    REFERENCES `miagnd_unah`.`asignaturas` (`asignaturaID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fkSolicitudSeccionUsuario`
    FOREIGN KEY (`usuarioID`)
    REFERENCES `miagnd_unah`.`usuarios` (`usuarioID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fkSolicitudSeccionUsuarioDel`
    FOREIGN KEY (`usuarioElimino`)
    REFERENCES `miagnd_unah`.`usuarios` (`usuarioID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- --------------- Insertar Datos -------------------------------

INSERT INTO tipo_estado (descripcion, fechaCreo) VALUES ('Vigente', now());
INSERT INTO tipo_estado (descripcion, fechaCreo) VALUES ('Anulado', now());
INSERT INTO tipo_estado (descripcion, fechaCreo) VALUES ('Eliminado', now());
INSERT INTO tipo_estado (descripcion, fechaCreo) VALUES ('Pendiente', now());
INSERT INTO tipo_estado (descripcion, fechaCreo) VALUES ('Aprobado', now());


INSERT INTO tipo_usuario(descripcion, tipoEstadoID, fechaCreo) VALUES ('Administrador', 1, now());
INSERT INTO tipo_usuario(descripcion, tipoEstadoID, fechaCreo) VALUES ('Alumno', 1, now());
INSERT INTO tipo_usuario(descripcion, tipoEstadoID, fechaCreo) VALUES ('Catedratico', 1, now());
