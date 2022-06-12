## About

FileManager class is wrapper for PHP File System Related Extensions [http://www.php.net/manual/en/refs.fileprocess.file.php](http://www.php.net/manual/en/refs.fileprocess.file.php). This class gives me ability to use File System Related Extensions through OOP, and improves shortcomings of built in PHP functions such as deleteDir(), copyDir(), renameDir() etc. For example, deleteDir() method can delete directory even if its not empty.

## How to use

Simply include and instantiate FileManager class:

<pre>
require_once('FileManager.php')
$fm = new FileManager();
</pre>

And from there you have these methods available:

<pre>
createFile($path)
deleteFile($path)
renameFile($oldname, $newname)
readFile($file)
copyFile($source, $destination)
fileSize($path)
filePerms($path)
setFilePerms($file, $perms)
createDir($path, $perm)
deleteDir($path)
renameDir($oldname, $newname)
readDir($path)
copyDir($source, $destination)
dirSize($path)
dirPerms($path)
setDirPerms($path, $perms)
currentDir()
isDir($path)
isExacutable($path)
isFile($path)
isLink($path)
isReadable($path)
isUploadedFile($path)
isWritable($path)
diskFreeSpace($drive)
diskTotalSpace($drive)
</pre>

You can see by the method names what each of them do, they are pretty self explanatory.

## Future development

I will probably add countItems method that would count files and dirs inside a directory. And countFiles and countDirs methods to count files and directories inside a directory. I think it can be useful to paginate lets say images that are stored inside a folder. So you dont have to store informations about every images in relation database. And them maybe write ImagesInspector class that could return image name, type, date etc. to inspect image information. That way you could really avoid using database to store informations about images. You could just read everything right from images folder. Thats it!
