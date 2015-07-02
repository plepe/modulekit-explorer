Base Class `ExplorerFileType`
=============================
Properties:
* weight: several file types might match a specific file. In that case, information from types with smaller weight will be processed first.
* mime_types: list of mime types
* not_mime_types: all mime types but not those in list
* icon: file name of icon

Function `match(ExplorerPath $file)`
------------------------------------
a function which decides whether the current file matches this file type. return true if yes.

Function `view(ExplorerPath $file)`
-----------------------------------
a function which will return the file in HTML encoded, viewable (for images this is: `<img src='raw.php?path=path' />`.

Function `info(ExplorerPath $file)`
-----------------------------------
A function which will return a list of formatted information about the path. See Function `ExplorerPath::info()` for details.

Function `thumbnail(ExplorerPath $file)`
----------------------------------------
thumbnail: A thumbnail of the current file, see function 'view'

Function `access(ExplorerPath $file)`
-------------------------------------
A function whether the file is accessible by the current user
