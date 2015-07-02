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
