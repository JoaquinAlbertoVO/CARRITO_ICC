import os
import re

old_filepath = r'temp_index.php'
new_filepath = r'app/Views/home/index.php'

with open(old_filepath, 'r', encoding='utf-16le', errors='ignore') as f:
    old_content = f.read()

with open(new_filepath, 'r', encoding='utf-8', errors='ignore') as f:
    new_content = f.read()

start_marker = '<div class="swiper-wrapper">'
end_marker = '</div>\n                <!-- If we need navigation buttons -->'

if start_marker in old_content and end_marker in old_content:
    old_start = old_content.find(start_marker)
    old_end = old_content.find(end_marker)
    slider_html = old_content[old_start:old_end]
    
    new_start = new_content.find(start_marker)
    new_end = new_content.find(end_marker)
    
    if new_start != -1 and new_end != -1:
        final_content = new_content[:new_start] + slider_html + new_content[new_end:]
        with open(new_filepath, 'w', encoding='utf-8') as f:
            f.write(final_content)
        print("Successfully reverted slider to 2755db6 version.")
    else:
        print("Markers not found in new file.")
else:
    print("Markers not found in old file.")
