import re
import os

filepath = r'assets/css/modern_override.css'
with open(filepath, 'r', encoding='utf-8') as f:
    content = f.read()

# Remove .main-header-one__bottom
content = re.sub(r'\.main-header-one__bottom\s*\{[^}]+\}', '', content)

# Remove .main-menu__list>li>a
content = re.sub(r'\.main-menu__list>li>a\s*\{[^}]+\}', '', content)

# Remove hover
content = re.sub(r'\.main-menu__list>li>a:hover,\s*\.main-menu__list>li\.current>a\s*\{[^}]+\}', '', content)

with open(filepath, 'w', encoding='utf-8') as f:
    f.write(content)
print("Removed white navbar styles.")
