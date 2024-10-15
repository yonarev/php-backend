# ESTA FUNCION COPIA DE UNA CARPETA A OTRA
import shutil
import os

source_dir = 'C:/Users/notebook/Documents/janvera/ARCHIVOSLAB/ESTUDIOS/PHP-BACK-END-capacitate/SIS'
destination_dir = 'C:/xampp/htdocs/dashboard'

for filename in os.listdir(source_dir):
    file_path = os.path.join(source_dir, filename)
    if os.path.isfile(file_path):
        shutil.copy2(file_path, destination_dir)
# c:/Users/notebook/AppData/Local/Microsoft/WindowsApps/python3.12.exe copia-codigo.py