To use this installation please follow these steps:

1) Download XAMPP with MySQL and Apache.
2) Open the XAMPP Control Panel and through the Config for Apache, select httpd.conf:
    Find DocumentRoot and change it such that it has the absolute path to the website directory, for example:
    DocumentRoot "C:\Users\USERNAME\sw707e14\website"
    also important to change the line below to match the path.
    <Directory "C:\Users\USERNAME\sw707e14\website">

3) Open the MySQL Admin page, PHPMyAdmin and add a privileged user called 'sw707e14' with the password 'saledes'.
4) Add a table called bicycle-db and a table called bicycle-local.
5) Select bicycle-db, on that page select import and choose the file called 'createschema.sql' in the DB directory and press Go.
6) Select bicycle-local, on that page select import and choose the file called 'bicycle-local.sql' in the DB directory and press Go.

Then visit the localhost and try to login, if everything was done correctly it should work.