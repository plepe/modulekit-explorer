Base Class `ExplorerAction`
=============================
Properties:
* title: title of the action
* weight: order of actions to be presented (higher last)
* mime_types: list of mime types
* not_mime_types: all mime types but not those in list

Function `match(ExplorerPath $file)`
------------------------------------
a function which decides whether the action is available for the specified file. Return true if yes.

Function `link(ExplorerPath $file)`
-----------------------------------
The link to which the action will point. Default: ?path=[filename]&action=action_id
