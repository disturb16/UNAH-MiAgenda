
create database miagnd_unah;

use miagnd_unah;
-- --------------------------------------------------------


--
-- Table structure for table `asignaturas`
--

CREATE TABLE `asignaturas` (
  `asignaturaID` int(11) NOT NULL,
  `descripcion` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `codigoAsignatura` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `tipoEstadoID` int(11) NOT NULL,
  `fechaCreo` datetime NOT NULL,
  `fechaElimino` datetime DEFAULT NULL,
  `usuarioElimino` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `asignaturas`
--

INSERT INTO `asignaturas` (`asignaturaID`, `descripcion`, `codigoAsignatura`, `tipoEstadoID`, `fechaCreo`, `fechaElimino`, `usuarioElimino`) VALUES
(1, 'Redes de Computadoras', 'IA-179', 1, '2017-03-13 00:00:00', NULL, NULL),
(2, 'Base de Datos II', 'IA-137 ', 1, '2017-03-13 00:00:00', NULL, NULL),
(4, 'Metodología de la Programación ', 'IA-033 ', 1, '2017-03-21 16:34:38', NULL, NULL),
(5, 'Programación e  Implementación de Sistemas', 'IA-189', 1, '2017-03-21 16:35:29', NULL, NULL),
(6, 'Comunicación Electrónica  de Datos', 'IA-148', 1, '2017-03-21 16:36:17', NULL, NULL),
(8, 'Contabilidad I', 'CF-014', 1, '2017-03-21 16:38:48', NULL, NULL),
(9, 'Taller de Hardware I', 'IA-023', 1, '2017-03-21 16:39:30', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `calificaciones`
--

CREATE TABLE `calificaciones` (
  `calificacionID` int(11) NOT NULL,
  `seccionID` int(11) NOT NULL,
  `usuarioID` int(11) NOT NULL,
  `periodoAcademicoID` int(11) NOT NULL,
  `puntajeCalificacion` float NOT NULL,
  `tipoEstadoID` int(11) NOT NULL,
  `fechaCreo` datetime NOT NULL,
  `fechaElimino` datetime DEFAULT NULL,
  `usuarioElimino` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comentarios_publicacion`
--

CREATE TABLE `comentarios_publicacion` (
  `comentarioPublicacionID` int(11) NOT NULL,
  `publicacionAsignaturaID` int(11) NOT NULL,
  `usuarioID` int(11) NOT NULL,
  `comentario` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `tipoEstadoID` int(11) NOT NULL,
  `fechaCreo` datetime NOT NULL,
  `fechaElimino` datetime DEFAULT NULL,
  `usuarioElimino` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `comentarios_publicacion`
--

INSERT INTO `comentarios_publicacion` (`comentarioPublicacionID`, `publicacionAsignaturaID`, `usuarioID`, `comentario`, `tipoEstadoID`, `fechaCreo`, `fechaElimino`, `usuarioElimino`) VALUES
(1, 2, 2, 'comentario prueba', 1, '2017-03-13 21:23:57', NULL, NULL),
(2, 4, 1, 'esta bien allí estaremos', 1, '2017-03-14 05:29:07', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cronogramaAcademico`
--

CREATE TABLE `cronogramaAcademico` (
  `cronogramaAcademicoID` int(11) NOT NULL,
  `periodoAcademicoID` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `fechaCronograma` date NOT NULL,
  `tituloCronograma` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `tipoFechaCronogramaID` int(11) NOT NULL,
  `tipoEstadoID` int(11) NOT NULL,
  `fechaCreo` datetime NOT NULL,
  `fechaElimino` datetime DEFAULT NULL,
  `UsuarioElimino` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cronogramaAcademico`
--

INSERT INTO `cronogramaAcademico` (`cronogramaAcademicoID`, `periodoAcademicoID`, `month`, `fechaCronograma`, `tituloCronograma`, `description`, `tipoFechaCronogramaID`, `tipoEstadoID`, `fechaCreo`, `fechaElimino`, `UsuarioElimino`) VALUES
(1, 1, 4, '2017-04-01', 'Graduaciones publicas de Abril', 'Cordialmente invitados todos los alumnos para asistir a este gran evento', 3, 1, '2017-03-12 00:00:00', NULL, NULL),
(2, 1, 4, '2017-04-10', 'Semana Santa', 'Disfruta de esta semana y aprovecha para hacer turismo interno.... sin olvidar tus tareas', 1, 1, '2017-03-12 00:00:00', NULL, NULL),
(3, 1, 4, '2017-04-24', 'Censo de Matricula', 'Censo de Matricula', 2, 1, '2017-03-12 00:00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `eventos`
--

CREATE TABLE `eventos` (
  `eventoID` int(11) NOT NULL,
  `usuarioID` int(11) NOT NULL,
  `tituloEvento` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `contenidoEvento` longtext COLLATE utf8_unicode_ci NOT NULL,
  `descripcionNoticia` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `imagenPortada` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `descripcionImagenPortada` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tipoEstadoID` int(11) NOT NULL,
  `fechaCreo` datetime NOT NULL,
  `fechaElimino` datetime DEFAULT NULL,
  `usuarioElimino` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `eventos`
--

INSERT INTO `eventos` (`eventoID`, `usuarioID`, `tituloEvento`, `contenidoEvento`, `descripcionNoticia`, `imagenPortada`, `descripcionImagenPortada`, `tipoEstadoID`, `fechaCreo`, `fechaElimino`, `usuarioElimino`) VALUES
(1, 1, 'UNAH INAUGURÓ CON ROTUNDO ÉXITO LA PRIMERA FERIA INTERNACIONAL AGROINDUSTRIAL FAI-UNAH 2017', 'Con rotundo éxito, la Universidad Nacional Autónoma de Honduras (UNAH) inauguró la Primera Feria Internacional Agroindustrial FAI-UNAH 2017, evento que se desarrolla del 9 al 11 de marzo en las instalaciones del Palacio Universitario de los Deportes. \r\n\r\nLos actos protocolarios fueron presididos por la rectora Julieta Castellanos y el titular de la Dirección de Vinculación Universidad-Sociedad (DVUS), Ramón Romero. Como invitados especiales se contó con la participación del señor Paolo Santalena, presidente de la Cámara Industrial y Comercio Ítalo-Hondureña.\r\n\r\nAsimismo, este magno evento fue galardonado con destacadas personalidades de organismos internacionales como la señora Pasqualina di Sirio, representante del Programa Mundial de Alimentos (PMA) en Honduras. También asistieron el titular de la Secretaría de Estado de Agricultura y Ganadería (SAG), Jacobo Paz Bodden; el señor Miguel Ángel Bonilla, director ejecutivo de la Fundación Para el Desarrollo Empresarial (Funder), y el señor embajador de la Secretaría de Educación, Harlyn Andino.\r\n\r\nLa rectora de la Alma Máter en su discurso manifestó: “Queremos ratificar el compromiso de una Universidad vinculada a los diferentes sectores productivos, económicos, sociales, gremiales, dispuesta a incorporarse y fortalecer a todas las actividades que contribuyan al desarrollo de Honduras, esperamos en estos tres días verlos en esta casa de estudios”.\r\n\r\nVinculación ítalo-hondureña\r\n\r\nLa Cámara Industrial y Comercio Ítalo-Hondureña en el mundo actualmente está presente en 54 países, su objetivo es fortalecer el intercambio económico comercial y en el tema cultural; en el caso de Honduras, surgió en el 2001 con el entusiasmo de un grupo de empresarios italianos y hondureños con el apoyo de la Embajada de Italia en Honduras.\r\n\r\n“El año pasado en el mes de septiembre firmamos un convenio con la UNAH, porque estamos conscientes de la importancia de la difusión de la cultura, este convenio en el mes de octubre lo llevamos a Italia a un encuentro de la Cámara, que tuvo una excelente aceptación… y por esta razón la Cámara apoya este evento”, indicó Santalena.', 'Con rotundo éxito, la Universidad Nacional Autónoma de Honduras (UNAH) inauguró la Primera Feria Internacional Agroindustrial FAI-UNAH 2017', 'poratadaEvento1.jpg', NULL, 1, '2017-03-12 00:00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `forma_003`
--

CREATE TABLE `forma_003` (
  `formaID` int(11) NOT NULL,
  `usuarioID` int(11) NOT NULL,
  `seccionID` int(11) NOT NULL,
  `tipoEstadoID` int(11) NOT NULL DEFAULT '1',
  `fechaCreo` datetime NOT NULL,
  `fechaElimino` datetime DEFAULT NULL,
  `UsuarioElimino` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `forma_003`
--

INSERT INTO `forma_003` (`formaID`, `usuarioID`, `seccionID`, `tipoEstadoID`, `fechaCreo`, `fechaElimino`, `UsuarioElimino`) VALUES
(1, 1, 1, 1, '2017-03-13 00:00:00', NULL, NULL),
(2, 1, 2, 1, '2017-03-13 00:00:00', NULL, NULL),
(3, 2, 1, 1, '2017-03-13 00:00:00', NULL, NULL),
(4, 2, 2, 1, '2017-03-13 00:00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `noticias`
--

CREATE TABLE `noticias` (
  `noticiaID` int(11) NOT NULL,
  `usuarioID` int(11) NOT NULL,
  `tituloNoticia` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `contenidoNoticia` longtext COLLATE utf8_unicode_ci NOT NULL,
  `imagenPortada` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `descripcionNoticia` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `descripcionImagenPortada` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tipoEstadoID` int(11) NOT NULL,
  `fechaCreo` datetime NOT NULL,
  `fechaElimino` datetime DEFAULT NULL,
  `usuarioElimino` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `noticias`
--

INSERT INTO `noticias` (`noticiaID`, `usuarioID`, `tituloNoticia`, `contenidoNoticia`, `imagenPortada`, `descripcionNoticia`, `descripcionImagenPortada`, `tipoEstadoID`, `fechaCreo`, `fechaElimino`, `usuarioElimino`) VALUES
(1, 1, 'Noticia de Prueba', 'asd auobh suodfg asdgf ag{ado guadfgjkñ\r\n}SDUBG ADFGOA GAG\r\nADFGSDFG SDFGH', 'imagenes/portada_noticias/noticia1Portada.jpg', 'Noticia test', NULL, 1, '2017-03-09 00:00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `periodoAcademico`
--

CREATE TABLE `periodoAcademico` (
  `periodoAcademicoID` int(11) NOT NULL,
  `anioAcademico` int(11) NOT NULL,
  `descripcion` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tipoEstadoID` int(11) NOT NULL,
  `fechaCreo` datetime NOT NULL,
  `fechaElimino` datetime DEFAULT NULL,
  `usuarioElimino` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `periodoAcademico`
--

INSERT INTO `periodoAcademico` (`periodoAcademicoID`, `anioAcademico`, `descripcion`, `tipoEstadoID`, `fechaCreo`, `fechaElimino`, `usuarioElimino`) VALUES
(1, 2017, 'Primer periodo 2017', 1, '2017-03-12 00:00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `publicaciones_asignatura`
--

CREATE TABLE `publicaciones_asignatura` (
  `publicacionAsignaturaID` int(11) NOT NULL,
  `seccionID` int(11) NOT NULL,
  `usuarioID` int(11) NOT NULL,
  `tituloPublicacion` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `contenidoPublicacion` longtext COLLATE utf8_unicode_ci NOT NULL,
  `tipoEstadoID` int(11) NOT NULL,
  `fechaCreo` datetime NOT NULL,
  `fechaElimino` datetime DEFAULT NULL,
  `UsuarioElimino` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `publicaciones_asignatura`
--

INSERT INTO `publicaciones_asignatura` (`publicacionAsignaturaID`, `seccionID`, `usuarioID`, `tituloPublicacion`, `contenidoPublicacion`, `tipoEstadoID`, `fechaCreo`, `fechaElimino`, `UsuarioElimino`) VALUES
(2, 1, 2, 'test', 'ufhf v ufhf virus', 1, '2017-03-13 00:00:00', NULL, NULL),
(3, 2, 2, 'kshff7', 'prueba de deshabitado botón ', 1, '2017-03-13 00:00:00', NULL, NULL),
(4, 1, 2, 'segunda publicacion', 'esto es una publicación de prueba, no falten mañana. ', 1, '2017-03-14 00:00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `secciones`
--

CREATE TABLE `secciones` (
  `seccionID` int(11) NOT NULL,
  `seccion` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `usuarioID` int(11) NOT NULL,
  `asignaturaID` int(11) NOT NULL,
  `periodoAcademicoID` int(11) NOT NULL,
  `horaInicio` int(11) NOT NULL,
  `horaFin` int(11) NOT NULL,
  `edificio` int(11) NOT NULL,
  `salonClase` int(11) NOT NULL,
  `tipoEstadoID` int(11) NOT NULL,
  `fechaCreo` datetime NOT NULL,
  `fechaElimino` datetime DEFAULT NULL,
  `usuarioElimino` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `secciones`
--

INSERT INTO `secciones` (`seccionID`, `seccion`, `usuarioID`, `asignaturaID`, `periodoAcademicoID`, `horaInicio`, `horaFin`, `edificio`, `salonClase`, `tipoEstadoID`, `fechaCreo`, `fechaElimino`, `usuarioElimino`) VALUES
(1, '1701', 1, 1, 1, 17, 18, 5, 407, 1, '2017-03-13 00:00:00', NULL, NULL),
(2, '1900', 1, 2, 1, 19, 20, 5, 305, 1, '2017-03-13 00:00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `solicitud_cuenta`
--

CREATE TABLE `solicitud_cuenta` (
  `solicitudCuentaID` int(11) NOT NULL,
  `noCuenta` bigint(20) NOT NULL,
  `nombres` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `pass` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `tipoEstadoID` int(11) NOT NULL DEFAULT '1',
  `fechaNacimiento` datetime NOT NULL,
  `fechaCreo` datetime NOT NULL,
  `fechaElimino` datetime DEFAULT NULL,
  `usuarioElimino` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `solicitud_cuenta`
--

INSERT INTO `solicitud_cuenta` (`solicitudCuentaID`, `noCuenta`, `nombres`, `email`, `pass`, `tipoEstadoID`, `fechaNacimiento`, `fechaCreo`, `fechaElimino`, `usuarioElimino`) VALUES
(1, 20112001985, 'asdasdasd', 'asdasdasd@asdas.com', '81dc9bdb52d04dc20036dbd8313ed055', 5, '1998-02-01 00:00:00', '2017-03-16 21:09:53', NULL, NULL),
(2, 20112001234, 'Kratos', 'has@jfd.com', '81dc9bdb52d04dc20036dbd8313ed055', 5, '1992-02-19 00:00:00', '2017-03-16 21:11:13', NULL, NULL),
(3, 20112001234, 'Ydhf', 'hxhd', 'c4ca4238a0b923820dcc509a6f75849b', 5, '1990-02-01 00:00:00', '2017-03-16 21:11:46', NULL, NULL),
(4, 2011200, 'Sthgefc', 'fjf', 'c4ca4238a0b923820dcc509a6f75849b', 5, '1990-02-01 00:00:00', '2017-03-16 21:16:57', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `solicitud_seccion`
--

CREATE TABLE `solicitud_seccion` (
  `solicitudSeccionID` int(11) NOT NULL,
  `asignaturaID` int(11) NOT NULL,
  `usuarioID` int(11) NOT NULL,
  `horaSolicitada` int(11) NOT NULL,
  `fechaCreo` datetime NOT NULL,
  `fechaElimino` datetime DEFAULT NULL,
  `usuarioElimino` int(11) DEFAULT NULL,
  `tipoEstadoID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `solicitud_seccion`
--

INSERT INTO `solicitud_seccion` (`solicitudSeccionID`, `asignaturaID`, `usuarioID`, `horaSolicitada`, `fechaCreo`, `fechaElimino`, `usuarioElimino`, `tipoEstadoID`) VALUES
(1, 1, 1, 7, '2017-03-16 21:42:28', NULL, NULL, 5),
(2, 1, 1, 3, '2017-03-22 01:34:44', NULL, NULL, 5),
(3, 1, 1, 7, '2017-03-22 01:34:50', NULL, NULL, 5);

-- --------------------------------------------------------

--
-- Table structure for table `tipoFechaCronograma`
--

CREATE TABLE `tipoFechaCronograma` (
  `tipoFechaCronogramaID` int(11) NOT NULL,
  `descripcion` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `tipoEstadoID` int(11) NOT NULL,
  `fechaCreo` datetime NOT NULL,
  `fechaElimino` datetime DEFAULT NULL,
  `usuarioElimino` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tipoFechaCronograma`
--

INSERT INTO `tipoFechaCronograma` (`tipoFechaCronogramaID`, `descripcion`, `tipoEstadoID`, `fechaCreo`, `fechaElimino`, `usuarioElimino`) VALUES
(1, 'Vacaciones y Feriados', 1, '2017-03-12 00:00:00', NULL, NULL),
(2, 'Censo de Matricula', 1, '2017-03-12 00:00:00', NULL, NULL),
(3, 'Graduaciones Públicas', 1, '2017-03-12 00:00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tipo_estado`
--

CREATE TABLE `tipo_estado` (
  `tipoEstadoID` int(11) NOT NULL COMMENT '1 = Vigente, 2 = Anulado, 3 = Eliminado, 4 = Pendiente, 5 = Aprobado',
  `descripcion` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `fechaCreo` datetime NOT NULL,
  `fechaElimino` datetime DEFAULT NULL,
  `usuarioElimino` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tipo_estado`
--

INSERT INTO `tipo_estado` (`tipoEstadoID`, `descripcion`, `fechaCreo`, `fechaElimino`, `usuarioElimino`) VALUES
(1, 'Vigente', '2017-03-09 19:59:55', NULL, NULL),
(2, 'Anulado', '2017-03-09 19:59:55', NULL, NULL),
(3, 'Eliminado', '2017-03-09 19:59:55', NULL, NULL),
(4, 'Aprobado', '2017-03-09 19:59:55', NULL, NULL),
(5, 'Pendiente', '2017-03-09 19:59:55', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tipo_usuario`
--

CREATE TABLE `tipo_usuario` (
  `tipoUsuarioID` int(11) NOT NULL,
  `descripcion` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `tipoEstadoID` int(11) NOT NULL,
  `fechaCreo` datetime NOT NULL,
  `fechaElimino` datetime DEFAULT NULL,
  `usuarioElimino` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tipo_usuario`
--

INSERT INTO `tipo_usuario` (`tipoUsuarioID`, `descripcion`, `tipoEstadoID`, `fechaCreo`, `fechaElimino`, `usuarioElimino`) VALUES
(1, 'Administrador', 1, '2017-03-09 19:59:55', NULL, NULL),
(2, 'Alumno', 1, '2017-03-09 19:59:55', NULL, NULL),
(3, 'Catedratico', 1, '2017-03-09 19:59:55', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `usuarioID` int(11) NOT NULL,
  `userName` varchar(90) COLLATE utf8_unicode_ci NOT NULL,
  `nombres` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `pass` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `noCuenta` bigint(20) NOT NULL,
  `fechaNacimiento` datetime NOT NULL,
  `tipoUsuarioID` int(11) NOT NULL,
  `profilePicture` longtext COLLATE utf8_unicode_ci,
  `fechaCreo` datetime NOT NULL,
  `fechaElimino` datetime DEFAULT NULL,
  `usuarioElimino` int(11) DEFAULT NULL,
  `tipoEstadoID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`usuarioID`, `userName`, `nombres`, `pass`, `noCuenta`, `fechaNacimiento`, `tipoUsuarioID`, `profilePicture`, `fechaCreo`, `fechaElimino`, `usuarioElimino`, `tipoEstadoID`) VALUES
(1, 'disturb', 'Juan Jose Ramos', '81dc9bdb52d04dc20036dbd8313ed055', 20112001946, '1992-06-21 00:00:00', 1, 'perfil_no_photo.png', '2017-03-09 00:00:00', NULL, NULL, 1),
(2, 'AllanW', 'Allan Wake', '81dc9bdb52d04dc20036dbd8313ed055', 20102002020, '1987-02-18 00:00:00', 3, 'perfil_no_photo.png', '2017-03-13 00:00:00', NULL, NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `asignaturas`
--
ALTER TABLE `asignaturas`
  ADD PRIMARY KEY (`asignaturaID`),
  ADD KEY `fkAsignaturaEstado_idx` (`tipoEstadoID`),
  ADD KEY `fkAsignaturaUsuarioDel_idx` (`usuarioElimino`);

--
-- Indexes for table `calificaciones`
--
ALTER TABLE `calificaciones`
  ADD PRIMARY KEY (`calificacionID`),
  ADD KEY `fkseccionScore_idx` (`seccionID`),
  ADD KEY `fkCalificacionNoCuenta_idx` (`usuarioID`),
  ADD KEY `fkCalificacionEstado_idx` (`tipoEstadoID`),
  ADD KEY `fkCalificacionUsuarioDel_idx` (`usuarioElimino`),
  ADD KEY `fkCalificacionPeriodo_idx` (`periodoAcademicoID`);

--
-- Indexes for table `comentarios_publicacion`
--
ALTER TABLE `comentarios_publicacion`
  ADD PRIMARY KEY (`comentarioPublicacionID`,`publicacionAsignaturaID`),
  ADD KEY `fkUserComment_idx` (`usuarioID`),
  ADD KEY `fkComentarioPublicacion_idx` (`publicacionAsignaturaID`),
  ADD KEY `fkComentarioEstado_idx` (`tipoEstadoID`),
  ADD KEY `fkComentarioUsuarioDel_idx` (`usuarioElimino`);

--
-- Indexes for table `cronogramaAcademico`
--
ALTER TABLE `cronogramaAcademico`
  ADD PRIMARY KEY (`cronogramaAcademicoID`,`periodoAcademicoID`),
  ADD KEY `fkCalendarTipo_idx` (`tipoFechaCronogramaID`),
  ADD KEY `fkCronogramaEstado_idx` (`tipoEstadoID`),
  ADD KEY `fkCronogramaUsuarioDel_idx` (`UsuarioElimino`),
  ADD KEY `fkCronogramaPeriodo_idx` (`periodoAcademicoID`);

--
-- Indexes for table `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`eventoID`),
  ADD KEY `userID_idx` (`usuarioID`),
  ADD KEY `fkEventoEstado_idx` (`tipoEstadoID`),
  ADD KEY `fkEventoUsuarioDel_idx` (`usuarioElimino`);

--
-- Indexes for table `forma_003`
--
ALTER TABLE `forma_003`
  ADD PRIMARY KEY (`formaID`,`usuarioID`,`seccionID`),
  ADD KEY `fkFormaUser_idx` (`usuarioID`),
  ADD KEY `fkFormaSeccion_idx` (`seccionID`),
  ADD KEY `fkFormaEstado_idx` (`tipoEstadoID`),
  ADD KEY `fkFormaUsuarioDel_idx` (`UsuarioElimino`);

--
-- Indexes for table `noticias`
--
ALTER TABLE `noticias`
  ADD PRIMARY KEY (`noticiaID`),
  ADD KEY `userID_idx` (`usuarioID`),
  ADD KEY `fkNoticiaEstado_idx` (`tipoEstadoID`),
  ADD KEY `fkNoticiaUsuarioDel_idx` (`usuarioElimino`);

--
-- Indexes for table `periodoAcademico`
--
ALTER TABLE `periodoAcademico`
  ADD PRIMARY KEY (`periodoAcademicoID`),
  ADD KEY `fkPeriodoEstado_idx` (`tipoEstadoID`),
  ADD KEY `fkPeriodoUsuarioDel_idx` (`usuarioElimino`);

--
-- Indexes for table `publicaciones_asignatura`
--
ALTER TABLE `publicaciones_asignatura`
  ADD PRIMARY KEY (`publicacionAsignaturaID`,`seccionID`),
  ADD KEY `fkPostSeccion_idx` (`seccionID`),
  ADD KEY `fkPostCatedratico_idx` (`usuarioID`),
  ADD KEY `fkPublicacionEstado_idx` (`tipoEstadoID`),
  ADD KEY `fkPublicacionUsuarioDel_idx` (`UsuarioElimino`);

--
-- Indexes for table `secciones`
--
ALTER TABLE `secciones`
  ADD PRIMARY KEY (`seccionID`,`usuarioID`,`asignaturaID`,`periodoAcademicoID`),
  ADD KEY `fkCatedraticoSeccion_idx` (`usuarioID`),
  ADD KEY `fkMateriaSeccion_idx` (`asignaturaID`),
  ADD KEY `fkSeccionEstado_idx` (`tipoEstadoID`),
  ADD KEY `fkSeccionUsuarioDel_idx` (`usuarioElimino`),
  ADD KEY `fkSeccionPeriodo_idx` (`periodoAcademicoID`);

--
-- Indexes for table `solicitud_cuenta`
--
ALTER TABLE `solicitud_cuenta`
  ADD PRIMARY KEY (`solicitudCuentaID`),
  ADD KEY `fkSolicitudEstado_idx` (`tipoEstadoID`),
  ADD KEY `fkSolicitudUsuarioDel_idx` (`usuarioElimino`);

--
-- Indexes for table `solicitud_seccion`
--
ALTER TABLE `solicitud_seccion`
  ADD PRIMARY KEY (`solicitudSeccionID`),
  ADD KEY `fkmateriaSeccionRequested_idx` (`asignaturaID`),
  ADD KEY `fkUserSeccionRequested_idx` (`usuarioID`),
  ADD KEY `fkSolicitudSeccionUsuarioDel_idx` (`usuarioElimino`),
  ADD KEY `fkSolicitudSeccionEstado` (`tipoEstadoID`);

--
-- Indexes for table `tipoFechaCronograma`
--
ALTER TABLE `tipoFechaCronograma`
  ADD PRIMARY KEY (`tipoFechaCronogramaID`),
  ADD KEY `fkFechaCronogramaEstado_idx` (`tipoEstadoID`),
  ADD KEY `fkFechaCronogramaUsuarioDel_idx` (`usuarioElimino`);

--
-- Indexes for table `tipo_estado`
--
ALTER TABLE `tipo_estado`
  ADD PRIMARY KEY (`tipoEstadoID`);

--
-- Indexes for table `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  ADD PRIMARY KEY (`tipoUsuarioID`),
  ADD KEY `fkTPUsuarioEstado_idx` (`tipoEstadoID`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`usuarioID`),
  ADD UNIQUE KEY `userName_UNIQUE` (`userName`),
  ADD KEY `fkUsuarioTPUsuario_idx` (`tipoUsuarioID`),
  ADD KEY `fkUsuarioEstado_idx` (`tipoEstadoID`),
  ADD KEY `fkUsuario_usuarioDel_idx` (`usuarioElimino`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `asignaturas`
--
ALTER TABLE `asignaturas`
  MODIFY `asignaturaID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `comentarios_publicacion`
--
ALTER TABLE `comentarios_publicacion`
  MODIFY `comentarioPublicacionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `cronogramaAcademico`
--
ALTER TABLE `cronogramaAcademico`
  MODIFY `cronogramaAcademicoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `eventos`
--
ALTER TABLE `eventos`
  MODIFY `eventoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `forma_003`
--
ALTER TABLE `forma_003`
  MODIFY `formaID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `noticias`
--
ALTER TABLE `noticias`
  MODIFY `noticiaID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `periodoAcademico`
--
ALTER TABLE `periodoAcademico`
  MODIFY `periodoAcademicoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `publicaciones_asignatura`
--
ALTER TABLE `publicaciones_asignatura`
  MODIFY `publicacionAsignaturaID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `secciones`
--
ALTER TABLE `secciones`
  MODIFY `seccionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `solicitud_cuenta`
--
ALTER TABLE `solicitud_cuenta`
  MODIFY `solicitudCuentaID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `solicitud_seccion`
--
ALTER TABLE `solicitud_seccion`
  MODIFY `solicitudSeccionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tipoFechaCronograma`
--
ALTER TABLE `tipoFechaCronograma`
  MODIFY `tipoFechaCronogramaID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tipo_estado`
--
ALTER TABLE `tipo_estado`
  MODIFY `tipoEstadoID` int(11) NOT NULL AUTO_INCREMENT COMMENT '1 = Vigente, 2 = Anulado, 3 = Eliminado, 4 = Pendiente, 5 = Aprobado', AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  MODIFY `tipoUsuarioID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `usuarioID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `asignaturas`
--
ALTER TABLE `asignaturas`
  ADD CONSTRAINT `fkAsignaturaEstado` FOREIGN KEY (`tipoEstadoID`) REFERENCES `tipo_estado` (`tipoEstadoID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fkAsignaturaUsuarioDel` FOREIGN KEY (`usuarioElimino`) REFERENCES `usuarios` (`usuarioID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `calificaciones`
--
ALTER TABLE `calificaciones`
  ADD CONSTRAINT `fkCalificacionEstado` FOREIGN KEY (`tipoEstadoID`) REFERENCES `tipo_estado` (`tipoEstadoID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fkCalificacionNoCuenta` FOREIGN KEY (`usuarioID`) REFERENCES `usuarios` (`usuarioID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fkCalificacionPeriodo` FOREIGN KEY (`periodoAcademicoID`) REFERENCES `periodoAcademico` (`periodoAcademicoID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fkCalificacionSeccion` FOREIGN KEY (`seccionID`) REFERENCES `secciones` (`seccionID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fkCalificacionUsuarioDel` FOREIGN KEY (`usuarioElimino`) REFERENCES `usuarios` (`usuarioID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `comentarios_publicacion`
--
ALTER TABLE `comentarios_publicacion`
  ADD CONSTRAINT `fkComentarioEstado` FOREIGN KEY (`tipoEstadoID`) REFERENCES `tipo_estado` (`tipoEstadoID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fkComentarioPublicacion` FOREIGN KEY (`publicacionAsignaturaID`) REFERENCES `publicaciones_asignatura` (`publicacionAsignaturaID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fkComentarioUsuario` FOREIGN KEY (`usuarioID`) REFERENCES `usuarios` (`usuarioID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fkComentarioUsuarioDel` FOREIGN KEY (`usuarioElimino`) REFERENCES `usuarios` (`usuarioID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `cronogramaAcademico`
--
ALTER TABLE `cronogramaAcademico`
  ADD CONSTRAINT `fkCronogramaEstado` FOREIGN KEY (`tipoEstadoID`) REFERENCES `tipo_estado` (`tipoEstadoID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fkCronogramaPeriodo` FOREIGN KEY (`periodoAcademicoID`) REFERENCES `periodoAcademico` (`periodoAcademicoID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fkCronogramaTipoFecha` FOREIGN KEY (`tipoFechaCronogramaID`) REFERENCES `tipoFechaCronograma` (`tipoFechaCronogramaID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fkCronogramaUsuarioDel` FOREIGN KEY (`UsuarioElimino`) REFERENCES `usuarios` (`usuarioID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `eventos`
--
ALTER TABLE `eventos`
  ADD CONSTRAINT `fkEventoEstado` FOREIGN KEY (`tipoEstadoID`) REFERENCES `tipo_estado` (`tipoEstadoID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fkEventoUsuario` FOREIGN KEY (`usuarioID`) REFERENCES `usuarios` (`usuarioID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fkEventoUsuarioDel` FOREIGN KEY (`usuarioElimino`) REFERENCES `usuarios` (`usuarioID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `forma_003`
--
ALTER TABLE `forma_003`
  ADD CONSTRAINT `fkFormaEstado` FOREIGN KEY (`tipoEstadoID`) REFERENCES `tipo_estado` (`tipoEstadoID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fkFormaSeccion` FOREIGN KEY (`seccionID`) REFERENCES `secciones` (`seccionID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fkFormaUsuario` FOREIGN KEY (`usuarioID`) REFERENCES `usuarios` (`usuarioID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fkFormaUsuarioDel` FOREIGN KEY (`UsuarioElimino`) REFERENCES `usuarios` (`usuarioID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `noticias`
--
ALTER TABLE `noticias`
  ADD CONSTRAINT `fkNoticiaEstado` FOREIGN KEY (`tipoEstadoID`) REFERENCES `tipo_estado` (`tipoEstadoID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fkNoticiaUsuario` FOREIGN KEY (`usuarioID`) REFERENCES `usuarios` (`usuarioID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fkNoticiaUsuarioDel` FOREIGN KEY (`usuarioElimino`) REFERENCES `usuarios` (`usuarioID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `periodoAcademico`
--
ALTER TABLE `periodoAcademico`
  ADD CONSTRAINT `fkPeriodoEstado` FOREIGN KEY (`tipoEstadoID`) REFERENCES `tipo_estado` (`tipoEstadoID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fkPeriodoUsuarioDel` FOREIGN KEY (`usuarioElimino`) REFERENCES `usuarios` (`usuarioID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `publicaciones_asignatura`
--
ALTER TABLE `publicaciones_asignatura`
  ADD CONSTRAINT `fkPublicacionEstado` FOREIGN KEY (`tipoEstadoID`) REFERENCES `tipo_estado` (`tipoEstadoID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fkPublicacionSeccion` FOREIGN KEY (`seccionID`) REFERENCES `secciones` (`seccionID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fkPublicacionUsuario` FOREIGN KEY (`usuarioID`) REFERENCES `usuarios` (`usuarioID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fkPublicacionUsuarioDel` FOREIGN KEY (`UsuarioElimino`) REFERENCES `usuarios` (`usuarioID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `secciones`
--
ALTER TABLE `secciones`
  ADD CONSTRAINT `fkSeccionAsignatura` FOREIGN KEY (`asignaturaID`) REFERENCES `asignaturas` (`asignaturaID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fkSeccionEstado` FOREIGN KEY (`tipoEstadoID`) REFERENCES `tipo_estado` (`tipoEstadoID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fkSeccionPeriodo` FOREIGN KEY (`periodoAcademicoID`) REFERENCES `periodoAcademico` (`periodoAcademicoID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fkSeccionUsuario` FOREIGN KEY (`usuarioID`) REFERENCES `usuarios` (`usuarioID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fkSeccionUsuarioDel` FOREIGN KEY (`usuarioElimino`) REFERENCES `usuarios` (`usuarioID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `solicitud_cuenta`
--
ALTER TABLE `solicitud_cuenta`
  ADD CONSTRAINT `fkSolicitudEstado` FOREIGN KEY (`tipoEstadoID`) REFERENCES `tipo_estado` (`tipoEstadoID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fkSolicitudUsuarioDel` FOREIGN KEY (`usuarioElimino`) REFERENCES `usuarios` (`usuarioID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `solicitud_seccion`
--
ALTER TABLE `solicitud_seccion`
  ADD CONSTRAINT `fkSolicitudSeccionAsignatura` FOREIGN KEY (`asignaturaID`) REFERENCES `asignaturas` (`asignaturaID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fkSolicitudSeccionEstado` FOREIGN KEY (`tipoEstadoID`) REFERENCES `tipo_estado` (`tipoEstadoID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fkSolicitudSeccionUsuario` FOREIGN KEY (`usuarioID`) REFERENCES `usuarios` (`usuarioID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fkSolicitudSeccionUsuarioDel` FOREIGN KEY (`usuarioElimino`) REFERENCES `usuarios` (`usuarioID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tipoFechaCronograma`
--
ALTER TABLE `tipoFechaCronograma`
  ADD CONSTRAINT `fkFechaCronogramaEstado` FOREIGN KEY (`tipoEstadoID`) REFERENCES `tipo_estado` (`tipoEstadoID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fkFechaCronogramaUsuarioDel` FOREIGN KEY (`usuarioElimino`) REFERENCES `usuarios` (`usuarioID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  ADD CONSTRAINT `fkTPUsuarioEstado` FOREIGN KEY (`tipoEstadoID`) REFERENCES `tipo_estado` (`tipoEstadoID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fkUsuarioEstado` FOREIGN KEY (`tipoEstadoID`) REFERENCES `tipo_estado` (`tipoEstadoID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fkUsuarioTPUsuario` FOREIGN KEY (`tipoUsuarioID`) REFERENCES `tipo_usuario` (`tipoUsuarioID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fkUsuario_usuarioDel` FOREIGN KEY (`usuarioElimino`) REFERENCES `usuarios` (`usuarioID`) ON DELETE NO ACTION ON UPDATE NO ACTION;
