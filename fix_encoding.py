import os

filepath = r'app/Views/home/index.php'
with open(filepath, 'r', encoding='utf-8') as f:
    content = f.read()

content = content.replace('Capac├¡tate', 'Capacítate')
content = content.replace('Descubrir m├ís', 'Descubrir más')
content = content.replace('Especial├¡zate', 'Especialízate')
content = content.replace('Ingenier├¡a', 'Ingeniería')
content = content.replace('El├®ctrica', 'Eléctrica')

with open(filepath, 'w', encoding='utf-8') as f:
    f.write(content)
print("Fixed encoding.")
