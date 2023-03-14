openssl genrsa -out "./default.key" 2048
chmod 644 ./default.key
openssl req -new -key "./default.key" -out "./default.csr" -subj "/CN=default/O=default/C=UK"
openssl x509 -req -days 365 -in "./default.csr" -signkey "./default.key" -out "./default.crt"
