INSTALLATION
============
Use modulekit-explorer as standalone application:
```sh
git clone https://github.com/plepe/modulekit-explorer.git
cd modulekit-explorer
cp conf.php-dist conf.php
$EDITOR conf.php # adapt to your needs
```

Class Explorer
==============
Constructor: `new Explorer($base_path, $options)`
-------------------------------------------------
Creates a new explorer instance.

* base_path: base path to the directory to be explored
* options:
  * 

Function `get($path)`
---------------------
Return an object of type ExplorerPath (if the path exists, otherwise null).

Function `register_file_type($id, $options)`
--------------------------------------------
Registers an additional file type. For a specified file, several types
* id: id of the filetype, e.g. 'image'
* options:
  * weight: several file types might match a specific file. In that case, information from types with smaller weight will be processed first.
  * mime_types: list of mime types
  * not_mime_types: all mime types but not those in list
  * match: a function which decides whether the current file matches this file type. return true if yes.
  * view: a function which will return the file in HTML encoded, viewable (for images this is: `<img src='raw.php?path=path' />`.
  * info: a function which will return a list of formatted information about the path. See Function `info()` for details.
  * icon: file name of icon
  * thumbnail: A thumbnail of the current file, see option 'view'
  * access: a function whether the file is accessible by the current user

Function `registered_file_types()`
----------------------------------
Return list of registered file types.

Function `register_action($id, $options)`
-----------------------------------------
Registers actions for files, e.g. download, create zip archive, execute, ...
* id: id of the action, e.g. 'download'
* options:
  * title: title of the action
  * weight: order of actions to be presented (higher last)
  * mime_types: list of mime types
  * match: a function which decides whether the action is available on the specified file.

Function `registered_actions()`
----------------------------------
Return list of registered actions.

Class `ExplorerPath`
====================
* filename: name of the current file
* path: path inside the explored directory, including filename (array)
* parent: link to parent ExplorerPath (null for base directory)
* explorer: link to Explorer

Function `mime_type()`
----------------------
Returns mime type of File, e.g. 'directory' or 'image/png'.

Function `types()`
------------------
return ordered list of matching types. icons e.g. will be used from the top-most type if it is defined there.

Function `get_absolute_path()`
------------------------------
absolute path of the file, might be an extracted file from an archive in a temporary directory.

Function `get($path)`
---------------------
Return an instance of ExplorerPath specified by path below the current object.

Function `info()`
-----------------
Returns structured information about the path.

Example:
```json
{
  'path': path,
  'type': ['default'],
  'size': 13000,
  'icon': 'default.png',
  'thumbnail': null,
  'actions': [ 'download' ]
}
```

Function `content()`
--------------------
Returns the file content of the path. In case of a directory or an archive, this will be structured information.

Example:
```json
[
  {
    'name': 'foo.png',
    'type': ['image', 'default'],
    'size': 70000,
    'icon': 'image.png',
    'thumbnail': 'raw.php?path=path',
    'actions': [ 'view', 'download' ]
  },
  {
    'name': 'dir',
    'type': ['directory'],
    'size': null,
    'icon': 'directory.png',
    'actions': [ 'view', 'zip_download' ]
  }
]
```

Function `children()`
---------------------
Returns a list of ExplorerPath's which are children (resp. subdirectories) of
the current path.

Function `details()`
--------------------
Detailed formatted information about the current path (e.g. EXIF data).
```json
[
  {
    'size': {
      'name': "Filesize",
      'value': "13.6kiB",
      'weight: 0
    },
    '': {
      'name': "Exposure time",
      'value': "1/10s",
      'weight: 10
    }

  }
]
```

Function `render($action_id)`
-----------------------------
Return HTML rendered output.

Parameter:
* action_id: which action shall be rendered (default: 'view')

Function `show($action_id)`
-----------------------------
Like render, but include header and actions.

Parameter:
* action_id: which action shall be rendered (default: 'view')


Function `raw()`
----------------
Return file contents.
