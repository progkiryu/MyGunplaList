import subprocess
import webbrowser

php_path = "C:/Users/Denver Klein Mesa/Desktop/MyGunplaList"

subprocess.Popen(["php", "-S", "localhost:8000", "-t", php_path])

webbrowser.open("http://localhost:8000/views/login.php")