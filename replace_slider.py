import os
import re

filepath = r'app/Views/home/index.php'
with open(filepath, 'r', encoding='utf-8', errors='ignore') as f:
    content = f.read()

# I want to completely replace the swiper-wrapper contents.
# Let's find <div class="swiper-wrapper"> and the end of the swiper.

start_marker = '<div class="swiper-wrapper">'
end_marker = '</div>\n                <!-- If we need navigation buttons -->'

if start_marker in content and end_marker in content:
    start_idx = content.find(start_marker) + len(start_marker)
    end_idx = content.find(end_marker)
    
    new_slides = '''
                    <!--Start Single Swiper Slide 1-->
                    <div class="swiper-slide">
                        <div class="image-layer"
                            style="background: url('<?= BASE_URL ?>assets/images/banner_icc.jpg') center/cover no-repeat;"></div>
                        <div class="image-layer-overlay" style="background: rgba(0,0,0,0);"></div>
                        <!-- Texto removido porque el banner ya tiene el texto integrado -->
                    </div>
                    <!--End Single Swiper Slide 1-->

                    <!--Start Single Swiper Slide 2-->
                    <div class="swiper-slide">
                        <div class="image-layer"
                            style="background: url('<?= BASE_URL ?>assets/images/banner_icc_2.jpg') center/cover no-repeat; background-color: #0f2027;"></div>
                        <div class="image-layer-overlay" style="background: rgba(0,0,0,0);"></div>
                    </div>
                    <!--End Single Swiper Slide 2-->

                    <!--Start Single Swiper Slide 3-->
                    <div class="swiper-slide">
                        <div class="image-layer"
                            style="background: url('<?= BASE_URL ?>assets/images/banner_icc_3.jpg') center/cover no-repeat; background-color: #0f2027;"></div>
                        <div class="image-layer-overlay" style="background: rgba(0,0,0,0);"></div>
                    </div>
                    <!--End Single Swiper Slide 3-->
                '''
    
    content = content[:start_idx] + '\n' + new_slides + content[end_idx:]
    with open(filepath, 'w', encoding='utf-8') as f:
        f.write(content)
    print("Replaced slider contents.")
else:
    print("Markers not found.")
