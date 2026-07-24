import os

filepath = r'app/Views/layouts/main.php'
with open(filepath, 'r', encoding='utf-8') as f:
    content = f.read()

content = content.replace('<div class="page-wrapper"><main>', '<div class="page-wrapper">')
content = content.replace('</main></body>', '</body>')

with open(filepath, 'w', encoding='utf-8') as f:
    f.write(content)
print("Removed main tag.")
