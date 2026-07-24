import fitz
from PIL import Image
from pyzbar.pyzbar import decode
import qrcode
import urllib.parse
import os

def test_qr_bottom_left(input_pdf, output_pdf):
    doc = fitz.open(input_pdf)
    page = doc.load_page(0) # First page only
    
    # 1. Decode to find old QR and cover it
    pix = page.get_pixmap(dpi=300)
    img = Image.frombytes("RGB", [pix.width, pix.height], pix.samples)
    decoded_objects = decode(img)
    
    factor = 72 / 300
    for obj in decoded_objects:
        rect = obj.rect
        x0 = rect.left * factor
        y0 = rect.top * factor
        x1 = (rect.left + rect.width) * factor
        y1 = (rect.top + rect.height) * factor
        
        # Draw white rectangle over old QR
        pad = 2.0
        pdf_rect = fitz.Rect(x0 - pad, y0 - pad, x1 + pad, y1 + pad)
        page.draw_rect(pdf_rect, color=(1, 1, 1), fill=(1, 1, 1))

    # 2. Generate new URL
    base_name = os.path.basename(input_pdf)
    clean_name = base_name.replace(" ", "_")
    new_url = f"https://icc.com.pe/qr/{clean_name}"
    
    # 3. Create new QR
    qr = qrcode.QRCode(
        version=1,
        error_correction=qrcode.constants.ERROR_CORRECT_M,
        box_size=10,
        border=1,
    )
    qr.add_data(new_url)
    qr.make(fit=True)
    qr_img = qr.make_image(fill_color="black", back_color="white")
    qr_img_path = "temp_qr_bl.png"
    qr_img.save(qr_img_path)
    
    # 4. Insert at bottom left
    page_width = page.rect.width
    page_height = page.rect.height
    
    qr_size = 90
    
    # Guessing coordinates for the box drawn by the user:
    # Based on the image, the box is placed above the date on the left side.
    # The date is at the very bottom.
    margin_left = 60
    margin_bottom = 150 # Distance from bottom of the page to top of the QR
    
    x0 = margin_left
    y0 = page_height - margin_bottom
    x1 = x0 + qr_size
    y1 = y0 + qr_size
    
    new_qr_rect = fitz.Rect(x0, y0, x1, y1)
    page.insert_image(new_qr_rect, filename=qr_img_path)
    
    # Remove extra pages
    if len(doc) > 1:
        doc.delete_pages(from_page=1, to_page=len(doc)-1)
        
    doc.save(output_pdf)
    doc.close()
    
    if os.path.exists(qr_img_path):
        os.remove(qr_img_path)
    print(f"Processed test file: {output_pdf}")

if __name__ == "__main__":
    input_pdf = r"C:\Users\Joaquin\Desktop\ICC QR\BENAVIDES DAZA JOSE LUIS.pdf"
    output_pdf = r"C:\Users\Joaquin\Desktop\CARRITO\test_qr_bottom_left.pdf"
    test_qr_bottom_left(input_pdf, output_pdf)
