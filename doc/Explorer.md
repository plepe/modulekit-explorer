Class `Explorer`
================
Constructor: `new Explorer($base_path, $options)`
-------------------------------------------------
Creates a new explorer instance.

* base_path: base path to the directory to be explored
* options:
  * 

Function `get($path)`
---------------------
Return an object of type ExplorerPath (if the path exists, otherwise null).

Function `register_file_type($id, $class)`
------------------------------------------
Registers an additional file type. For a specified file, several types
* id: id of the filetype, e.g. 'image'
* a class which extends the base class [ExplorerFileType](ExplorerFileType.md)

Function `registered_file_types()`
----------------------------------
Return list of registered file types.

Function `register_action($id, $class)`
---------------------------------------
Registers actions for files, e.g. download, create zip archive, execute, ...
* id: id of the action, e.g. 'download'
* a class which extends the base class [ExplorerAction](ExplorerAction.md)

Function `registered_actions()`
----------------------------------
Return list of registered actions.

Function `show($view='view')`
-----------------------------
Load the path from GET parameters and show the given path by the specified view.
