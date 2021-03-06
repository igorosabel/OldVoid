<?php
$locale = [
	'ERROR_TITLE' => 'Error',
	'ERROR_403_LABEL' => '403 Error de autenticación',
	'ERROR_404_LABEL' => '404 Página no encontrada',
	'ERROR_NO_MODULE_LABEL' => 'Módulo <strong>%s</strong> no encontrado',
	'ERROR_NO_ACTION_LABEL' => 'Función <strong>%s</strong> no encontrada en módulo <strong>%s</strong>',
	'ERROR_SEE_MORE_LABEL' => 'Ver más detalles',
	'TASK_BACKUP_ALL' => 'Función para crear una copia de seguridad de TODA la aplicación (base de datos más archivos).',
	'TASK_BACKUP_ALL_DONE' => 'Copia de seguridad completada.',
	'TASK_BACKUP_DB' => 'Función para crear una copia de seguridad de la base de datos.',
	'TASK_BACKUP_DB_NO_DB' => 'No hay ninguna base de datos configurada.',
	'TASK_BACKUP_DB_EXPORTING' => "  Exportando base de datos \"%s\" al archivo \"%s\"\n\n",
	'TASK_BACKUP_DB_EXISTS' => "    Archivo destino ya existía, se ha borrado.\n\n",
	'TASK_BACKUP_DB_SUCCESS' => "  Base de datos exportada con éxito.\n\n",
	'TASK_EXTRACTOR' => 'Función para exportar una aplicación con todos sus archivos a un solo archivo autoextraíble.',
	'TASK_EXTRACTOR_EXPORTING' => 'Exportando proyecto',
	'TASK_EXTRACTOR_EXISTS' => "    Archivo destino ya existía, se ha borrado.\n\n",
	'TASK_EXTRACTOR_GETTING_FILES' => "  Obteniendo carpetas y archivos a exportar...\n",
	'TASK_EXTRACTOR_EXPORTING_FILES' => "  Exportando %s archivos.\n",
	'TASK_EXTRACTOR_EXPORTING_FOLDERS' => "  Exportando %s carpetas.\n",
	'TASK_EXTRACTOR_GETTING_READY' => "  Preparando composer...\n",
	'TASK_EXTRACTOR_BASE_FOLDER' => 'RUTA BASE',
	'TASK_EXTRACTOR_CREATE_FOLDERS' => 'CREANDO CARPETAS',
	'TASK_EXTRACTOR_CREATE_FILES' => 'CREANDO ARCHIVOS',
	'TASK_EXTRACTOR_END' => 'Proyecto exportado.',
	'TASK_GENERATE_MODEL' => 'Función para generar el script con el que crear la base de datos a partir del modelo.',
	'TASK_GENERATE_MODEL_MODEL' => "Modelo\n\n",
	'TASK_PLUGINS' => 'Función para obtener el listado de plugins disponibles.',
	'TASK_PLUGINS_AVAILABLE_TITLE' => "  Listado de plugins disponibles:\n\n",
	'TASK_PLUGINS_AVAILABLE_INSTALL' => "  Para instalar cualquiera de estos plugins ejecuta el siguiente comando:\n\n",
	'TASK_PLUGINS_AVAILABLE_LIST' => "  También puedes ver el listado de plugins que tienes actualmente instalados ejecutando el siguiente comando:\n\n",
	'TASK_PLUGINS_AVAILABLE_DELETE' => "  Para borrar un plugin instalado actualmente ejecuta el siguiente comando:\n\n",
	'TASK_PLUGINS_AVAILABLE_NAME' => 'nombre',
	'TASK_PLUGINS_INSTALL_ERROR' => 'Debes indicar el nombre del plugin que quieres instalar, por ejemplo:',
	'TASK_PLUGINS_INSTALL_NOT_AVAILABLE' => 'El plugin indicado no existe en la lista de plugins instalables.',
	'TASK_PLUGINS_INSTALL_CHECK_LIST' => "  Comprueba la lista ejecutando el siguiente comando:\n\n",
	'TASK_PLUGINS_INSTALL_FOLDER_EXISTS' => 'La carpeta "%s" ya existe.',
	'TASK_PLUGINS_INSTALL_CREATE_FOLDER' => "  Nueva carpeta creada: \"%s\"\n",
	'TASK_PLUGINS_INSTALL_CREATE_CONFIG' => "  Creado archivo de configuración del plugin: \"%s/%s.json\"\n",
	'TASK_PLUGINS_INSTALL_CREATE_FILE' => "  Creado archivo del plugin: \"%s/%s\"\n",
	'TASK_PLUGINS_INSTALL_DOWNLOAD_DEPS' => "  Descargando dependencias:\n",
	'TASK_PLUGINS_INSTALL_NEW_DEP' => "    Nuevo archivo creado: \"%s/dependencies/%s\"\n",
	'TASK_PLUGINS_INSTALL_UPDATED' => "  Listado de plugins actualizado.\n\n",
	'TASK_PLUGINS_INSTALL_DONE' => "  Instalación finalizada.\n\n",
	'TASK_PLUGINS_INSTALLED' => "  Plugins instalados:\n\n",
	'TASK_PLUGINS_INSTALLED_NONE' => "  No tienes instalado ningún plugin.\n\n",
	'TASK_PLUGINS_REMOVE_ERROR' => 'Debes indicar el nombre del plugin que quieres desinstalar, por ejemplo:',
	'TASK_PLUGINS_REMOVE_NOT_INSTALLED' => 'El plugin indicado no está instalado.',
	'TASK_PLUGINS_REMOVE_CHECK_LIST' => "  Comprueba la lista ejecutando el siguiente comando:\n\n",
	'TASK_PLUGINS_REMOVE_FOLDER_NOT_FOUND' => 'La carpeta "%s" no existe.',
	'TASK_PLUGINS_REMOVE_CONF_REMOVED' => "  Archivo de configuración \"%s/%s.json\" borrado.\n",
	'TASK_PLUGINS_REMOVE_PLUGIN_REMOVED' => "  Archivo de plugin \"%s/%s\" borrado.\n",
	'TASK_PLUGINS_REMOVE_REMOVING_DEPS' => "  Borrando dependencias...\n",
	'TASK_PLUGINS_REMOVE_DEP_REMOVED' => "    Archivo \"%s\" borrado.\n",
	'TASK_PLUGINS_REMOVE_DEP_FOLDER_REMOVED' => "  Carpeta de dependencias \"%s/dependencies\" borrada.\n",
	'TASK_PLUGINS_REMOVE_FOLDER_REMOVED' => "  Carpeta de plugin \"%s\" borrada.\n",
	'TASK_PLUGINS_REMOVE_LIST_UPDATED' => "  Listado de plugins actualizado.\n\n",
	'TASK_PLUGINS_REMOVE_PLUGINS_REMOVED' => "  Se ha borrado el archivo de configuración \"%s\" por que no hay ningún plugin instalado actualmente.\n\n",
	'TASK_PLUGINS_REMOVE_DONE' => "  Borrado finalizado.\n\n",
	'TASK_PLUGINS_UPDATE_CHECK_NO_PLUGINS' => " No hay ningún plugin instalado.\n",
	'TASK_PLUGINS_UPDATE_CHECK_CHECKING' => "  Buscando actualizaciones...\n\n",
	'TASK_PLUGINS_UPDATE_CHECK_VERSION' => "    Versión instalada: %s\n",
	'TASK_PLUGINS_UPDATE_CHECK_CURRENT_VERSION' => "    Versión actual: %s\n",
	'TASK_PLUGINS_UPDATE_CHECK_AVAILABLE' => "      ¡Actualización disponible!\n",
	'TASK_PLUGINS_UPDATE_CHECK_UPDATE' => "  Para actualizar tus plugins a la versión actual ejecuta el siguiente comando:\n\n",
	'TASK_PLUGINS_UPDATE_NO_PLUGINS' => " No hay ningún plugin instalado.\n",
	'TASK_PLUGINS_UPDATE_CHECKING' => "  Buscando actualizaciones...\n\n",
	'TASK_PLUGINS_UPDATE_INSTALLED_VERSION' => "    Versión instalada: %s\n",
	'TASK_PLUGINS_UPDATE_CURRENT_VERSION' => "    Versión actual: %s\n",
	'TASK_PLUGINS_UPDATE_UPDATING' => "    Preparando actualización...\n",
	'TASK_PLUGINS_UPDATE_TO_BE_DELETED' => "      El archivo \"%s\" será eliminado.\n",
	'TASK_PLUGINS_UPDATE_FILE_NOT_FOUND' => 'El archivo "%s" no existe.',
	'TASK_PLUGINS_UPDATE_DOWNLOADING' => "      Descargando \"%s\"\n",
	'TASK_PLUGINS_UPDATE_FILE_EXISTS' => "        El archivo ya existe, creando copia de seguridad.\n",
	'TASK_PLUGINS_UPDATE_FILE_UPDATED' => "        Archivo actualizado.\n",
	'TASK_PLUGINS_UPDATE_NEW_FILE' => "        Nuevo archivo creado.\n",
	'TASK_PLUGINS_UPDATE_VERSION_UPDATED' => "      Actualizando archivo de versión.\n",
	'TASK_PLUGINS_UPDATE_DONE' => "    Actualización terminada.\n",
	'TASK_PLUGINS_DEFAULT_NOT_VALID' => 'El comando indicado no es una opción válida.',
	'TASK_PLUGINS_DEFAULT_AVAILABLE_OPTIONS' => "  Las opciones disponibles son:\n\n",
	'TASK_PLUGINS_DEFAULT_LIST' => 'Lista de plugins instalados.',
	'TASK_PLUGINS_DEFAULT_INSTALL' => 'Para instalar un nuevo plugin.',
	'TASK_PLUGINS_DEFAULT_REMOVE' => 'Para borrar un plugin instalado.',
	'TASK_PLUGINS_DEFAULT_NO_OPTION' => "  En caso de no indicar ningún parámetro se muestra la lista de plugins que se pueden instalar.\n\n",
	'TASK_UPDATE' => 'Función para actualizar el Framework.',
	'TASK_UPDATE_AVAILABLE' => "Se han encontrado %s actualizaciones pendientes. Se procede a la instalación ordenada.",
	'TASK_UPDATE_FILE_DELETE' => " El archivo \"%s\" será eliminado.\n",
	'TASK_UPDATE_NOT_FOUND' => "El archivo \"%s\" no se encuentra.",
	'TASK_UPDATE_DOWNLOADING' => "  Descargando \"%s\"\n",
	'TASK_UPDATE_FILE_EXISTS' => "    El archivo ya existe, creando copia de seguridad.\n",
	'TASK_UPDATE_NEW_FILE' => "    Creando nuevo archivo.\n",
	'TASK_UPDATE_ALL_UPDATED' => "Todos los archivos han sido actualizados. La nueva versión instalada es: %s",
	'TASK_UPDATE_DELETE_BACKUPS' => "  Se procede a eliminar las copias de seguridad realizadas.\n",
	'TASK_UPDATE_UPDATE_ERROR' => "Ocurrió un error al actualizar los archivos, se procede a restaurar las copias de seguridad.",
	'TASK_UPDATE_INSTALLED_VERSION' => "  Versión instalada: %s\n",
	'TASK_UPDATE_CURRENT_VERSION' => "  Versión actual:    %s\n\n",
	'TASK_UPDATE_UPDATING' => "  Se procede a la actualización.\n",
	'TASK_UPDATE_UPDATED' => 'La versión instalada está actualizada.',
	'TASK_UPDATE_NEWER' => '¡¡La versión instalada está MÁS actualizada que la del repositorio!!',
	'TASK_UPDATE_CHECK' => 'Función para comprobar si existen actualizaciones del Framework.',
	'TASK_UPDATE_CHECK_DO_UPDATE' => "  Para proceder a la actualización ejecuta el siguiente comando:\n\n",
	'TASK_UPDATE_CHECK_INSTALLED_VERSION' => "  Versión instalada: %s\n",
	'TASK_UPDATE_CHECK_CURRENT_VERSION' => "  Versión actual:    %s\n\n",
	'TASK_UPDATE_CHECK_LIST' => "  La actualización modificará los siguientes archivos:\n",
	'TASK_UPDATE_CHECK_UPDATED' => 'La versión instalada está actualizada.',
	'TASK_UPDATE_CHECK_NEWER' => '¡¡La versión instalada está MÁS actualizada que la del repositorio!!',
	'TASK_UPDATE_URLS' => 'Función para crear nuevos controladores y acciones a partir del archivo de urls.',
	'TASK_UPDATE_URLS_UPDATING' => "  Actualizando módulos/controladores...\n\n",
	'TASK_UPDATE_URLS_RESERVED' => "El nombre del módulo es una palabra reservada (%s). El módulo no puede llamarse de las siguientes maneras:",
	'TASK_UPDATE_URLS_ACTION_MODULE' => "Una acción no puede llamarse igual que el módulo que la contiene:",
	'TASK_UPDATE_URLS_NEW_CONTROLLER' => "  Nuevo controlador %s creado en el archivo %s.\n",
	'TASK_UPDATE_URLS_NEW_TEMPLATE_FOLDER' => "  Nueva carpeta para templates %s creada.\n",
	'TASK_UPDATE_URLS_NEW_ACTION' => "  Nueva acción %s creada en el controlador %s.\n",
	'TASK_UPDATE_URLS_NEW_TEMPLATE' => "  Nuevo template %s creado.\n",
	'TASK_UPDATE_URLS_ERROR' => "  Ocurrieron errores al actualizar módulos y controladores. Revisa los errores y vuelve a ejecutar la tarea updateUrls",
	'TASK_VERSION' => 'Función para obtener el número de versión actual del Framework.',
	'OFW_INDICATE_OPTION' => "Tienes que indicar una opción.\n\n",
	'OFW_OPTIONS' => "  Opciones:\n",
	'OFW_EXAMPLE' => 'Por ejemplo',
	'OFW_WRONG_OPTION' => "\nLa opción \"%s\" no es correcta.\n\n"
];