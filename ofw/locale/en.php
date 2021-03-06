<?php
$locale = [
	'ERROR_TITLE' => 'Error',
	'ERROR_403_LABEL' => '403 Authentication error',
	'ERROR_404_LABEL' => '404 Page not found',
	'ERROR_NO_MODULE_LABEL' => 'Module <strong>%s</strong> not found',
	'ERROR_NO_ACTION_LABEL' => 'Function <strong>%s</strong> not found on <strong>%s</strong> module',
	'ERROR_SEE_MORE_LABEL' => 'See more details',
	'TASK_BACKUP_ALL' => 'Generate a backup file (composer file) of the whole application (database and code). Calls internally to "backupDB" and "composer" tasks.',
	'TASK_BACKUP_ALL_DONE' => 'Backup complete',
	'TASK_BACKUP_DB' => 'Performs a database backup using "mysqldump" CLI tool. Generates a file on ofw/export folder with the name of the database.',
	'TASK_BACKUP_DB_NO_DB' => 'There is no database configured.',
	'TASK_BACKUP_DB_EXPORTING' => "  Exporting \"%s\" database to file \"%s\"\n\n",
	'TASK_BACKUP_DB_EXISTS' => "    Destiny file already existed, it has been deleted.\n\n",
	'TASK_BACKUP_DB_SUCCESS' => "  Database successfully exported.\n\n",
	'TASK_EXTRACTOR' => 'Function to export an application with all its files to a single self-extracting php file',
	'TASK_EXTRACTOR_EXPORTING' => 'Exporting project',
	'TASK_EXTRACTOR_EXISTS' => "    Destiny file already existed, it has been deleted.\n\n",
	'TASK_EXTRACTOR_GETTING_FILES' => "  Getting folders and files to export...\n",
	'TASK_EXTRACTOR_EXPORTING_FILES' => "  Exporting %s files.\n",
	'TASK_EXTRACTOR_EXPORTING_FOLDERS' => "  Exporting %s folders.\n",
	'TASK_EXTRACTOR_GETTING_READY' => "  Preparing composer...\n",
	'TASK_EXTRACTOR_BASE_FOLDER' => 'BASE PATH',
	'TASK_EXTRACTOR_CREATE_FOLDERS' => 'CREATING FOLDERS',
	'TASK_EXTRACTOR_CREATE_FILES' => 'CREATING FILES',
	'TASK_EXTRACTOR_END' => 'Project has been exported.',
	'TASK_GENERATE_MODEL' => 'Generate a SQL file to create all the tables in the database based on user defined models (file generated on ofw/export).',
	'TASK_GENERATE_MODEL_MODEL' => "Model\n\n",
	'TASK_PLUGINS' => 'Task to manage plugins (list available / install / remove)',
	'TASK_PLUGINS_AVAILABLE_TITLE' => "  Available plugin list:\n\n",
	'TASK_PLUGINS_AVAILABLE_INSTALL' => "  To install any of the plugins run the following command:\n\n",
	'TASK_PLUGINS_AVAILABLE_LIST' => "  You can also see the plugin list that are currently installed running the following command:\n\n",
	'TASK_PLUGINS_AVAILABLE_DELETE' => "  To remove a plugin that is currently installed run the following command:\n\n",
	'TASK_PLUGINS_AVAILABLE_NAME' => 'name',
	'TASK_PLUGINS_INSTALL_ERROR' => 'You must indicate the name of the plugin you want to install, for example:',
	'TASK_PLUGINS_INSTALL_NOT_AVAILABLE' => 'The indicated plugin does not exist in the list of installable plugins.',
	'TASK_PLUGINS_INSTALL_CHECK_LIST' => "  Check the list by running the following command:\n\n",
	'TASK_PLUGINS_INSTALL_FOLDER_EXISTS' => 'Folder "%s" already exists.',
	'TASK_PLUGINS_INSTALL_CREATE_FOLDER' => "  New folder created: \"%s\"\n",
	'TASK_PLUGINS_INSTALL_CREATE_CONFIG' => "  Creating plugin configuration file: \"%s/%s.json\"\n",
	'TASK_PLUGINS_INSTALL_CREATE_FILE' => "  Plugin file created: \"%s/%s\"\n",
	'TASK_PLUGINS_INSTALL_DOWNLOAD_DEPS' => "  Downloading dependencies:\n",
	'TASK_PLUGINS_INSTALL_NEW_DEP' => "    New file created: \"%s/dependencies/%s\"\n",
	'TASK_PLUGINS_INSTALL_UPDATED' => "  Plugin list updated.\n\n",
	'TASK_PLUGINS_INSTALL_DONE' => "  Installation complete.\n\n",
	'TASK_PLUGINS_INSTALLED' => "  Installed plugins:\n\n",
	'TASK_PLUGINS_INSTALLED_NONE' => "  There is no plugin installed.\n\n",
	'TASK_PLUGINS_REMOVE_ERROR' => 'You must indicate the name of the plugin you want to uninstall, for example:',
	'TASK_PLUGINS_REMOVE_NOT_INSTALLED' => 'Indicated plugin is not installed.',
	'TASK_PLUGINS_REMOVE_CHECK_LIST' => "  Check the list by running the following command:\n\n",
	'TASK_PLUGINS_REMOVE_FOLDER_NOT_FOUND' => 'Folder "%s" does not exist.',
	'TASK_PLUGINS_REMOVE_CONF_REMOVED' => "  Configuration file \"%s/%s.json\" deleted.\n",
	'TASK_PLUGINS_REMOVE_PLUGIN_REMOVED' => "  Plugin file \"%s/%s\" deleted.\n",
	'TASK_PLUGINS_REMOVE_REMOVING_DEPS' => "  Deleting dependencies...\n",
	'TASK_PLUGINS_REMOVE_DEP_REMOVED' => "    File \"%s\" deleted.\n",
	'TASK_PLUGINS_REMOVE_DEP_FOLDER_REMOVED' => "  Dependencies folder \"%s/dependencies\" deleted.\n",
	'TASK_PLUGINS_REMOVE_FOLDER_REMOVED' => "  Plugin folder \"%s\" deleted.\n",
	'TASK_PLUGINS_REMOVE_LIST_UPDATED' => "  Plugin list updated.\n\n",
	'TASK_PLUGINS_REMOVE_PLUGINS_REMOVED' => "  Configuration file \"%s\" has been deleted because there is no plugin installed currently.\n\n",
	'TASK_PLUGINS_REMOVE_DONE' => "  Remove complete.\n\n",
	'TASK_PLUGINS_UPDATE_CHECK_NO_PLUGINS' => " There is no plugin installed.\n",
	'TASK_PLUGINS_UPDATE_CHECK_CHECKING' => "  Looking for updates...\n\n",
	'TASK_PLUGINS_UPDATE_CHECK_VERSION' => "    Installed version: %s\n",
	'TASK_PLUGINS_UPDATE_CHECK_CURRENT_VERSION' => "    Current version: %s\n",
	'TASK_PLUGINS_UPDATE_CHECK_AVAILABLE' => "      Update available!\n",
	'TASK_PLUGINS_UPDATE_CHECK_UPDATE' => "  To update your plugins to the current version run the following command:\n\n",
	'TASK_PLUGINS_UPDATE_NO_PLUGINS' => " There is no plugin installed.\n",
	'TASK_PLUGINS_UPDATE_CHECKING' => "  Looking for updates...\n\n",
	'TASK_PLUGINS_UPDATE_INSTALLED_VERSION' => "    Installed version: %s\n",
	'TASK_PLUGINS_UPDATE_CURRENT_VERSION' => "    Current version: %s\n",
	'TASK_PLUGINS_UPDATE_UPDATING' => "    Preparing update...\n",
	'TASK_PLUGINS_UPDATE_TO_BE_DELETED' => "      File \"%s\" will be deleted.\n",
	'TASK_PLUGINS_UPDATE_FILE_NOT_FOUND' => 'File "%s" does not exist.',
	'TASK_PLUGINS_UPDATE_DOWNLOADING' => "      Downloading \"%s\"\n",
	'TASK_PLUGINS_UPDATE_FILE_EXISTS' => "        File already exists, creating backup.\n",
	'TASK_PLUGINS_UPDATE_FILE_UPDATED' => "        File updated.\n",
	'TASK_PLUGINS_UPDATE_NEW_FILE' => "        New file created.\n",
	'TASK_PLUGINS_UPDATE_VERSION_UPDATED' => "      Updating version file.\n",
	'TASK_PLUGINS_UPDATE_DONE' => "    Update complete.\n",
	'TASK_PLUGINS_DEFAULT_NOT_VALID' => 'Indicated command is not a valid option.',
	'TASK_PLUGINS_DEFAULT_AVAILABLE_OPTIONS' => "  Available options are:\n\n",
	'TASK_PLUGINS_DEFAULT_LIST' => 'Installed plugin list.',
	'TASK_PLUGINS_DEFAULT_INSTALL' => 'To install a new plugin.',
	'TASK_PLUGINS_DEFAULT_REMOVE' => 'To remove a currently installed plugin.',
	'TASK_PLUGINS_DEFAULT_NO_OPTION' => "  If you don't indicate any parameter the available plugin list is shown.\n\n",
	'TASK_UPDATE' => 'Update Framework files to a newer version.',
	'TASK_UPDATE_AVAILABLE' => "%s new updates have been found. Installation will begin in order.",
	'TASK_UPDATE_FILE_DELETE' => " File \"%s\" will be deleted.\n",
	'TASK_UPDATE_NOT_FOUND' => "File \"%s\" can't be found.",
	'TASK_UPDATE_DOWNLOADING' => "  Downloading \"%s\"\n",
	'TASK_UPDATE_FILE_EXISTS' => "    File already exists, creating backup.\n",
	'TASK_UPDATE_NEW_FILE' => "    Creating new file.\n",
	'TASK_UPDATE_ALL_UPDATED' => "All files have been updated. The new installed version is: %s",
	'TASK_UPDATE_DELETE_BACKUPS' => "  Created backups will be deleted.\n",
	'TASK_UPDATE_UPDATE_ERROR' => "An error has ocurred while updating the files, backups will be restored.",
	'TASK_UPDATE_INSTALLED_VERSION' => "  Installed version: %s\n",
	'TASK_UPDATE_CURRENT_VERSION' => "  Current version:    %s\n\n",
	'TASK_UPDATE_UPDATING' => "  Update will begin.\n",
	'TASK_UPDATE_UPDATED' => 'Installed version is up to date.',
	'TASK_UPDATE_NEWER' => 'Installed version is NEWER than the one in the repository!!',
	'TASK_UPDATE_CHECK' => 'Check if there are new updates on the Framework',
	'TASK_UPDATE_CHECK_DO_UPDATE' => "  To proceed to the update run the following command:\n\n",
	'TASK_UPDATE_CHECK_INSTALLED_VERSION' => "  Installed version: %s\n",
	'TASK_UPDATE_CHECK_CURRENT_VERSION' => "  Current version:   %s\n\n",
	'TASK_UPDATE_CHECK_LIST' => "  Update will modify the following files:\n",
	'TASK_UPDATE_CHECK_UPDATED' => 'Installed version is up to date.',
	'TASK_UPDATE_CHECK_NEWER' => 'Installed version is NEWER than the one in the repository!!',
	'TASK_UPDATE_URLS' => 'Creates new modules / actions / templates based on user configured urls.json',
	'TASK_UPDATE_URLS_UPDATING' => "  Updating modules/controllers...\n\n",
	'TASK_UPDATE_URLS_RESERVED' => "The name you picked for the module is a reserved word (%s). The module can't have this names:",
	'TASK_UPDATE_URLS_ACTION_MODULE' => "An action can't have the same name as the module it is contained in:",
	'TASK_UPDATE_URLS_NEW_CONTROLLER' => "  New controller %s created on file %s.\n",
	'TASK_UPDATE_URLS_NEW_TEMPLATE_FOLDER' => "  New template folder %s created.\n",
	'TASK_UPDATE_URLS_NEW_ACTION' => "  New action %s created on controller %s.\n",
	'TASK_UPDATE_URLS_NEW_TEMPLATE' => "  New template %s created.\n",
	'TASK_UPDATE_URLS_ERROR' => "  There were errors updating modules and controllers. Check the errors and run again the updateUrls task",
	'TASK_VERSION' => 'Get Frameworks current version information',
	'OFW_INDICATE_OPTION' => "You have to indicate an option.\n\n",
	'OFW_OPTIONS' => "  Options:\n",
	'OFW_EXAMPLE' => 'For example',
	'OFW_WRONG_OPTION' => "\nOption \"%s\" is wrong.\n\n"
];