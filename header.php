<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo constant("SITE_NAME"); ?></title>
    <style>
        :root {
            --bg-color: #ffffff;
            --text-color: #333333;
            --nav-bg: #333;
            --nav-color: white;
            --header-bg: #f8f9fa;
            --border-color: #dee2e6;
        }

        .dark-mode {
            --bg-color: #2c3e50;
            --text-color: #ecf0f1;
            --nav-bg: #34495e;
            --nav-color: #bdc3c7;
            --header-bg: #34495e;
            --border-color: #7f8c8d;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-color);
            transition: background-color 0.3s, color 0.3s;
            margin: 0;
            padding: 0;
        }

        nav { 
            background: var(--nav-bg); 
            padding: 10px; 
            margin: 0;
        }
        
        nav a { 
            color: var(--nav-color); 
            margin: 0 10px; 
            text-decoration: none; 
        }
        
        nav a:hover { 
            text-decoration: underline; 
        }

        .user-header { 
            background: var(--header-bg); 
            padding: 10px; 
            text-align: right;
            border-bottom: 1px solid var(--border-color);
            margin: 0;
        }

        .theme-switcher {
            background: none;
            border: 1px solid var(--border-color);
            color: var(--text-color);
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
            margin-left: 10px;
        }

        .theme-switcher:hover {
            background: var(--border-color);
        }

        table { 
            border-color: var(--border-color) !important;
        }
        
        th { 
            background-color: var(--header-bg) !important;
        }

        /* Mejoras específicas para modo oscuro */
        .dark-mode table {
            background-color: var(--bg-color);
        }

        .dark-mode th {
            background-color: #2c3e50 !important;
            color: var(--text-color);
        }

        .dark-mode td {
            background-color: var(--bg-color);
            color: var(--text-color);
            border-color: #7f8c8d !important;
        }

        .dark-mode .card {
            background: #34495e;
            border-color: #7f8c8d;
        }

        .dark-mode .btn {
            opacity: 0.9;
        }

        .dark-mode .btn:hover {
            opacity: 1;
        }

        .dark-mode input, 
        .dark-mode select, 
        .dark-mode textarea {
            background-color: #2c3e50;
            color: var(--text-color);
            border-color: #7f8c8d;
        }

        .dark-mode .badge {
            background-color: #3498db;
        }

        .dark-mode .form-container,
        .dark-mode .login-container,
        .dark-mode .register-container {
            background: #34495e;
            border-color: #7f8c8d;
        }
    </style>
