<?php
header("Content-Type: text/plain");
header("Set-Cookie: prueba_php=12345; Path=/; HttpOnly; SameSite=Lax");
echo "Prueba PHP correcta";
