Getting the apache file server to serve the correct stuff is quite the pain
Firstly, symlink the file in the Git repo
```
ln -s /patgh/to/github/dir /opt/lampp/htdocs
```
For some weird reason make home dir exec
```
chmod +x /home/username
```
Give perms for file to XAMPP
```
chmod 0777 /path/to/file
```
 