</head>
<body>
    <nav>
        <a href="index.php">Inicio</a>
        <a href="index.php?controller=baileController&funcion=listar">Bailes</a>
        <a href="index.php?controller=fraternidadController&funcion=listar">Fraternidades</a>
        <a href="index.php?controller=bailarinController&funcion=listar">Bailarines</a>
        <a href="index.php?controller=departamentoController&funcion=listar">Departamentos</a>
        <a href="index.php?controller=entradaController&funcion=listar">Entradas</a>
    </nav>
    
    <?php
    // Definir las variables de sesión aquí, después del nav pero antes de usarlas
    $logged_in = $_SESSION['logged_in'] ?? false;
    $username = $_SESSION['username'] ?? '';
    $es_admin = $_SESSION['es_admin'] ?? false;
    $nombre_usuario = $_SESSION['nombre'] ?? '';
    ?>

    <div class="user-header">
        <?php if($logged_in): ?>
            <span id="user-display">Bienvenido, <strong><?php echo htmlspecialchars($nombre_usuario); ?></strong></span>
            | <a href="index.php?controller=authController&funcion=perfil">Mi Perfil</a>
            | <a href="index.php?controller=puntuacionController&funcion=ranking">Ranking</a>
            <?php if($es_admin): ?>
                | <a href="index.php?controller=fraternidadController&funcion=listar">Admin</a>
            <?php endif; ?>
        <?php else: ?>
            <a href="index.php?controller=authController&funcion=login">Iniciar Sesión</a>
            | <a href="index.php?controller=authController&funcion=register">Registrarse</a>
        <?php endif; ?>
        
        <button class="theme-switcher" id="themeToggle">
            🌙 Modo Oscuro
        </button>
        
        <?php if($logged_in): ?>
            | <a href="index.php?controller=authController&funcion=logout">Cerrar Sesión</a>
        <?php endif; ?>
    </div>

    <h1><?php echo $controllerDinamico->tituloVista; ?></h1>

    <script>
        // Sistema de Modo Oscuro con localStorage
        class GestorTema {
            constructor() {
                this.botonTema = document.getElementById('themeToggle');
                this.temaActual = localStorage.getItem('tema') || 'claro';
                this.inicializar();
            }

            inicializar() {
                // Aplicar tema guardado
                this.aplicarTema(this.temaActual);
                
                // Configurar evento del botón
                if (this.botonTema) {
                    this.botonTema.addEventListener('click', () => {
                        this.cambiarTema();
                    });

                    // Actualizar texto del botón
                    this.actualizarTextoBoton();
                }
            }

            aplicarTema(tema) {
                if (tema === 'oscuro') {
                    document.body.classList.add('dark-mode');
                } else {
                    document.body.classList.remove('dark-mode');
                }
                localStorage.setItem('tema', tema);
            }

            cambiarTema() {
                this.temaActual = this.temaActual === 'claro' ? 'oscuro' : 'claro';
                this.aplicarTema(this.temaActual);
                this.actualizarTextoBoton();
            }

            actualizarTextoBoton() {
                if (this.botonTema) {
                    this.botonTema.textContent = this.temaActual === 'claro' ? '🌙 Modo Oscuro' : '☀️ Modo Claro';
                }
            }
        }

        // Sistema de Información de Usuario con sessionStorage
        class GestorSesionUsuario {
            constructor() {
                this.mostrarUsuario = document.getElementById('user-display');
                this.inicializar();
            }

            inicializar() {
                // Guardar información del usuario en sessionStorage si está logueado
                <?php if($logged_in): ?>
                    const datosUsuario = {
                        nombre: '<?php echo $nombre_usuario; ?>',
                        usuario: '<?php echo $username; ?>',
                        es_administrador: <?php echo $es_admin ? 'true' : 'false'; ?>,
                        horaInicioSesion: new Date().toLocaleString('es-ES')
                    };
                    sessionStorage.setItem('usuarioActual', JSON.stringify(datosUsuario));
                <?php else: ?>
                    // Limpiar sessionStorage si no hay usuario logueado
                    sessionStorage.removeItem('usuarioActual');
                <?php endif; ?>

                // Mostrar información del usuario desde sessionStorage
                this.mostrarInformacionUsuario();
            }

            mostrarInformacionUsuario() {
                const datosUsuario = sessionStorage.getItem('usuarioActual');
                if (datosUsuario && this.mostrarUsuario) {
                    const usuario = JSON.parse(datosUsuario);
                    const tiempoConectado = this.obtenerTiempoConectado(usuario.horaInicioSesion);
                    
                    this.mostrarUsuario.innerHTML = `
                        Bienvenido, <strong>${usuario.nombre}</strong>
                        <small style="font-size: 0.8em; color: #666;">
                            (Conectado desde: ${tiempoConectado})
                        </small>
                    `;
                }
            }

            obtenerTiempoConectado(horaInicio) {
                const fechaInicio = new Date(horaInicio);
                const ahora = new Date();
                const diferenciaMs = ahora - fechaInicio;
                const diferenciaMinutos = Math.floor(diferenciaMs / 60000);
                const diferenciaHoras = Math.floor(diferenciaMinutos / 60);

                if (diferenciaHoras > 0) {
                    return `${diferenciaHoras}h ${diferenciaMinutos % 60}m`;
                } else {
                    return `${diferenciaMinutos}m`;
                }
            }
        }

        // Sistema de Estadísticas de Uso con localStorage
        class EstadisticasUso {
            constructor() {
                this.claveEstadisticas = 'estadisticasAppFolklore';
                this.inicializar();
            }

            inicializar() {
                this.incrementarVistasPagina();
                this.actualizarUltimaVisita();
                this.mostrarEstadisticas();
            }

            incrementarVistasPagina() {
                let estadisticas = this.obtenerEstadisticas();
                estadisticas.totalVistasPagina = (estadisticas.totalVistasPagina || 0) + 1;
                this.guardarEstadisticas(estadisticas);
            }

            actualizarUltimaVisita() {
                let estadisticas = this.obtenerEstadisticas();
                estadisticas.ultimaVisita = new Date().toISOString();
                estadisticas.ultimaVisitaLegible = new Date().toLocaleString('es-ES');
                this.guardarEstadisticas(estadisticas);
            }

            obtenerEstadisticas() {
                return JSON.parse(localStorage.getItem(this.claveEstadisticas) || '{}');
            }

            guardarEstadisticas(estadisticas) {
                localStorage.setItem(this.claveEstadisticas, JSON.stringify(estadisticas));
            }

            mostrarEstadisticas() {
                // Mostrar estadísticas en consola para debugging
                const estadisticas = this.obtenerEstadisticas();
                console.log('📊 Estadísticas de uso de la aplicación:', estadisticas);
            }

            obtenerResumenEstadisticas() {
                const estadisticas = this.obtenerEstadisticas();
                return {
                    totalVistas: estadisticas.totalVistasPagina || 0,
                    ultimaVisita: estadisticas.ultimaVisitaLegible || 'Nunca',
                    primeraVisita: estadisticas.primeraVisita || 'No registrada'
                };
            }
        }

        // Inicializar todos los sistemas cuando el DOM esté listo
        document.addEventListener('DOMContentLoaded', function() {
            new GestorTema();
            new GestorSesionUsuario();
            new EstadisticasUso();

            // Mostrar información de almacenamiento en consola para debugging
            const usuarioSesion = sessionStorage.getItem('usuarioActual');
            console.log('👤 Usuario en sessionStorage:', usuarioSesion ? JSON.parse(usuarioSesion) : 'No hay usuario en sesión');
            console.log('🎨 Tema preferido en localStorage:', localStorage.getItem('tema') || 'claro (por defecto)');
            
            const estadisticas = new EstadisticasUso().obtenerResumenEstadisticas();
            console.log('📈 Resumen de uso:', estadisticas);
        });

        // Función global para cambiar tema desde cualquier lugar
        function cambiarModoOscuro() {
            const temaActual = localStorage.getItem('tema') || 'claro';
            const nuevoTema = temaActual === 'claro' ? 'oscuro' : 'claro';
            
            document.body.classList.toggle('dark-mode', nuevoTema === 'oscuro');
            localStorage.setItem('tema', nuevoTema);
            
            const boton = document.getElementById('themeToggle');
            if (boton) {
                boton.textContent = nuevoTema === 'claro' ? '🌙 Modo Oscuro' : '☀️ Modo Claro';
            }
        }

        // Función para obtener información del usuario actual
        function obtenerUsuarioActual() {
            const usuarioData = sessionStorage.getItem('usuarioActual');
            return usuarioData ? JSON.parse(usuarioData) : null;
        }

        // Función para verificar si el usuario es administrador
        function esUsuarioAdministrador() {
            const usuario = obtenerUsuarioActual();
            return usuario ? usuario.es_administrador : false;
        }
    </script>

    <!-- Panel de información del usuario (visible solo en modo desarrollo) -->
    <div id="panelDebug" style="position: fixed; bottom: 10px; right: 10px; background: rgba(0,0,0,0.8); color: white; padding: 10px; border-radius: 5px; font-size: 12px; display: none; z-index: 1000;">
        <strong>🔧 Información de Depuración:</strong><br>
        <span id="infoSesion"></span><br>
        <span id="infoAlmacenamientoLocal"></span><br>
        <span id="infoEstadisticas"></span>
        <br>
        <button onclick="alternarPanelDebug()" style="margin-top: 5px; font-size: 10px; padding: 2px 5px;">Cerrar Panel</button>
    </div>

    <script>
        // Función para mostrar panel de debug
        function alternarPanelDebug() {
            const panel = document.getElementById('panelDebug');
            panel.style.display = panel.style.display === 'none' ? 'block' : 'none';
            
            if (panel.style.display === 'block') {
                const usuarioSesion = sessionStorage.getItem('usuarioActual');
                const temaLocal = localStorage.getItem('tema');
                const estadisticas = new EstadisticasUso().obtenerResumenEstadisticas();
                
                document.getElementById('infoSesion').textContent = 
                    `Sesión: ${usuarioSesion ? 'Usuario activo' : 'Sin usuario registrado'}`;
                document.getElementById('infoAlmacenamientoLocal').textContent = 
                    `Tema: ${temaLocal || 'claro'} | Vistas: ${estadisticas.totalVistas}`;
                document.getElementById('infoEstadisticas').textContent = 
                    `Última visita: ${estadisticas.ultimaVisita}`;
            }
        }

        // Activar panel de debug con triple click en cualquier parte
        let contadorClicks = 0;
        document.addEventListener('click', function() {
            contadorClicks++;
            setTimeout(() => { contadorClicks = 0; }, 1000);
            
            if (contadorClicks === 3) {
                alternarPanelDebug();
                contadorClicks = 0;
            }
        });

        // Mostrar información de sesión en consola al cargar completamente la página
        window.addEventListener('load', function() {
            const usuarioSesion = sessionStorage.getItem('usuarioActual');
            if (usuarioSesion) {
                const usuario = JSON.parse(usuarioSesion);
                console.log('🎯 Usuario actual en sesión:', usuario.nombre);
                console.log('👨‍💼 Rol:', usuario.es_administrador ? 'Administrador' : 'Usuario normal');
                console.log('⏰ Hora de inicio de sesión:', usuario.horaInicioSesion);
            } else {
                console.log('🔒 No hay usuario en sesión - Modo visitante');
            }
            
            const temaGuardado = localStorage.getItem('tema');
            console.log('🎨 Tema de interfaz:', temaGuardado ? temaGuardado : 'claro (valor por defecto)');
            
            // Mostrar mensaje de bienvenida según el tema
            if (temaGuardado === 'oscuro') {
                console.log('🌙 Interfaz en modo oscuro');
            } else {
                console.log('☀️ Interfaz en modo claro');
            }
        });

        // Función utilitaria para obtener estadísticas rápidas
        function obtenerEstadisticasRapidas() {
            const estadisticas = new EstadisticasUso().obtenerResumenEstadisticas();
            const usuario = obtenerUsuarioActual();
            
            return {
                usuario: usuario ? usuario.nombre : 'Invitado',
                tema: localStorage.getItem('tema') || 'claro',
                vistasTotales: estadisticas.totalVistas,
                ultimaVisita: estadisticas.ultimaVisita,
                enSesion: !!usuario
            };
        }

        // Ejemplo de uso: console.log(obtenerEstadisticasRapidas());
    </script>
</body>
</html>