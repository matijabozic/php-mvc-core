<?php

/**
 * This file is part of MVC Core framework
 * (c) Matija Božić, www.matijabozic.com
 * 
 * FileManager class is wrapper for PHP File System Related Extensions
 * http://www.php.net/manual/en/refs.fileprocess.file.php
 * 
 * This class gives me ability to use File System Related Extensions in
 * Object Oriented manier. And improves shortcomings of buildin PHP
 * functions such as deleteDir(), copyDir(), renameDir() ...
 * 
 * @package    File Manager
 * @author     Matija Božić <matijabozic@gmx.com>
 * @license    MIT - http://opensource.org/licenses/MIT
 */

class FileManager
{
    /**
     * Creates new empty file
     * 
     * @access  public 
     * @param   string
     * @return  bool
     */

    public function createFile($path)
    {
        if (is_file($path)) {
            return false;
        }

        if ($handle = fopen($path, "w+")) {
            fclose($handle);
            return true;
        }

        return false;
    }

    /**
     * Deletes file
     * 
     * @access  public
     * @param   string
     * @return  bool
     */

    public function deleteFile($path)
    {
        if (!is_file($path)) {
            return false;
        }

        if (unlink($path)) {
            return true;
        }

        return false;
    }

    /**
     * Rename file
     * 
     * @access  public
     * @param   string
     * @param   string
     * @return  bool
     */

    public function renameFile($oldname, $newname)
    {
        if (!is_file($oldname)) {
            return false;
        }

        if (rename($oldname, $newname)) {
            return true;
        }

        return false;
    }

    /**
     * Returns content of given file
     * 
     * @access  public
     * @param   string
     * @return  string
     */

    public function readFile($file)
    {
        if (!is_file($file)) {
            return false;
        }

        if ($content = file_get_contents($file)) {
            return $content;
        }

        return false;
    }

    /**
     * Copy file to another location 
     * 
     * @access  public
     * @param   string
     * @param   string
     * @return  bool
     */

    public function copyFile($source, $destination)
    {
        if (!is_file($source) || is_dir($destination)) {
            return false;
        }

        if (copy($source, $destination)) {
            return true;
        }

        return false;
    }

    /**
     * Returns file size in bytes
     * 
     * @access  public
     * @param   string
     * @return  integer 
     */

    public function fileSize($path)
    {
        if (!is_file($path)) {
            return false;
        }

        return filesize($path);
    }

    /**
     * Returns file permissions as an octal value
     * 
     * @access  public
     * @param   string
     * @return  integer
     */

    public function filePerms($path)
    {
        if (!is_file($path)) {
            return false;
        }

        return substr(sprintf('%o', fileperms($path)), -4);
    }

    /**
     * Sets file permissions
     * 
     * @access  public
     * @param   string
     * @param   integer
     * @return  bool
     */

    public function setFilePerms($file, $perms)
    {
        if (!is_file($file)) {
            return false;
        }

        if (chmod($file, $perms)) {
            return true;
        }

        return false;
    }

    /**
     * Creates new directory
     * 
     * @access  public
     * @param   string
     * @param   integer
     * @return  bool
     */

    public function createDir($path, $perm = 0700)
    {
        if (mkdir($path, $perm)) {
            return true;
        } else return false;
    }

    /**
     * Deletes directory and all directory subfolders and files
     * 
     * @access  public
     * @param   string
     * @return  bool
     */

    public function deleteDir($path)
    {
        if (!is_dir($path)) {
            return false;
        }

        $files = scandir($path);
        $files = array_diff($files, array('.', '..'));

        foreach ($files as $file) {
            if (!is_dir($path . DIRECTORY_SEPARATOR . $file)) {
                unlink($path . DIRECTORY_SEPARATOR . $file);
            } else {
                $this->deleteDir($path . DIRECTORY_SEPARATOR . $file);
            }
        }

        rmdir($path);
        return true;
    }

    /**
     * Renames directory
     * 
     * @access  public
     * @param   string
     * @param   string
     * @return  bool
     */

    public function renameDir($oldname, $newname)
    {
        if (!is_dir($oldname)) {
            return false;
        }

        if (rename($oldname, $newname)) {
            return true;
        }

        return false;
    }

    /**
     * Reads directory contents and returns array
     * 
     * @access  public
     * @param   string
     * @return  array
     */

