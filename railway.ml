buildCommand: |
  mkdir -p webroot
  cp -R ./* webroot/
  echo 'RewriteEngine On' > webroot/.htaccess
  echo 'RewriteCond %{REQUEST_FILENAME} !-f' >> webroot/.htaccess
  echo 'RewriteRule ^ index.php [QSA,L]' >> webroot/.htaccess

staticDirs:
  - webroot