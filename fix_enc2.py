import os

filepath = r'app/Views/home/index.php'
with open(filepath, 'r', encoding='utf-8', errors='ignore') as f:
    content = f.read()
    
original = content

replacements = {
    'mÃ¡ses encontrarÃ¡s': 'meses encontrarás',
    'mÃ¡ses': 'meses',
    'encontrarÃ¡s': 'encontrarás',
    'damÃ¡s': 'damos',
    'INGENIERÃ\x9aA_courses': 'ingenieria_courses',
    '': '', # just in case
    'INGENIERÃ\x9aA': 'INGENIERÍA',
    'INGENIER\xc3\x83\xc2\x9aA': 'INGENIERÍA',
    'El\xc3\x83\xc2\xa9ctrica': 'Eléctrica'
}

for bad, good in replacements.items():
    content = content.replace(bad, good)
    
# also regex for ..._courses
import re
content = re.sub(r'\.*?_courses', '', content)

if content != original:
    with open(filepath, 'w', encoding='utf-8') as f:
        f.write(content)
    print("Fixed index.php")
else:
    print("No changes needed in index.php")
