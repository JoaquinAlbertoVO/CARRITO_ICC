import os
import re

files = [
    "index/header.php",
    "nosotros/header.php",
    "contacto/header.php",
    "cursos/header.php",
    "cursos_derecho/header.php",
    "cursos_ingenieria/header.php"
]

new_coupons = """    var cuponesValidos = {
        // INGENIERÍA ELÉCTRICA
        'TIKTOK-FACTURAS': { curso: 'Análisis de facturas y Evaluación de Tarifas E.', precio: 50, moneda: 'PEN' },
        'TIKTOK-BANCO': { curso: 'Banco de Condensadores', precio: 50, moneda: 'PEN' },
        'TIKTOK-ELECTRICIDAD': { curso: 'Electricidad Básica', precio: 50, moneda: 'PEN' },
        'TIKTOK-GESTION': { curso: 'Gestión y Seguridad en el Trabajo Ley Nº29783', precio: 50, moneda: 'PEN' },
        'TIKTOK-MOTORES': { curso: 'Motores Eléctricos', precio: 50, moneda: 'PEN' },
        'TIKTOK-PLC': { curso: 'Programación Básica de PLC', precio: 50, moneda: 'PEN' },
        'TIKTOK-TIERRA': { curso: 'Sistema Puesta a Tierra', precio: 50, moneda: 'PEN' },
        'TIKTOK-REGULACION': { curso: 'Regulación del Mercado de Energía', precio: 50, moneda: 'PEN' },
        'TIKTOK-REDES': { curso: 'Configuración e Instalación de Analizadores de redes', precio: 50, moneda: 'PEN' },

        // DERECHO Y GESTIÓN PÚBLICA
        'TIKTOK-DESALOJO': { curso: 'Proceso de Desalojo en la Corte Suprema', precio: 50, moneda: 'PEN' },
        'TIKTOK-REGLAMENTO': { curso: 'Modificaciones al Reglamento con el Estado', precio: 50, moneda: 'PEN' },
        'TIKTOK-CODIGO': { curso: 'Especialización Nuevo Código Penal', precio: 50, moneda: 'PEN' },
        'TIKTOK-LITIGACION': { curso: 'Litigación Oral en el nuevo Código Procesal Penal', precio: 50, moneda: 'PEN' },
        'TIKTOK-PENAL': { curso: 'Derecho Penal', precio: 50, moneda: 'PEN' },
        'TIKTOK-AMBIENTAL': { curso: 'Derecho Ambiental', precio: 50, moneda: 'PEN' },
        'TIKTOK-OBRA': { curso: 'Obra por Impuesto', precio: 50, moneda: 'PEN' }
    };"""

for f in files:
    if os.path.exists(f):
        with open(f, 'r', encoding='utf-8') as file:
            content = file.read()
        
        # Regex to replace the cuponesValidos object
        pattern = re.compile(r"var cuponesValidos = \{.*?\};", re.DOTALL)
        content = pattern.sub(new_coupons, content)
        
        with open(f, 'w', encoding='utf-8') as file:
            file.write(content)
        print("Updated", f)

print("Coupon update complete.")
