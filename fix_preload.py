import os

filepath = r'app/Views/layouts/main.php'
with open(filepath, 'r', encoding='utf-8') as f:
    content = f.read()

content = content.replace('banner_icc.jpg', 'banner_icc.png')

with open(filepath, 'w', encoding='utf-8') as f:
    f.write(content)
print("Updated main.php preload.")