    public function readDir($path)
    {
        if (!is_dir($path)) {
            return false;
        }

        $files = scandir($path);
        $files = array_diff($files, array('.', '..'));
        $files = array_values($files);
        return $files;
    }

    /**
     * Copy directory to another location
     * 
     * @access  public
     * @param   string
     * @param   string
     * @return  bool
     */

    public function copyDir($source, $destination)
    {
        if (!is_dir($source) || is_dir($destination)) {
            return false;
        }

        mkdir($destination);

        $files = scandir($source);
        $files = array_diff($files, array('.', '..'));

        foreach ($files as $file) {
            $src_file = $source . DIRECTORY_SEPARATOR . $file;
            $dst_file = $destination . DIRECTORY_SEPARATOR . $file;

            if (is_dir($src_file)) {
                $this->copyDir($src_file, $dst_file);
            } else {
                copy($src_file, $dst_file);
            }
        }

        return true;
    }

    /**
     * Returns directory size in bytes
     * 
     * @access  public
     * @param   string
     * @return  integer
     *  
     */

    public function dirSize($path)
    {
        if (!is_dir($path)) {
            return false;
        }

        $size = 0;

        $files = scandir($path);
        $files = array_diff($files, array('.', '..'));

        foreach ($files as $file) {
            $filepath = $path . DIRECTORY_SEPARATOR . $file;

            if (is_dir($filepath)) {
                $size += $this->dirSize($filepath);
            } else if (is_file($filepath)) {
                $size += filesize($filepath);
            }
        }

        return $size;
    }

    /**
     * Returns directory permissions as an octal value
     * 
     * @access  public
     * @param   string
     * @return  integer
     */

    public function dirPerms($path)
    {
        if (!is_dir($path)) {
            return false;
        }

        return substr(sprintf('%o', fileperms($path)), -4);
    }

    /**
     * Sets directory permissions
     * 
     * @access  public
     * @param   string
     * @param   integer
     * @return  bool
     */

    public function setDirPerms($path, $perms)
    {
        if (!is_dir($path)) {
            return false;
        }

        if (chmod($path, $perms)) {
            return true;
        }

        return false;
    }

    /**
     * Returns current working directory
     * 
     * @access  public
     * @return  string
     */

    public function currentDir()
    {
        if ($dir = getcwd()) {
            return $dir;
        }

        return false;
    }

    /**
     * Checks if given path is directory
     * 
     * @access  public
     * @param   string
     * @return  bool
     */

    public function isDir($path)
    {
        if (is_dir($path)) {
            return true;
        }

        return false;
    }

    /**
     * Checks if given path is executable
     * 
     * @access  public
     * @param   string
     * @return  bool
     */

    public function isExecutable($path)
    {
        if (is_executable($path)) {
            return true;
        }

        return false;
    }

    /**
     * Checks if given path is file
     * 
     * @access  public
     * @param   string
     * @return  bool
     */

    public function isFile($path)
    {
        if (is_file($path)) {
            return true;
        }

        return false;
    }

    /**
     * Checks if given path is a link
     * 
     * @access  public
     * @param   string
     * @return  bool
     */

    public function isLink($path)
    {
        if (is_link($path)) {
            return true;
        }

        return false;
    }

    /**
     * Checks if given path is readable
     * 
     * @access  public
     * @param   string
     * @return  bool
     */

    public function isReadable($path)
    {
        if (is_readable($path)) {
            return true;
        }

        return false;
    }

    /**
     * Checks if given path is uploaded file
     * 
     * @access  public
     * @param   string
     * @return  bool
     */

    public function isUploadedFile($path)
    {
        if (is_uploaded_file($path)) {
            return true;
        }

        return false;
    }

    /**
     * Checks if given path is writable
     * 
     * @access  public
     * @param   string
     * @return  bool
     */

    public function isWritable($path)
    {
        if (is_writable($path)) {
            return true;
        }

        return false;
    }

    /**
     * Returns drive free space
     * 
     * @access  public
     * @param   string
     * @return  integer
     */

    public function diskFreeSpace($drive)
    {
        return disk_free_space($drive);
    }

    /**
     * Returns drive total size
     * 
     * @access  public
     * @param   string
     * @return  integer
     */

    public function diskTotalSpace($drive)
    {
        return disk_total_space($drive);
    }
}
